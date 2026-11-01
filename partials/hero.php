<?php
$heroBanners=$heroBanners??[];$heroBanner=$heroBanners[0]??null;
$heroTitle=$heroBanner['title']??'تکنولوژی را<br><em>از نزدیک ببین.</em>';
$heroSubtitle=$heroBanner['subtitle']??'مدل‌های موبایل، گجت و لوازم جانبی را در یک ویترین ساده و دقیق ببین؛ برای موجودی، قیمت و خرید حضوری مستقیم با فروشگاه در ارتباط باش.';
$heroImage=$heroBanner['image_path']??'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85';
$heroLink=$heroBanner['link_url']??'/catalog';
?>
<section class="hero"><div class="container hero-layout"><div class="hero-copy"><span class="eyebrow">ویترین دیجیتال فروشگاه</span><h1><?= $heroBanner?nl2br(e($heroTitle)):$heroTitle ?></h1><p><?= e($heroSubtitle) ?></p><div class="hero-actions"><a class="button button-primary" href="<?= e($heroLink) ?>">دیدن ویترین <span>←</span></a><a class="text-link" href="/contact">اطلاعات فروشگاه</a></div><div class="hero-note"><span>01 / SHOWROOM</span><small>برای موجودی و قیمت با فروشگاه تماس بگیر.</small></div></div><div class="hero-visual"><div class="hero-photo"><img src="<?= e($heroImage) ?>" alt="<?= e($heroBanner['title']??'ویترین محصولات فروشگاه') ?>"></div><span class="hero-stamp">MOBILE / GADGET / ACCESSORY</span><span class="hero-index">DIGITAL WINDOW — 2026</span></div></div><div class="hero-bottom-line"></div></section>
