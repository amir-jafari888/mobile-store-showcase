<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__, 2));
define('DATA_PATH', BASE_PATH . '/data');

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

require_once BASE_PATH . '/app/Helpers/view.php';

\App\Config\Env::load(BASE_PATH . '/.env');

$timezone = getenv('APP_TIMEZONE') ?: 'Asia/Tehran';
if (in_array($timezone, timezone_identifiers_list(), true)) {
    date_default_timezone_set($timezone);
}

$debug = filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOL);
\App\Core\ErrorHandler::register($debug);

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');

    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    if ($isHttps) {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}
