<?php
declare(strict_types=1);
$pageTitle='کاتالوگ محصولات | موبایل مدیا';
require BASE_PATH.'/partials/header.php';
$selectedCategory=trim((string)($_GET['category']??''));
$categoryPreview=[
 ['name'=>'گوشی هوشمند','description'=>'مدل‌ها و نسل‌های مختلف تلفن همراه','slug'=>'smartphones'],
 ['name'=>'لوازم جانبی','description'=>'تجهیزات کاربردی برای استفاده روزمره','slug'=>'accessories'],
 ['name'=>'صوتی و تصویری','description'=>'هدفون، اسپیکر و ابزارهای چندرسانه‌ای','slug'=>'audio'],
 ['name'=>'گجت‌های دیجیتال','description'=>'ابزارهای هوشمند و همراه','slug'=>'gadgets'],
];
$productPreview=[
 ['name'=>'گوشی هوشمند سری Pro','category_name'=>'گوشی هوشمند','category_slug'=>'smartphones','short_description'=>'نمونه نمایشی برای بررسی کارت محصول و صفحه کاتالوگ.','image_path'=>'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'گوشی هوشمند سری Plus','category_name'=>'گوشی هوشمند','category_slug'=>'smartphones','short_description'=>'محتوای نمونه؛ مشخصات نهایی پس از ورود اطلاعات جایگزین می‌شود.','image_path'=>'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'هدفون بی‌سیم','category_name'=>'صوتی و تصویری','category_slug'=>'audio','short_description'=>'نمونه تصویری برای ارزیابی تناسب تصویر و متن.','image_path'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'ساعت هوشمند','category_name'=>'گجت‌های دیجیتال','category_slug'=>'gadgets','short_description'=>'نمونه نمایشی برای بررسی تنوع محصولات.','image_path'=>'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'شارژر و کابل','category_name'=>'لوازم جانبی','category_slug'=>'accessories','short_description'=>'محتوای نمونه برای مشاهده چیدمان شبکه محصولات.','image_path'=>'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=900&q=82'],
 ['name'=>'اسپیکر قابل حمل','category_name'=>'صوتی و تصویری','category_slug'=>'audio','short_description'=>'اطلاعات این کارت نمونه است و قیمت یا موجودی ندارد.','image_path'=>'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=900&q=82'],
];
$isCategoryPreview=empty($categories);
$isProductPreview=empty($products);
if($isCategoryPreview)$categories=$categoryPreview;
if($isProductPreview)$products=$productPreview;
?>
<section class="page-hero catalog-hero"><div class="container"><span class="eyebrow">موبایل مدیا / کاتالوگ</span><h1>محصول مناسب را<br><em>پیدا کن.</em></h1><p>دسته‌بندی‌ها را مرور کن، نام محصول را جست‌وجو کن و برای اطلاعات موجودی و قیمت با مجموعه در ارتباط باش.</p></div></section>
<section class="section catalog-section"><div class="container">
  <div class="catalog-toolbar"><div><span class="eyebrow">مجموعه محصولات</span><h2>کاتالوگ محصولات</h2><p class="catalog-result-label"><strong data-catalog-count><?= count($products) ?></strong> محصول در این ویترین</p></div>
    <div class="catalog-tools"><label class="catalog-search"><span class="sr-only">جست‌وجوی محصول</span><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input type="search" data-catalog-search placeholder="نام محصول را جست‌وجو کن…" autocomplete="off"></label>
      <label class="catalog-sort"><span>مرتب‌سازی</span><select data-catalog-sort><option value="default">ترتیب پیش‌فرض</option><option value="name">نام محصول</option></select></label>
    </div>
  </div>
  <?php if($isProductPreview || $isCategoryPreview): ?><p class="catalog-preview-note">داده‌های این صفحه نمونه نمایشی هستند و برای بررسی طراحی استفاده می‌شوند؛ پیش از انتشار با اطلاعات واقعی جایگزین شوند.</p><?php endif; ?>
  <div class="catalog-layout">
    <aside class="catalog-sidebar" aria-label="فیلتر دسته‌بندی"><h3>دسته‌بندی‌ها</h3><button class="filter-chip<?= $selectedCategory===''?' is-active':'' ?>" data-filter="all" aria-pressed="<?= $selectedCategory===''?'true':'false' ?>">همه محصولات <span><?= count($products) ?></span></button>
    <?php foreach($categories as $category): $slug=(string)($category['slug']??''); ?><button class="filter-chip<?= $selectedCategory===$slug?' is-active':'' ?>" data-filter="<?= e($slug) ?>" aria-pressed="<?= $selectedCategory===$slug?'true':'false' ?>"><?= e($category['name']??'') ?></button><?php endforeach; ?>
    </aside>
    <div class="catalog-main"><div class="catalog-mobile-filters" aria-label="فیلتر دسته‌بندی"><button class="filter-chip<?= $selectedCategory===''?' is-active':'' ?>" data-filter="all" aria-pressed="<?= $selectedCategory===''?'true':'false' ?>">همه</button><?php foreach($categories as $category): $slug=(string)($category['slug']??''); ?><button class="filter-chip<?= $selectedCategory===$slug?' is-active':'' ?>" data-filter="<?= e($slug) ?>" aria-pressed="<?= $selectedCategory===$slug?'true':'false' ?>"><?= e($category['name']??'') ?></button><?php endforeach; ?></div>
      <div class="catalog-grid" data-catalog-grid><?php foreach($products as $index=>$product): $categorySlug=(string)($product['category_slug']??''); $productName=(string)($product['name']??''); $description=(string)($product['short_description']??''); ?>
        <article class="product-card catalog-product" data-category="<?= e($categorySlug) ?>" data-search="<?= e($productName.' '.$description.' '.($product['category_name']??'')) ?>" data-name="<?= e($productName) ?>" data-order="<?= (int)$index ?>">
          <div class="product-art"><span class="product-label"><?= e($product['category_name']??'محصول') ?></span><?php if(!empty($product['image_path'])): ?><img src="<?= e(media_url((string) $product['image_path'])) ?>" alt="<?= e($productName) ?>" loading="lazy"><?php else: ?><div class="product-placeholder" aria-hidden="true"><span>MM</span><svg viewBox="0 0 120 160"><rect x="25" y="8" width="70" height="144" rx="15"/><rect x="31" y="19" width="58" height="119" rx="8"/><circle cx="60" cy="145" r="3"/></svg></div><?php endif; ?></div>
          <div class="product-info"><span><?= e($product['category_name']??'محصول') ?></span><h3><?= e($productName) ?></h3><p><?= e($description) ?></p><?php if($isProductPreview): ?><small class="demo-note">نمونه نمایشی</small><?php endif; ?><a href="<?= e(url('contact')) ?>">استعلام موجودی و قیمت <b aria-hidden="true">&gt;</b></a></div>
        </article>
      <?php endforeach; ?></div>
      <p class="catalog-empty" data-catalog-empty <?= $products===[]?'':'hidden' ?>>در حال حاضر محصولی برای نمایش ثبت نشده است.</p><p class="catalog-no-results" data-catalog-no-results hidden>محصولی با این عبارت پیدا نشد. عبارت دیگری را امتحان کن.</p>
    </div>
  </div>
</div></section>
<?php require BASE_PATH.'/partials/contact-cta.php'; require BASE_PATH.'/partials/footer.php'; ?>
