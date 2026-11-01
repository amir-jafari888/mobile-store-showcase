<?php
declare(strict_types=1);

namespace App\Core;

use Throwable;

final class ErrorHandler
{
    public static function register(bool $debug = false): void
    {
        set_exception_handler(static function (Throwable $exception) use ($debug): void {
            error_log((string) $exception);
            http_response_code(500);

            if ($debug) {
                header('Content-Type: text/plain; charset=utf-8');
                echo $exception;
                return;
            }

            $errorPage = BASE_PATH . '/pages/500.php';
            if (is_file($errorPage)) {
                require $errorPage;
                return;
            }

            echo 'Internal Server Error';
        });

        set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
            if (!(error_reporting() & $severity)) {
                return false;
            }

            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }
}
