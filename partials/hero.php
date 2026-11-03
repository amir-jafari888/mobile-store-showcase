<?php
$heroBanners = is_array($heroBanners ?? null) ? $heroBanners : [];
$fallbackSlides = [
  ['image_path'=>'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=2200&q=88','title'=>'تجربه‌ای نزدیک‌تر به فناوری'],
  ['image_path'=>'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=2200&q=88','title'=>'دنیای تلفن‌های هوشمند'],
  ['image_path'=>'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=2200&q=88','title'=>'اکوسیستم ابزارهای دیجیتال'],
];
$slides = [];
foreach ($heroBanners as $banner) {
  if (!empty($banner['image_path'])) {
    $slides[] = ['image_path'=>$banner['image_path'],'title'=>$banner['title'] ?? 'موبایل مدیا'];
  }
}
foreach ($fallbackSlides as $fallback) {
  if (count($slides) >= 4) break;
  if (count($slides) < 3) $slides[] = $fallback;
}
if ($slides === []) $slides = $fallbackSlides;
?>
<section class="hero" aria-label="بنرهای تصویری موبایل مدیا" data-hero-slider>
  <h1>موبایل مدیا؛ دنیای موبایل و فناوری</h1>
  <div class="hero-media" aria-live="off">
    <?php foreach ($slides as $index => $slide): ?>
      <div class="hero-slide<?= $index === 0 ? ' is-active' : '' ?>" data-hero-slide aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
        <img src="<?= e($slide['image_path']) ?>" alt="<?= e($slide['title']) ?>" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if (count($slides) > 1): ?>
    <div class="hero-controls" aria-label="کنترل اسلایدر">
      <button class="hero-arrow" type="button" data-hero-prev aria-label="بنر قبلی">‹</button>
      <div class="hero-dots" role="group" aria-label="انتخاب بنر">
        <?php foreach ($slides as $index => $_slide): ?>
          <button class="hero-dot<?= $index === 0 ? ' is-active' : '' ?>" type="button" data-hero-dot="<?= $index ?>" aria-label="نمایش بنر <?= $index + 1 ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"></button>
        <?php endforeach; ?>
      </div>
      <button class="hero-arrow" type="button" data-hero-next aria-label="بنر بعدی">›</button>
    </div>
  <?php endif; ?>
</section>
