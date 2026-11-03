<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(?string $basePath = null)
    {
        $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
        $detectedBasePath = dirname($scriptName);

        if ($detectedBasePath === '.' || $detectedBasePath === '/') {
            $detectedBasePath = '';
        }

        $this->basePath = rtrim('/' . trim($basePath ?? $detectedBasePath, '/'), '/');
    }

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, callable $handler): void
    {
        $normalizedPath = '/' . trim($path, '/');
        $this->routes[strtoupper($method)][$normalizedPath === '/' ? '/' : $normalizedPath] = $handler;
    }

    public function dispatch(string $uri, ?string $method = null): void
    {
        $requestPath = parse_url($uri, PHP_URL_PATH);
        $requestPath = is_string($requestPath) && $requestPath !== ''
            ? rawurldecode($requestPath)
            : '/';

        // Remove the application directory when the project runs in a subfolder.
        if (
            $this->basePath !== ''
            && ($requestPath === $this->basePath || str_starts_with($requestPath, $this->basePath . '/'))
        ) {
            $requestPath = substr($requestPath, strlen($this->basePath)) ?: '/';
        }

        $path = '/' . trim($requestPath, '/');
        $path = $path === '/' ? '/' : $path;
        $method = strtoupper($method ?? (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

        if (isset($this->routes[$method][$path])) {
            ($this->routes[$method][$path])();
            return;
        }

        $allowedMethods = [];
        foreach ($this->routes as $verb => $routes) {
            if (isset($routes[$path])) {
                $allowedMethods[] = $verb;
            }
        }

        if ($allowedMethods !== []) {
            header('Allow: ' . implode(', ', $allowedMethods));
            http_response_code(405);
            exit('Method Not Allowed');
        }

        http_response_code(404);
        require BASE_PATH . '/pages/404.php';
    }
}
