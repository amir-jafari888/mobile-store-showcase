<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Middleware\AdminGuard;
use App\Services\AuthService;

AdminGuard::require();
$auth = new AuthService();
$admin = $auth->admin();
$pageTitle = 'داشبورد مدیریت';
$adminName = is_array($admin) ? (string) ($admin['name'] ?? 'مدیر') : 'مدیر';
$adminEmail = is_array($admin) ? (string) ($admin['email'] ?? '') : '';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title><?= e($pageTitle) ?></title><link rel="stylesheet" href="/admin/assets/css/main.css"></head>
<body class="admin-body">
<aside class="admin-sidebar"><a class="admin-brand" href="/"><span>M</span><div>موبایل‌استور<small>مدیریت محتوا</small></div></a><div class="admin-profile"><div class="avatar"><?= e(mb_strtoupper(mb_substr($adminName, 0, 1))) ?></div><div><b><?= e($adminName) ?></b><small><?= e($adminEmail) ?></small></div></div><nav class="admin-nav"><span class="nav-caption">مدیریت فروشگاه</span><a class="active" href="#overview">▦　نمای کلی</a><a href="#products">▣　محصولات</a><a href="#categories">▤　دسته‌بندی‌ها</a><a href="#banners">▧　بنرها و صفحه اصلی</a><a href="#settings">⚙　اطلاعات فروشگاه</a><span class="nav-caption">سیستم</span><a href="/">↗　مشاهده وب‌سایت</a></nav><div class="sidebar-foot">نسخه پنل 1.0</div></aside>
<main class="admin-main"><header class="admin-topbar"><div><span class="admin-breadcrumb">پنل مدیریت /</span><h1>نمای کلی</h1></div><form method="post" action="/admin/logout.php"><input type="hidden" name="_csrf" value="<?= e(\App\Middleware\Csrf::token()) ?>"><button class="preview-badge" type="submit">خروج</button></form></header>
<section class="admin-stats" id="overview"><article><span>تعداد محصولات</span><b>—</b><small>اتصال داده در فازهای بعد</small></article><article><span>دسته‌بندی‌ها</span><b>—</b><small>اتصال داده در فازهای بعد</small></article><article><span>بنرهای فعال</span><b>—</b><small>اتصال داده در فازهای بعد</small></article><article><span>وضعیت سایت</span><b class="status-text">فعال</b><small>احراز هویت مدیر فعال است</small></article></section>
<section class="admin-panel"><div class="panel-heading"><div><span>مدیریت محتوا</span><h2>دسترسی سریع</h2></div></div><div class="admin-shortcuts"><a id="products" href="#products"><i>▣</i><b>محصولات</b><small>تعریف و ویرایش مشخصات محصولات</small><span>←</span></a><a id="categories" href="#categories"><i>▤</i><b>دسته‌بندی‌ها</b><small>سامان‌دهی گروه‌های محصول</small><span>←</span></a><a id="banners" href="#banners"><i>▧</i><b>بنرها و صفحه اصلی</b><small>مدیریت محتوای بخش‌های ویترین</small><span>←</span></a><a id="settings" href="#settings"><i>⚙</i><b>اطلاعات فروشگاه</b><small>راه‌های تماس، آدرس و ساعات فعالیت</small><span>←</span></a></div></section>
<section class="admin-panel"><div class="panel-heading"><div><span>وضعیت توسعه</span><h2>احراز هویت و کنترل دسترسی</h2></div></div><ul class="admin-checklist"><li><span>01</span> ورود مدیر با session امن</li><li><span>02</span> محافظت مسیرهای مدیریت با AdminGuard</li><li><span>03</span> خروج فقط با POST و CSRF</li><li><span>04</span> آماده اتصال CRUD در فازهای بعد</li></ul></section>
<footer class="admin-footer">© <?= date('Y') ?> موبایل‌استور <span>پنل مدیریت — حساب <?= e($adminName) ?></span></footer></main><script type="module" src="/admin/assets/js/main.js"></script></body></html>