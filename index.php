<?php
declare(strict_types=1);
require_once __DIR__ . '/app/Config/bootstrap.php';
use App\Core\Router;
use App\Services\PublicStorefrontService;
$storefront=new PublicStorefrontService();
$storeSettings=$storefront->settings();
$categories=$storefront->categories();
$products=$storefront->products();
$featuredProducts=$storefront->featuredProducts();
$heroBanners=$storefront->banners();
$router=new Router();
$router->get('/',static function()use($storeSettings,$categories,$featuredProducts,$heroBanners):void{
 $pageTitle=($storeSettings['store_name']??'موبایل‌استور').' | ویترین دیجیتال موبایل و گجت';
 require BASE_PATH.'/partials/header.php';require BASE_PATH.'/partials/hero.php';require BASE_PATH.'/partials/trust-strip.php';require BASE_PATH.'/partials/categories.php';require BASE_PATH.'/partials/featured-products.php';require BASE_PATH.'/partials/benefits.php';require BASE_PATH.'/partials/services.php';require BASE_PATH.'/partials/about.php';require BASE_PATH.'/partials/contact-cta.php';require BASE_PATH.'/partials/footer.php';
});
$router->get('/catalog',static function()use($storeSettings,$categories,$products):void{require BASE_PATH.'/pages/catalog.php';});
$router->get('/about',static function()use($storeSettings):void{require BASE_PATH.'/pages/about.php';});
$router->get('/contact',static function()use($storeSettings):void{require BASE_PATH.'/pages/contact.php';});
$router->get('/portfolio',static function()use($storeSettings,$categories,$products):void{require BASE_PATH.'/pages/catalog.php';});
$router->get('/services',static function()use($storeSettings):void{require BASE_PATH.'/pages/about.php';});
$router->dispatch($_SERVER['REQUEST_URI']??'/');
