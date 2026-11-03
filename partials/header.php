<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'موبایل مدیا';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="موبایل مدیا؛ ویترین موبایل، گجت و لوازم جانبی. محصولات را بررسی کن و برای موجودی و مشاوره با فروشگاه در ارتباط باش.">
<meta name="theme-color" content="#F8F7FA">
<title><?= e($pageTitle) ?></title>
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</head>
<body>
<a class="skip-link" href="#main-content">رفتن به محتوای اصلی</a>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url()) ?>" aria-label="صفحه اصلی موبایل مدیا">
      <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 40 40" role="img"><path d="M9 28V12h4l7 9 7-9h4v16h-4V18l-7 9-7-9v10z" fill="currentColor"/></svg></span>
      <span class="brand-name">موبایل مدیا<small>MOBILE MEDIA</small></span>
    </a>
    <nav id="primary-nav" class="primary-nav" aria-label="ناوبری اصلی">
      <a href="<?= e(url()) ?>">خانه</a>
      <a href="<?= e(url('catalog')) ?>">کاتالوگ محصولات</a>
      <a href="<?= e(url('about')) ?>">درباره ما</a>
      <a href="<?= e(url('contact')) ?>">تماس با ما</a>
    </nav>
    <div class="header-actions">
      <a class="header-cta" href="<?= e(url('contact')) ?>">مشاوره و تماس <span aria-hidden="true">↗</span></a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="باز کردن منو">
        <span></span><span></span>
      </button>
    </div>
  </div>
</header>
<div class="menu-backdrop" data-menu-backdrop hidden></div>
<main id="main-content">
