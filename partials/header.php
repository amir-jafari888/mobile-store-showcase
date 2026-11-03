<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'موبایل‌استور';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ویترین دیجیتال فروشگاه موبایل و لوازم جانبی؛ بررسی محصولات و ارتباط مستقیم با فروشگاه.">
  <meta name="theme-color" content="#2c2232">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="/" aria-label="صفحه اصلی موبایل‌استور">
      <span class="brand-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="6.5" y="2.75" width="11" height="18.5" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
          <path d="M10 5.8h4M10.5 18.2h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </span>
      <span>موبایل‌استور<small>DIGITAL SHOWROOM</small></span>
    </a>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="باز کردن منو">
      <span></span><span></span><span></span>
    </button>
    <nav id="primary-nav" class="primary-nav" aria-label="ناوبری اصلی">
      <a href="/">خانه</a>
      <a href="/catalog">کاتالوگ</a>
      <a href="/about">درباره فروشگاه</a>
      <a class="nav-contact" href="/contact">تماس و مراجعه</a>
    </nav>
  </div>
</header>
<main>
