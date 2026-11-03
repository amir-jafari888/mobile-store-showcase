<?php
$heroBanners = $heroBanners ?? [];
$heroBanner = $heroBanners[0] ?? null;
$heroImage = $heroBanner['image_path'] ?? 'https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg?auto=compress&cs=tinysrgb&w=2000';
$heroAlt = $heroBanner['title'] ?? 'نمایی از محصولات موبایل مدیا';
?>
<section class="hero" aria-label="ویترین تصویری موبایل مدیا">
  <div class="hero-media">
    <img src="<?= e($heroImage) ?>" alt="<?= e($heroAlt) ?>" fetchpriority="high">
  </div>
  <div class="hero-frame" aria-hidden="true"><span>MM / MOBILE MEDIA</span><span>TECHNOLOGY, UP CLOSE</span></div>
</section>
