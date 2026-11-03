<section class="section benefits-section" aria-labelledby="benefits-title">
  <div class="container benefits-layout">
    <div class="benefits-intro">
      <span class="eyebrow">چرا موبایل مدیا؟</span>
      <h2 id="benefits-title"><?= e($storeSettings['benefits_title'] ?? 'انتخاب با شناخت بیشتر، با اطلاعات روشن‌تر.') ?></h2>
      <p class="section-lead"><?= e($storeSettings['benefits_description'] ?? '') ?></p>
      <a class="button button-light benefits-cta" href="<?= e(url('about')) ?>">آشنایی با موبایل مدیا <span aria-hidden="true">←</span></a>
    </div>

    <div class="benefit-list">
      <article class="benefit-card">
        <div class="benefit-card-top">
          <span class="benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 4.75h8A2.25 2.25 0 0 1 18.25 7v13H5.75V7A2.25 2.25 0 0 1 8 4.75Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 4.75V3.5h6v1.25M8.75 10h6.5M8.75 13.5h6.5M8.75 17h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
          </span>
          <span class="benefit-index">۰۱</span>
        </div>
        <div class="benefit-card-copy">
          <h3><?= e($storeSettings['benefit_1_title'] ?? '') ?></h3>
          <p><?= e($storeSettings['benefit_1_text'] ?? '') ?></p>
        </div>
      </article>

      <article class="benefit-card">
        <div class="benefit-card-top">
          <span class="benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3.75" y="3.75" width="7" height="7" rx="1.7" stroke="currentColor" stroke-width="1.6"/><rect x="13.25" y="3.75" width="7" height="7" rx="1.7" stroke="currentColor" stroke-width="1.6"/><rect x="3.75" y="13.25" width="7" height="7" rx="1.7" stroke="currentColor" stroke-width="1.6"/><rect x="13.25" y="13.25" width="7" height="7" rx="1.7" stroke="currentColor" stroke-width="1.6"/></svg>
          </span>
          <span class="benefit-index">۰۲</span>
        </div>
        <div class="benefit-card-copy">
          <h3><?= e($storeSettings['benefit_2_title'] ?? '') ?></h3>
          <p><?= e($storeSettings['benefit_2_text'] ?? '') ?></p>
        </div>
      </article>

      <article class="benefit-card">
        <div class="benefit-card-top">
          <span class="benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12.25a8 8 0 1 1 3.05 6.27L4 20l.8-3.5A7.96 7.96 0 0 1 4 12.25Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12h8M8 8.75h5M8 15.25h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
          </span>
          <span class="benefit-index">۰۳</span>
        </div>
        <div class="benefit-card-copy">
          <h3><?= e($storeSettings['benefit_3_title'] ?? '') ?></h3>
          <p><?= e($storeSettings['benefit_3_text'] ?? '') ?></p>
        </div>
      </article>
    </div>
  </div>
</section>
