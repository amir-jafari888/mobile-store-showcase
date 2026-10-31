<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'فروشگاه موبایل';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="معرفی موبایل‌ها، لوازم جانبی و خدمات فروشگاه؛ برای بررسی و خرید حضوری با ما در ارتباط باشید.">
    <meta name="theme-color" content="#0F172A">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="/" aria-label="صفحه اصلی فروشگاه"><span class="brand-mark">M</span><span>موبایل‌استور<small>انتخاب مطمئن</small></span></a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="باز کردن منو"><span></span><span></span><span></span></button>
        <nav id="primary-nav" class="primary-nav" aria-label="ناوبری اصلی">
            <a href="/">خانه</a><a href="/portfolio">محصولات</a><a href="/services">خدمات</a><a href="/about">درباره ما</a><a class="nav-contact" href="/contact">ارتباط با ما</a>
        </nav>
    </div>
</header>
<main>
