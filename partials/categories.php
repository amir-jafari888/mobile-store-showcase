<?php
$categories = is_array($categories ?? null) ? $categories : [];
$categoryPreview = [
 ['name'=>'گوشی هوشمند','description'=>'مدل‌ها و نسل‌های مختلف تلفن همراه','image_path'=>'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=800&q=82','slug'=>'smartphones'],
 ['name'=>'لوازم جانبی','description'=>'تجهیزات کاربردی برای استفاده روزمره','image_path'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30?auto=format&fit=crop&w=800&q=82','slug'=>'accessories'],
 ['name'=>'صوتی و تصویری','description'=>'هدفون، اسپیکر و ابزارهای چندرسانه‌ای','image_path'=>'https://images.unsplash.com/photo-1503919005314-30d93d07d823?auto=format&fit=crop&w=800&q=82','slug'=>'audio'],
 ['name'=>'گجت‌های دیجیتال','description'=>'ابزارهای هوشمند و همراه','image_path'=>'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&q=82','slug'=>'gadgets'],
];
$isCategoryPreview = $categories === [];
if ($isCategoryPreview) $categories = $categoryPreview;
?>
<section class="section categories-section">
  <div class="container">
    <div class="category-heading-bar">
      <h2><?= e($storeSettings['categories_title'] ?? 'دسته‌بندی محصولات') ?></h2>
      <div class="category-heading-actions">
        <div class="category-slider-controls" aria-label="کنترل اسلایدر دسته‌بندی">
          <button class="category-slider-arrow" type="button" data-category-prev aria-label="دسته قبلی" disabled><span aria-hidden="true">›</span></button>
          <button class="category-slider-arrow" type="button" data-category-next aria-label="دسته بعدی"><span aria-hidden="true">‹</span></button>
        </div>
        <a class="category-view-all" href="<?= e(url('catalog')) ?>">مشاهده <span aria-hidden="true">&gt;</span></a>
      </div>
    </div>

    <div class="category-slider" data-category-slider>
      <div class="category-track" data-category-track role="list" aria-label="دسته‌بندی‌های محصولات">
        <?php foreach ($categories as $category): ?>
          <a class="category-card" role="listitem" href="<?= e(url('catalog?category=' . rawurlencode((string)($category['slug'] ?? '')))) ?>">
            <span class="category-card-copy">
              <span class="category-card-title"><?= e($category['name'] ?? '') ?></span>
              <?php if (!empty($category['description'])): ?><span class="category-card-description"><?= e($category['description']) ?></span><?php endif; ?>
              <span class="category-card-cta">مشاهده دسته <span aria-hidden="true">←</span></span>
            </span>
            <?php if (!empty($category['image_path'])): ?>
              <span class="category-card-visual">
                <img src="<?= e(media_url((string)$category['image_path'])) ?>" alt="" loading="lazy">
              </span>
            <?php else: ?>
              <span class="category-card-visual category-card-visual-empty" aria-hidden="true"><span>MM</span></span>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if ($isCategoryPreview): ?><p class="content-disclaimer">محتوای این بخش نمونه نمایشی است و با ثبت دسته‌بندی‌های واقعی جایگزین می‌شود.</p><?php endif; ?>
  </div>
</section>
