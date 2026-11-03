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
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<a class="skip-link" href="#main-content">رفتن به محتوای اصلی</a>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url()) ?>" aria-label="صفحه اصلی <?= e($storeName) ?>">
      <span class="brand-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="6.5" y="2.75" width="11" height="18.5" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
          <path d="M10 5.8h4M10.5 18.2h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="brand-name"><?= e($storeName) ?><small>MOBILE MEDIA</small></span>
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
