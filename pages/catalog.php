<?php
declare(strict_types=1);
$pageTitle='کاتالوگ محصولات | '.($storeSettings['store_name']??'موبایل‌استور');
require BASE_PATH.'/partials/header.php';
$selectedCategory=trim((string)($_GET['category']??''));
?>
<section class="page-hero"><div class="container"><span class="eyebrow">CATALOG / 2026</span><h1>محصول را پیدا کن،<br><em>بعد حضوری بررسی کن.</em></h1><p>برای قیمت و موجودی نهایی با فروشگاه تماس بگیر.</p></div></section>
<section class="section"><div class="container"><div class="catalog-toolbar"><div><span class="eyebrow">PRODUCT INDEX</span><h2>ویترین محصولات</h2></div><div class="filter-chips" role="group" aria-label="فیلتر دسته‌بندی"><button class="filter-chip<?= $selectedCategory===''?' is-active':'' ?>" data-filter="all">همه</button><?php foreach($categories as $category): ?><button class="filter-chip<?= $selectedCategory===($category['slug']??'')?' is-active':'' ?>" data-filter="<?= e($category['slug']??'') ?>"><?= e($category['name']??'') ?></button><?php endforeach; ?></div></div>
<div class="catalog-grid"><?php foreach($products as $product): $categorySlug=(string)($product['category_slug']??''); ?><article class="product-card" data-category="<?= e($categorySlug) ?>"><div class="product-art"><span class="product-label"><?= e(strtoupper($categorySlug?:'PRODUCT')) ?></span><?php if(!empty($product['image_path'])): ?><img src="<?= e($product['image_path']) ?>" alt="<?= e($product['name']??'') ?>" loading="lazy"><?php endif; ?></div><div class="product-info"><span><?= e($product['category_name']??'محصول') ?></span><h3><?= e($product['name']??'') ?></h3><p><?= e($product['short_description']??'') ?></p><a href="/contact">استعلام محصول <b>←</b></a></div></article><?php endforeach; ?><?php if($products===[]): ?><p class="content-disclaimer">در حال حاضر محصول فعالی در کاتالوگ ثبت نشده است.</p><?php endif; ?></div></div></section>
<?php require BASE_PATH.'/partials/contact-cta.php'; require BASE_PATH.'/partials/footer.php'; ?>
