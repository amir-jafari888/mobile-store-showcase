<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\AuthService;
use App\Core\Response;

final class AdminGuard
{
    public static function require(): void
    {
        $auth = new AuthService();

        if ($auth->check()) {
            return;
        }

        $next = $_SERVER['REQUEST_URI'] ?? '/admin/';
        $query = http_build_query(['next' => $next]);
        Response::redirect('/admin/login.php?' . $query);
    }
}
