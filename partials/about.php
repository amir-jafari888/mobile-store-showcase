<section class="section about-preview"><div class="container about-preview-inner">
  <div class="about-photo"><img src="<?= e(!empty($storeSettings['about_image_path']) ? url(ltrim($storeSettings['about_image_path'],'/')) : 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1400&q=88') ?>" alt="فضای فروش و تجربه انتخاب محصولات دیجیتال" loading="lazy"></div>
  <div class="about-copy"><span class="eyebrow">درباره موبایل مدیا</span><h2><?= e($storeSettings['about_title'] ?? 'انتخاب فناوری، با دیدی روشن‌تر.') ?></h2>
    <p><?= e($storeSettings['about_text_1'] ?? '') ?></p>
    <p><?= e($storeSettings['about_text_2'] ?? '') ?></p>
    <div class="about-facts"><div><strong>۰۱</strong><span>مرور دسته‌بندی‌ها</span></div><div><strong>۰۲</strong><span>بررسی محصولات</span></div><div><strong>۰۳</strong><span>راهنمایی انتخاب</span></div><div><strong>۰۴</strong><span>ارتباط مستقیم</span></div></div>
    <a class="text-link" href="<?= e(url('about')) ?>">بیشتر درباره ما <span aria-hidden="true">&gt;</span></a>
  </div>
</div></section>
