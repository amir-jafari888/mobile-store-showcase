<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    /** @var array<string, callable> */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes[$path] = $handler;
    }

    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = rtrim($path, '/') ?: '/';
        $handler = $this->routes[$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            require BASE_PATH . '/pages/404.php';
            return;
        }

        $handler();
    }
}
