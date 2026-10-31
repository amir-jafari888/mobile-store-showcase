<?php
declare(strict_types=1);

require_once __DIR__ . '/app/Config/bootstrap.php';

use App\Core\Router;

$router = new Router();
$router->get('/', static fn () => require __DIR__ . '/pages/home.php');
$router->get('/about', static fn () => require __DIR__ . '/pages/about.php');
$router->get('/services', static fn () => require __DIR__ . '/pages/services.php');
$router->get('/portfolio', static fn () => require __DIR__ . '/pages/portfolio.php');
$router->get('/contact', static fn () => require __DIR__ . '/pages/contact.php');

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
