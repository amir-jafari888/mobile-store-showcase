<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use RuntimeException;

final class AuthService
{
    public function login(string $email, string $password): bool
    {
        if (!Database::configured()) {
            throw new RuntimeException('Database connection is not configured.');
        }

        $statement = Database::connection()->prepare(
            'SELECT id, name, email, password_hash
             FROM admins
             WHERE email = :email AND is_active = 1
             LIMIT 1'
        );
        $statement->execute(['email' => mb_strtolower(trim($email))]);
        $admin = $statement->fetch();

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return false;
        }

        session_regenerate_id(true);
        unset($_SESSION['_csrf']);
        $_SESSION['admin'] = [
            'id' => (int) $admin['id'],
            'name' => $admin['name'],
            'email' => $admin['email'],
        ];

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
        unset($_SESSION['admin'], $_SESSION['_csrf']);
        session_regenerate_id(true);
    }

    public function check(): bool
    {
        return isset($_SESSION['admin']['id']) && is_int($_SESSION['admin']['id']);
    }

    public function admin(): ?array
    {
        return $this->check() ? $_SESSION['admin'] : null;
    }
}
