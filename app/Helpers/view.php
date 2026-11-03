<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Resolve the application root even when a PHP entry point lives in /admin.
 * Examples:
 *   /mobile-store-showcase/index.php       -> /mobile-store-showcase
 *   /mobile-store-showcase/admin/login.php -> /mobile-store-showcase
 */
function app_base_path(): string
{
    $scriptName = str_replace('\\\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $directory = dirname($scriptName);

    if ($directory === '.' || $directory === '/') {
        return '';
    }

    if (basename($directory) === 'admin') {
        $directory = dirname($directory);
    }

    return rtrim($directory === '.' ? '' : $directory, '/');
}

function url(string $path = ''): string
{
    $basePath = app_base_path();
    $path = ltrim($path, '/');

    return $basePath . ($path !== '' ? '/' . $path : '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}
