<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class StoreSettingRepository
{
    public function all(): array
    {
        $statement = Database::connection()->query(
            'SELECT setting_key, setting_value FROM store_settings ORDER BY setting_key ASC'
        );

        $settings = [];
        foreach ($statement->fetchAll() as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $statement = Database::connection()->prepare(
            'SELECT setting_value FROM store_settings WHERE setting_key = :setting_key LIMIT 1'
        );
        $statement->execute(['setting_key' => $key]);
        $value = $statement->fetchColumn();

        return $value === false ? $default : (string) $value;
    }

    public function set(string $key, ?string $value): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO store_settings (setting_key, setting_value)
             VALUES (:setting_key, :setting_value)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );
        $statement->execute(['setting_key' => $key, 'setting_value' => $value]);
    }

    public function setMany(array $settings): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            foreach ($settings as $key => $value) {
                $this->set((string) $key, $value === null ? null : (string) $value);
            }
            $pdo->commit();
        } catch (\Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $exception;
        }
    }
}
