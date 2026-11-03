<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $basePath = dirname($scriptName);

    if ($basePath === '.' || $basePath === '/') {
        $basePath = '';
    }

    $path = ltrim($path, '/');

    return rtrim($basePath, '/') . ($path !== '' ? '/' . $path : '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}
