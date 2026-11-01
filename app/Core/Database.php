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

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $name, $charset);

        try {
            self::$connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
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
