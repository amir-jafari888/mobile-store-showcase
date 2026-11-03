<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use PDOException;
use RuntimeException;

final class AdminAccountService
{
    public function profile(int $adminId): array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, name, email FROM admins WHERE id = :id AND is_active = 1 LIMIT 1'
        );
        $statement->execute(['id' => $adminId]);
        $admin = $statement->fetch();

        if (!is_array($admin)) {
            throw new RuntimeException('حساب مدیر در دسترس نیست.');
        }

        return $admin;
    }

    public function update(
        int $adminId,
        string $name,
        string $email,
        string $currentPassword,
        string $newPassword
    ): array {
        $name = trim($name);
        $email = mb_strtolower(trim($email));

        if ($name === '' || mb_strlen($name) > 120) {
            throw new \InvalidArgumentException('نام مدیر باید بین ۱ تا ۱۲۰ کاراکتر باشد.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            throw new \InvalidArgumentException('ایمیل واردشده معتبر نیست.');
        }
        if ($currentPassword === '') {
            throw new \InvalidArgumentException('برای ذخیره تغییرات، رمز عبور فعلی را وارد کنید.');
        }
        if ($newPassword !== '' && strlen($newPassword) < 12) {
            throw new \InvalidArgumentException('رمز عبور جدید باید حداقل ۱۲ کاراکتر داشته باشد.');
        }

        $pdo = Database::connection();
        $select = $pdo->prepare(
            'SELECT id, name, email, password_hash FROM admins WHERE id = :id AND is_active = 1 LIMIT 1'
        );
        $select->execute(['id' => $adminId]);
        $admin = $select->fetch();

        if (!is_array($admin) || !password_verify($currentPassword, (string) $admin['password_hash'])) {
            throw new \InvalidArgumentException('رمز عبور فعلی صحیح نیست.');
        }

        $passwordHash = $newPassword === ''
            ? (string) $admin['password_hash']
            : password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            $update = $pdo->prepare(
                'UPDATE admins
                 SET name = :name, email = :email, password_hash = :password_hash
                 WHERE id = :id'
            );
            $update->execute([
                'name' => $name,
                'email' => $email,
                'password_hash' => $passwordHash,
                'id' => $adminId,
            ]);
        } catch (PDOException $exception) {
            if ((string) $exception->getCode() === '23000') {
                throw new \InvalidArgumentException('این ایمیل قبلاً برای حساب دیگری ثبت شده است.');
            }
            throw $exception;
        }

        $_SESSION['admin']['name'] = $name;
        $_SESSION['admin']['email'] = $email;

        if ($newPassword !== '') {
            session_regenerate_id(true);
            $_SESSION['last_activity_at'] = time();
        }

        return ['id' => $adminId, 'name' => $name, 'email' => $email];
    }
}
