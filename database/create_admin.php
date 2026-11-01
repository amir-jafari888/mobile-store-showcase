<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit("Not found.\n");
}

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Core\Database;

if (!Database::configured()) {
    fwrite(STDERR, "Database is not configured. Set DB_* values in .env first.\n");
    exit(1);
}

$name = trim((string) (getenv('ADMIN_NAME') ?: ''));
$email = mb_strtolower(trim((string) (getenv('ADMIN_EMAIL') ?: '')));
$password = (string) (getenv('ADMIN_PASSWORD') ?: '');

if ($name === '' || mb_strlen($name) > 120
    || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || strlen($password) < 12) {
    fwrite(STDERR, "Set ADMIN_NAME, ADMIN_EMAIL and ADMIN_PASSWORD in your shell. Password must be at least 12 characters.\n");
    exit(1);
}

try {
    $pdo = Database::connection();
    $statement = $pdo->prepare(
        'INSERT INTO admins (name, email, password_hash, is_active)
         VALUES (:name, :email, :password_hash, 1)'
    );
    $statement->execute([
        'name' => $name,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    fwrite(STDOUT, "Admin account created. ID: " . $pdo->lastInsertId() . "\n");
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        fwrite(STDERR, "An admin with this email already exists.\n");
        exit(1);
    }
    throw $exception;
} finally {
    putenv('ADMIN_PASSWORD');
}
