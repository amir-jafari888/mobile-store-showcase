<?php
declare(strict_types=1);
$storeSettings = $storeSettings ?? [];
$pageTitle = $pageTitle ?? 'موبایل مدیا';
$storeName = $storeSettings['store_name'] ?? 'موبایل مدیا';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ویترین دیجیتال موبایل مدیا؛ محصولات موبایل و لوازم جانبی را بررسی کنید و برای موجودی و مشاوره با فروشگاه در ارتباط باشید.">
<meta name="theme-color" content="#F8F6F9">
<title><?= e($pageTitle) ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.2.10/swiper-bundle.min.css">
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<a class="skip-link" href="#main-content">رفتن به محتوای اصلی</a>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url()) ?>" aria-label="صفحه اصلی <?= e($storeName) ?>">
      <span class="brand-name brand-wordmark"><?= e($storeName) ?></span>
    </a>
    <nav id="primary-nav" class="primary-nav" aria-label="ناوبری اصلی">
      <a href="<?= e(url()) ?>">خانه</a>
      <a href="<?= e(url('catalog')) ?>">کاتالوگ محصولات</a>
      <a href="<?= e(url('about')) ?>">درباره ما</a>
      <a href="<?= e(url('contact')) ?>">تماس با ما</a>
    </nav>
    <div class="header-actions">
      <a class="header-cta" href="<?= e(url('contact')) ?>">مشاوره و تماس</a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="باز کردن منو">
        <span></span><span></span>
      </button>
    </div>
  </div>
</header>
<div class="menu-backdrop" data-menu-backdrop hidden></div>
<main id="main-content">
