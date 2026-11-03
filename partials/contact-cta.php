<?php $storeSettings=$storeSettings??[]; ?>
<section class="contact-cta"><div class="container cta-inner">
  <div>
    <span class="eyebrow">ارتباط با موبایل مدیا</span>
    <h2><?= e($storeSettings['contact_cta_title'] ?? 'قبل از خرید، با اطمینان انتخاب کن.') ?></h2>
    <p><?= e($storeSettings['contact_cta_description'] ?? 'برای بررسی موجودی، قیمت و دریافت راهنمایی با فروشگاه در ارتباط باش.') ?></p>
  </div>
  <div class="cta-actions">
    <a class="button button-light" href="<?= e(url('contact')) ?>">اطلاعات تماس</a>
    <a class="button button-dark" href="<?= e(url('catalog')) ?>">مشاهده محصولات</a>
  </div>
  <span class="cta-decoration" aria-hidden="true">M</span>
</div></section>
