<?php
$featuredProducts = is_array($featuredProducts ?? null) ? $featuredProducts : [];
$allProducts = is_array($products ?? null) ? $products : [];
if ($featuredProducts === [] && $allProducts !== []) $featuredProducts = array_slice($allProducts, 0, 8);
$productPreview = [
 ['name'=>'گوشی هوشمند سری Pro','category_name'=>'گوشی هوشمند','short_description'=>'نمایش نمونه برای بررسی چیدمان کارت محصول.','image_path'=>'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'هدفون بی‌سیم','category_name'=>'صوتی و تصویری','short_description'=>'نمونه محتوای تصویری برای ارزیابی ویترین.','image_path'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'ساعت هوشمند','category_name'=>'گجت‌های دیجیتال','short_description'=>'کارت نمونه با عنوان و توضیح قابل جایگزینی.','image_path'=>'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'لوازم جانبی دیجیتال','category_name'=>'لوازم جانبی','short_description'=>'تصویر نمونه برای نمایش تراکم و ریتم کارت‌ها.','image_path'=>'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=900&q=82'],
];
$isProductPreview = $featuredProducts === [];
if ($isProductPreview) $featuredProducts = $productPreview;
?>
<section class="section section--soft featured-section">
  <div class="container">
    <div class="category-heading-bar featured-heading-bar">
      <h2><?= e($storeSettings['featured_title'] ?? 'منتخب کاتالوگ') ?></h2>
      <div class="category-heading-actions">
        <div class="category-slider-controls" aria-label="کنترل اسلایدر محصولات منتخب">
          <button class="category-slider-arrow" type="button" data-product-prev aria-label="محصول قبلی" disabled><span aria-hidden="true">›</span></button>
          <button class="category-slider-arrow" type="button" data-product-next aria-label="محصول بعدی"><span aria-hidden="true">‹</span></button>
        </div>
        <a class="category-view-all" href="<?= e(url('catalog')) ?>">مشاهده <span aria-hidden="true">&gt;</span></a>
      </div>
    </div>

    <div class="product-slider" data-product-slider>
      <div class="product-track" data-product-track role="list" aria-label="محصولات منتخب">
        <?php foreach ($featuredProducts as $product):
          $productSlug = trim((string)($product['slug'] ?? ''));
          $productUrl = $productSlug !== '' && !$isProductPreview ? url('product?slug=' . rawurlencode($productSlug)) : url('catalog');
        ?>
          <article class="product-card" role="listitem">
            <a class="product-card-link" href="<?= e($productUrl) ?>" aria-label="<?= e('مشاهده ' . ($product['name'] ?? 'محصول')) ?>">
              <div class="product-art">
                <span class="product-label"><?= e($product['category_name'] ?? 'محصول') ?></span>
                <?php if (!empty($product['image_path'])): ?>
                  <img src="<?= e(media_url((string)$product['image_path'])) ?>" alt="<?= e($product['name'] ?? '') ?>" loading="lazy">
                <?php else: ?>
                  <div class="product-placeholder" aria-hidden="true"><span>MM</span><svg viewBox="0 0 120 160"><rect x="25" y="8" width="70" height="144" rx="15"/><rect x="31" y="19" width="58" height="119" rx="8"/><circle cx="60" cy="145" r="3"/></svg></div>
                <?php endif; ?>
              </div>
              <div class="product-info">
                <span><?= e($product['category_name'] ?? 'محصول') ?></span>
                <h3><?= e($product['name'] ?? '') ?></h3>
                <?php if (!empty($product['short_description'])): ?><p><?= e($product['short_description']) ?></p><?php endif; ?>
                <?php if (isset($product['price']) && $product['price'] !== '' && $product['price'] !== null && (int)$product['price'] > 0): ?><div class="product-card-price"><strong><?= e(number_format((int)$product['price'])) ?></strong><span>تومان</span></div><?php else: ?><div class="product-card-price is-unpriced">برای اطلاع از قیمت تماس بگیرید</div><?php endif; ?>
                <span class="product-card-action"><?= $productSlug !== '' && !$isProductPreview ? 'مشاهده مشخصات محصول' : 'مشاهده کاتالوگ' ?> <b aria-hidden="true">←</b></span>
              </div>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if ($isProductPreview): ?><p class="content-disclaimer">نام‌ها و تصاویر این کارت‌ها صرفاً داده نمایشی برای بررسی طراحی هستند؛ پیش از انتشار با اطلاعات واقعی جایگزین شوند.</p><?php endif; ?>
  </div>
</section>
