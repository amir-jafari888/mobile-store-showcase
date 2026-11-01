<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;

    public static function configured(): bool
    {
        return self::env('DB_HOST') !== null
            && self::env('DB_NAME') !== null
            && self::env('DB_USER') !== null;
    }

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        if (!self::configured()) {
            throw new RuntimeException('Database connection is not configured.');
        }

        $host = self::env('DB_HOST');
        $port = self::env('DB_PORT') ?? '3306';
        $name = self::env('DB_NAME');
        $user = self::env('DB_USER');
        $password = self::env('DB_PASSWORD') ?? '';
        $charset = self::env('DB_CHARSET') ?? 'utf8mb4';

        if (!ctype_digit($port) || (int) $port < 1 || (int) $port > 65535) {
            throw new RuntimeException('Invalid database port configuration.');
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', (string) $name)) {
            throw new RuntimeException('Invalid database name configuration.');
        }

        if ($charset !== 'utf8mb4') {
            throw new RuntimeException('Only utf8mb4 database connections are supported.');
        }

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);

        try {
            self::$connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_TIMEOUT => 5,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException('Unable to connect to the database.', 0, $exception);
        }

        return self::$connection;
    }

    public static function disconnect(): void
    {
        self::$connection = null;
    }

    private static function env(string $key): ?string
    {
        $value = getenv($key);
        return $value === false || $value === '' ? null : $value;
    }
}
