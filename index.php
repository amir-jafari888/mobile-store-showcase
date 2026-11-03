<?php
declare(strict_types=1);

use App\Core\Router;
use App\Services\PublicStorefrontService;

require_once __DIR__ . '/app/Config/bootstrap.php';

$storefront = new PublicStorefrontService();

$storeSettings = $storefront->settings();
$categories = $storefront->categories();
$products = $storefront->products();
$featuredProducts = $storefront->featuredProducts();
$heroBanners = $storefront->banners();

$router = new Router();

/**
 * Home page
 *
 * All homepage sections are composed here in their intended display order.
 */
$router->get('/', static function () use (
    $storeSettings,
    $categories,
    $products,
    $featuredProducts,
    $heroBanners
): void {
    $pageTitle = 'موبایل مدیا'
        . ' | ویترین دیجیتال موبایل و گجت';

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

$router->get('/catalog', static function () use (
    $storeSettings,
    $categories,
    $products
): void {
    require BASE_PATH . '/pages/catalog.php';
});

$router->get('/about', static function () use ($storeSettings): void {
    require BASE_PATH . '/pages/about.php';
});

$router->get('/contact', static function () use ($storeSettings): void {
    require BASE_PATH . '/pages/contact.php';
});

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
