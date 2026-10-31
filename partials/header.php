<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'فروشگاه موبایل';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="معرفی محصولات و خدمات فروشگاه موبایل">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="/">فروشگاه موبایل</a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">منو</button>
        <nav id="primary-nav" class="primary-nav" aria-label="ناوبری اصلی">
            <a href="/">خانه</a><a href="/about">درباره ما</a><a href="/services">خدمات</a><a href="/portfolio">محصولات</a><a href="/contact">تماس</a>
        </nav>
    </div>
</header>
