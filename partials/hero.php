<?php
$heroBanners = is_array($heroBanners ?? null) ? $heroBanners : [];
$heroBanner = null;
foreach ($heroBanners as $banner) {
  if (!empty($banner['image_path'])) {
    $heroBanner = $banner;
    break;
  }
}
$heroImage = $heroBanner
  ? media_url((string) $heroBanner['image_path'])
  : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1400&q=88';
$heroTitle = trim((string) ($storeSettings['hero_title'] ?? 'موبایل مدیا؛ دنیای موبایل و فناوری'));
$heroDescription = trim((string) ($storeSettings['hero_description'] ?? 'جدیدترین محصولات دنیای موبایل و لوازم دیجیتال را در ویترین موبایل مدیا ببینید.'));
$heroCtaUrl = !empty($heroBanner['link_url']) ? (string) $heroBanner['link_url'] : url('catalog');
$heroImageAlt = (string) ($heroBanner['title'] ?? $heroTitle);
?>
<section class="hero" aria-labelledby="hero-title">
  <div class="container hero-inner">
    <div class="hero-media">
      <img src="<?= e($heroImage) ?>" alt="<?= e($heroImageAlt) ?>" fetchpriority="high">
    </div>
    <div class="hero-content">
      <span class="hero-eyebrow">MOBILE MEDIA</span>
      <h1 id="hero-title"><?= e($heroTitle) ?></h1>
      <p><?= e($heroDescription) ?></p>
      <a class="button hero-cta" href="<?= e($heroCtaUrl) ?>">مشاهده محصولات <span aria-hidden="true">←</span></a>
    </div>
  </div>
</section>
