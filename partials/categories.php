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
<section class="section categories-section"><div class="container">
  <div class="section-heading"><div><span class="eyebrow">دسته‌بندی محصولات</span><h2><?= e($storeSettings['categories_title'] ?? 'فناوری را از مسیر خودش پیدا کن.') ?></h2><p class="section-lead"><?= e($storeSettings['categories_description'] ?? 'دسته‌های مختلف را مرور کن و مستقیم سراغ محصول موردنظرت برو.') ?></p></div><a class="text-link" href="<?= e(url('catalog')) ?>"><span aria-hidden="true">&gt;</span> مشاهده محصولات</a></div>
  <div class="category-grid"><?php foreach ($categories as $category): ?>
    <a class="category-card" href="<?= e(url('catalog?category=' . rawurlencode((string)($category['slug'] ?? '')))) ?>">
      <h3><?= e($category['name'] ?? '') ?></h3><p><?= e($category['description'] ?? '') ?></p>
      <span class="category-count"><?= $isCategoryPreview ? 'نمونه نمایشی' : 'مشاهده دسته' ?></span>
      <?php if (!empty($category['image_path'])): ?><img class="category-image" src="<?= e($category['image_path']) ?>" alt="<?= e($category['name'] ?? '') ?>" loading="lazy"><?php endif; ?>
      <span class="category-link" aria-hidden="true">&gt;</span>
    </a>
  <?php endforeach; ?></div>
  <?php if ($isCategoryPreview): ?><p class="content-disclaimer">محتوای این بخش نمونه نمایشی است و با ثبت دسته‌بندی‌های واقعی جایگزین می‌شود.</p><?php endif; ?>
</div></section>
