<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use RuntimeException;
use Throwable;

final class AuthService
{
    private const IP_ATTEMPT_LIMIT = 10;
    private const ACCOUNT_ATTEMPT_LIMIT = 5;
    private const ATTEMPT_WINDOW_MINUTES = 15;
    private const IDLE_TIMEOUT_SECONDS = 1800;
    private const ABSOLUTE_TIMEOUT_SECONDS = 28800;
    private const DUMMY_PASSWORD_HASH = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.';

    public function login(string $email, string $password): bool
    {
        if (!Database::configured()) {
            throw new RuntimeException('Database connection is not configured.');
        }

        $normalizedEmail = mb_strtolower(trim($email));
        $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $ipHash = hash('sha256', 'ip:' . $ip);
        $accountHash = hash('sha256', 'account:' . $ip . ':' . $normalizedEmail);

        if ($this->isRateLimited($ipHash, $accountHash)) {
            return false;
        }

        $statement = Database::connection()->prepare(
            'SELECT id, name, email, password_hash
             FROM admins
             WHERE email = :email AND is_active = 1
             LIMIT 1'
        );
        $statement->execute(['email' => $normalizedEmail]);
        $admin = $statement->fetch();

        // Verify a dummy hash for unknown/inactive accounts to reduce timing-based enumeration.
        $hash = is_array($admin) ? (string) $admin['password_hash'] : self::DUMMY_PASSWORD_HASH;
        $passwordMatches = password_verify($password, $hash);

        if (!$admin || !$passwordMatches) {
            $this->recordFailedAttempt($ipHash, $accountHash);
            return false;
        }

        $this->clearAttempts($accountHash);
        session_regenerate_id(true);
        unset($_SESSION['_csrf']);
        $_SESSION['admin'] = [
            'id' => (int) $admin['id'],
            'name' => $admin['name'],
            'email' => $admin['email'],
        ];
        $_SESSION['auth_issued_at'] = time();
        $_SESSION['last_activity_at'] = time();

        if (password_needs_rehash($admin['password_hash'], PASSWORD_DEFAULT)) {
            $rehash = Database::connection()->prepare(
                'UPDATE admins SET password_hash = :password_hash WHERE id = :id'
            );
            $rehash->execute([
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $admin['id'],
            ]);
        }

        Database::connection()
            ->prepare('UPDATE admins SET last_login_at = NOW() WHERE id = :id')
            ->execute(['id' => $admin['id']]);

        return true;
    }

    public function logout(): void
    {
        unset(
            $_SESSION['admin'],
            $_SESSION['_csrf'],
            $_SESSION['auth_issued_at'],
            $_SESSION['last_activity_at']
        );
        session_regenerate_id(true);
    }

    public function check(): bool
    {
        if (!isset($_SESSION['admin']['id']) || !is_int($_SESSION['admin']['id'])) {
            return false;
        }

        if (!Database::configured()) {
            $this->invalidateSession();
            return false;
        }

        $now = time();
        $issuedAt = (int) ($_SESSION['auth_issued_at'] ?? 0);
        $lastActivity = (int) ($_SESSION['last_activity_at'] ?? 0);

        if ($issuedAt < 1 || $lastActivity < 1
            || ($now - $lastActivity) > self::IDLE_TIMEOUT_SECONDS
            || ($now - $issuedAt) > self::ABSOLUTE_TIMEOUT_SECONDS) {
            $this->invalidateSession();
            return false;
        }

        $statement = Database::connection()->prepare(
            'SELECT is_active FROM admins WHERE id = :id LIMIT 1'
        );
        $statement->execute(['id' => $_SESSION['admin']['id']]);
        $isActive = $statement->fetchColumn();

        if ($isActive === false || (int) $isActive !== 1) {
            $this->invalidateSession();
            return false;
        }

        $_SESSION['last_activity_at'] = $now;
        return true;
    }

    public function admin(): ?array
    {
        return $this->check() ? $_SESSION['admin'] : null;
    }

    private function isRateLimited(string $ipHash, string $accountHash): bool
    {
        $statement = Database::connection()->prepare(
            'SELECT COUNT(*)
             FROM login_attempts
             WHERE scope_hash IN (:ip_hash, :account_hash)
               AND blocked_until IS NOT NULL
               AND blocked_until > NOW()'
        );
        $statement->execute([
            'ip_hash' => $ipHash,
            'account_hash' => $accountHash,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    private function recordFailedAttempt(string $ipHash, string $accountHash): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            $this->incrementAttempt($ipHash, self::IP_ATTEMPT_LIMIT);
            $this->incrementAttempt($accountHash, self::ACCOUNT_ATTEMPT_LIMIT);
            $pdo->exec('DELETE FROM login_attempts WHERE last_attempt_at < NOW() - INTERVAL 1 DAY');
            $pdo->commit();
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $exception;
        }
    }

    private function incrementAttempt(string $scopeHash, int $limit): void
    {
        $pdo = Database::connection();
        $insert = $pdo->prepare(
            'INSERT IGNORE INTO login_attempts
                (scope_hash, attempt_count, window_started_at, last_attempt_at)
             VALUES (:scope_hash, 0, NOW(), NOW())'
        );
        $insert->execute(['scope_hash' => $scopeHash]);

        $select = $pdo->prepare(
            'SELECT attempt_count,
                    (window_started_at < NOW() - INTERVAL ' . self::ATTEMPT_WINDOW_MINUTES . ' MINUTE) AS window_expired
             FROM login_attempts
             WHERE scope_hash = :scope_hash
             FOR UPDATE'
        );
        $select->execute(['scope_hash' => $scopeHash]);
        $current = $select->fetch();

        $count = !empty($current['window_expired'])
            ? 1
            : ((int) $current['attempt_count'] + 1);
        $resetWindow = !empty($current['window_expired']) ? 1 : 0;
        $blocked = $count >= $limit ? 1 : 0;

        $update = $pdo->prepare(
            'UPDATE login_attempts
             SET attempt_count = :attempt_count,
                 window_started_at = CASE WHEN :reset_window = 1 THEN NOW() ELSE window_started_at END,
                 blocked_until = CASE WHEN :blocked = 1 THEN DATE_ADD(NOW(), INTERVAL ' . self::ATTEMPT_WINDOW_MINUTES . ' MINUTE) ELSE NULL END,
                 last_attempt_at = NOW()
             WHERE scope_hash = :scope_hash'
        );
        $update->execute([
            'attempt_count' => $count,
            'reset_window' => $resetWindow,
            'blocked' => $blocked,
            'scope_hash' => $scopeHash,
        ]);
    }

    private function clearAttempts(string $accountHash): void
    {
        $statement = Database::connection()->prepare(
            'DELETE FROM login_attempts WHERE scope_hash = :account_hash'
        );
        $statement->execute(['account_hash' => $accountHash]);
    }

    private function invalidateSession(): void
    {
        unset(
            $_SESSION['admin'],
            $_SESSION['_csrf'],
            $_SESSION['auth_issued_at'],
            $_SESSION['last_activity_at']
        );
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}
