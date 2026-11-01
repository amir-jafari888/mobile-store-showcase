<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit("Not found.\n");
}

require_once dirname(__DIR__) . '/app/Config/Env.php';
\App\Config\Env::load(dirname(__DIR__) . '/.env');

$readEnv = static function (string $key, ?string $default = null): ?string {
    $value = getenv($key);
    return $value === false || $value === '' ? $default : $value;
};

$host = $readEnv('DB_HOST');
$port = $readEnv('DB_PORT', '3306');
$name = $readEnv('DB_NAME');
$user = $readEnv('DB_MIGRATION_USER', $readEnv('DB_USER'));
$password = $readEnv('DB_MIGRATION_PASSWORD', $readEnv('DB_PASSWORD', ''));
$charset = $readEnv('DB_CHARSET', 'utf8mb4');

if (!$host || !$name || !$user || $charset !== 'utf8mb4'
    || !ctype_digit((string) $port) || (int) $port < 1 || (int) $port > 65535
    || !preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
    fwrite(STDERR, "Database environment configuration is invalid. Check .env.\n");
    exit(1);
}

$schemaFile = __DIR__ . '/schema.sql';
if (!is_file($schemaFile) || !is_readable($schemaFile)) {
    fwrite(STDERR, "database/schema.sql is missing or unreadable.\n");
    exit(1);
}

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name),
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ]
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS schema_migrations (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(190) NOT NULL UNIQUE,
            checksum CHAR(64) NOT NULL,
            applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $applyMigration = static function (PDO $pdo, string $migrationName, string $sql): void {
        $checksum = hash('sha256', $sql);
        $check = $pdo->prepare(
            'SELECT checksum FROM schema_migrations WHERE migration = :migration LIMIT 1'
        );
        $check->execute(['migration' => $migrationName]);
        $existingChecksum = $check->fetchColumn();

        if ($existingChecksum !== false) {
            if (!hash_equals((string) $existingChecksum, $checksum)) {
                throw new RuntimeException(
                    sprintf('Migration checksum mismatch for %s. Never edit an applied migration; add a new one.', $migrationName)
                );
            }
            fwrite(STDOUT, sprintf("Already applied: %s\n", $migrationName));
            return;
        }

        $statements = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($statements as $statement) {
            $pdo->exec($statement);
        }

        $insert = $pdo->prepare(
            'INSERT INTO schema_migrations (migration, checksum) VALUES (:migration, :checksum)'
        );
        $insert->execute([
            'migration' => $migrationName,
            'checksum' => $checksum,
        ]);
        fwrite(STDOUT, sprintf("Applied: %s\n", $migrationName));
    };

    $baseline = file_get_contents($schemaFile);
    if ($baseline === false) {
        throw new RuntimeException('Unable to read database/schema.sql.');
    }
    $applyMigration($pdo, '001_core_schema', $baseline);

    $migrationFiles = glob(__DIR__ . '/migrations/*.sql') ?: [];
    sort($migrationFiles, SORT_STRING);
    foreach ($migrationFiles as $migrationFile) {
        if (!is_file($migrationFile) || !is_readable($migrationFile)) {
            throw new RuntimeException('An incremental migration is unreadable.');
        }
        $sql = file_get_contents($migrationFile);
        if ($sql === false) {
            throw new RuntimeException('Unable to read migration: ' . basename($migrationFile));
        }
        $applyMigration($pdo, pathinfo($migrationFile, PATHINFO_FILENAME), $sql);
    }

    fwrite(STDOUT, "Database migrations are up to date.\n");
} catch (Throwable $exception) {
    fwrite(STDERR, "Migration failed: " . $exception->getMessage() . "\n");
    exit(1);
}
