<?php
$featuredProducts = is_array($featuredProducts ?? null) ? $featuredProducts : [];
$productPreview = [
 ['name'=>'گوشی هوشمند سری Pro','category_name'=>'گوشی هوشمند','short_description'=>'نمایش نمونه برای بررسی چیدمان کارت محصول.','image_path'=>'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'هدفون بی‌سیم','category_name'=>'صوتی و تصویری','short_description'=>'نمونه محتوای تصویری برای ارزیابی ویترین.','image_path'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'ساعت هوشمند','category_name'=>'گجت‌های دیجیتال','short_description'=>'کارت نمونه با عنوان و توضیح قابل جایگزینی.','image_path'=>'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'لوازم جانبی دیجیتال','category_name'=>'لوازم جانبی','short_description'=>'تصویر نمونه برای نمایش تراکم و ریتم کارت‌ها.','image_path'=>'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=900&q=82'],
];
$isProductPreview = $featuredProducts === [];
if ($isProductPreview) $featuredProducts = $productPreview;
?>
<section class="section section--soft"><div class="container">
  <div class="section-heading"><div><span class="eyebrow">منتخب کاتالوگ</span><h2>محصولات را از نزدیک‌تر ببین.</h2><p class="section-lead">نگاهی به بخشی از محصولات و گروه‌های موجود در موبایل مدیا.</p></div><a class="text-link" href="<?= e(url('catalog')) ?>">مشاهده محصولات <span aria-hidden="true">&gt;</span></a></div>
  <div class="product-grid" aria-label="محصولات منتخب"><?php foreach ($featuredProducts as $product): ?>
    <article class="product-card"><div class="product-art"><span class="product-label"><?= e($product['category_name'] ?? 'محصول') ?></span>
      <?php if (!empty($product['image_path'])): ?><img src="<?= e($product['image_path']) ?>" alt="<?= e($product['name'] ?? '') ?>" loading="lazy"><?php else: ?><div class="product-placeholder" aria-hidden="true"><span>MM</span><svg viewBox="0 0 120 160"><rect x="25" y="8" width="70" height="144" rx="15"/><rect x="31" y="19" width="58" height="119" rx="8"/><circle cx="60" cy="145" r="3"/></svg></div><?php endif; ?>
    </div><div class="product-info"><span><?= e($product['category_name'] ?? 'محصول') ?></span><h3><?= e($product['name'] ?? '') ?></h3><p><?= e($product['short_description'] ?? '') ?></p><a href="<?= e(url('catalog')) ?>">مشاهده جزئیات <b aria-hidden="true">&gt;</b></a></div></article>
  <?php endforeach; ?></div>
  <?php if ($isProductPreview): ?><p class="content-disclaimer">نام‌ها و تصاویر این کارت‌ها صرفاً داده نمایشی برای بررسی طراحی هستند؛ پیش از انتشار با اطلاعات واقعی جایگزین شوند.</p><?php endif; ?>
</div></section>
