<?php
$trustProductCount = count($products ?? []);
$trustCategoryCount = count($categories ?? []);
$trustBannerCount = max(3, min(4, count($heroBanners ?? [])));
?>
<section class="trust-strip" aria-label="اطلاعات کاتالوگ"><div class="container trust-grid">
  <div><strong><?= e(number_format($trustProductCount)) ?></strong><span>محصول ثبت‌شده<small>در کاتالوگ</small></span></div>
  <div><strong><?= e(number_format($trustCategoryCount)) ?></strong><span>دسته‌بندی<small>برای مرور سریع‌تر</small></span></div>
  <div><strong><?= e(number_format($trustBannerCount)) ?></strong><span>اسلاید تصویری<small>در اسلایدر اصلی</small></span></div>
  <div><strong>۰۲</strong><span>مسیر ارتباط<small>تماس و مراجعه حضوری</small></span></div>
</div></section>
