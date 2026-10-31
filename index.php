<?php
declare(strict_types=1);

require_once __DIR__ . '/app/Config/bootstrap.php';

use App\Core\Router;

$router = new Router();

$router->get('/', static function (): void {
    $pageTitle = 'فروشگاه موبایل | انتخاب مطمئن موبایل و لوازم جانبی';
    require_once BASE_PATH . '/partials/header.php';
    require_once BASE_PATH . '/partials/hero.php';
    require_once BASE_PATH . '/partials/trust-strip.php';
    require_once BASE_PATH . '/partials/categories.php';
    require_once BASE_PATH . '/partials/featured-products.php';
    require_once BASE_PATH . '/partials/benefits.php';
    require_once BASE_PATH . '/partials/services.php';
    require_once BASE_PATH . '/partials/about.php';
    require_once BASE_PATH . '/partials/contact-cta.php';
    require_once BASE_PATH . '/partials/footer.php';
});

$router->get('/about', static fn () => require BASE_PATH . '/pages/about.php');
$router->get('/services', static fn () => require BASE_PATH . '/pages/services.php');
$router->get('/portfolio', static fn () => require BASE_PATH . '/pages/portfolio.php');
$router->get('/contact', static fn () => require BASE_PATH . '/pages/contact.php');

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
