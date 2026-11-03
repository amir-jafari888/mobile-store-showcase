<section class="section benefits-section"><div class="container benefits-layout">
  <div class="benefits-intro"><span class="eyebrow">چرا موبایل مدیا؟</span><h2><?= e($storeSettings['benefits_title'] ?? 'انتخاب با شناخت بیشتر، با اطلاعات روشن‌تر.') ?></h2><p class="section-lead"><?= e($storeSettings['benefits_description'] ?? '') ?></p><a class="button button-light" href="<?= e(url('about')) ?>">آشنایی با موبایل مدیا</a></div>
  <div class="benefit-list">
    <article><b>01</b><div><h3><?= e($storeSettings['benefit_1_title'] ?? '') ?></h3><p><?= e($storeSettings['benefit_1_text'] ?? '') ?></p></div></article>
    <article><b>02</b><div><h3><?= e($storeSettings['benefit_2_title'] ?? '') ?></h3><p><?= e($storeSettings['benefit_2_text'] ?? '') ?></p></div></article>
    <article><b>03</b><div><h3><?= e($storeSettings['benefit_3_title'] ?? '') ?></h3><p><?= e($storeSettings['benefit_3_text'] ?? '') ?></p></div></article>
  </div>
</div></section>