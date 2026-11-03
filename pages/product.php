<?php
declare(strict_types=1);

$slug = trim((string) ($_GET['slug'] ?? ''));
$product = $slug !== '' ? (new \App\Services\CatalogService())->findProductBySlug($slug) : null;

if ($product === null) {
    http_response_code(404);
    require BASE_PATH . '/pages/404.php';
    return;
}

$pageTitle = (string) ($product['name'] ?? 'محصول') . ' | ' . (string) ($storeSettings['store_name'] ?? 'موبایل مدیا');
require BASE_PATH . '/partials/header.php';

$productName = (string) ($product['name'] ?? 'محصول');
$productImage = trim((string) ($product['image_path'] ?? ''));
$productDescription = trim((string) ($product['description'] ?? ''));
$productSummary = trim((string) ($product['short_description'] ?? ''));
$productPrice = isset($product['price']) && $product['price'] !== '' && $product['price'] !== null && (int) $product['price'] > 0 ? (int) $product['price'] : null;
?>
<section class="page-hero product-detail-hero">
  <div class="container">
    <nav class="product-breadcrumb" aria-label="مسیر صفحه">
      <a href="<?= e(url()) ?>">خانه</a><span aria-hidden="true">/</span><a href="<?= e(url('catalog')) ?>">کاتالوگ</a><span aria-hidden="true">/</span><span><?= e($productName) ?></span>
    </nav>
    <span class="eyebrow"><?= e($product['category_name'] ?? 'محصول دیجیتال') ?></span>
    <h1><?= e($productName) ?></h1>
    <?php if ($productSummary !== ''): ?><p><?= e($productSummary) ?></p><?php endif; ?>
  </div>
</section>
<section class="section product-detail-section">
  <div class="container product-detail-layout">
    <div class="product-detail-media">
      <?php if ($productImage !== ''): ?>
        <img src="<?= e(media_url($productImage)) ?>" alt="<?= e($productName) ?>" fetchpriority="high">
      <?php else: ?>
        <div class="product-placeholder" aria-hidden="true"><span>MM</span><svg viewBox="0 0 120 160"><rect x="25" y="8" width="70" height="144" rx="15"/><rect x="31" y="19" width="58" height="119" rx="8"/><circle cx="60" cy="145" r="3"/></svg></div>
      <?php endif; ?>
    </div>
    <div class="product-detail-copy">
      <span class="eyebrow">مشخصات محصول</span>
      <h2>درباره <?= e($productName) ?></h2>
      <div class="product-detail-price"><?php if ($productPrice !== null): ?><strong><?= e(number_format($productPrice)) ?></strong><span>تومان</span><?php else: ?><span>برای اطلاع از قیمت تماس بگیرید</span><?php endif; ?></div>
      <p><?= e($productDescription !== '' ? $productDescription : ($productSummary !== '' ? $productSummary : 'برای دریافت اطلاعات تکمیلی این محصول با فروشگاه در ارتباط باش.')) ?></p>
      <div class="product-detail-note"><strong>نیاز به اطلاعات بیشتر داری؟</strong><span>برای اطلاع از موجودی و جزئیات بیشتر محصول با موبایل مدیا تماس بگیر.</span></div>
      <div class="product-detail-actions">
        <a class="button button-primary" href="<?= e(url('contact')) ?>">استعلام قیمت و موجودی</a>
        <a class="text-link" href="<?= e(url('catalog')) ?>">بازگشت به کاتالوگ <span aria-hidden="true">←</span></a>
      </div>
    </div>
  </div>
</section>
<?php require BASE_PATH . '/partials/contact-cta.php'; require BASE_PATH . '/partials/footer.php'; ?>
