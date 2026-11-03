<?php $storeSettings=$storeSettings??[]; ?>
<footer class="site-footer">
  <div class="container footer-main">
    <div class="footer-brand">
      <a class="brand brand-light" href="<?= e(url()) ?>">
        <span class="brand-mark" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6.5" y="2.75" width="11" height="18.5" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
            <path d="M10 5.8h4M10.5 18.2h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </span>
        <span class="brand-name"><?= e($storeSettings['store_name'] ?? 'موبایل مدیا') ?><small>MOBILE MEDIA</small></span>
      </a>
      <p><?= e($storeSettings['footer_description'] ?? 'ویترین دیجیتال موبایل مدیا؛ برای اطلاع از موجودی و جزئیات خرید با فروشگاه در ارتباط باشید.') ?></p>
    </div>
    <div>
      <h3>دسترسی سریع</h3>
      <a href="<?= e(url()) ?>">خانه</a><a href="<?= e(url('catalog')) ?>">کاتالوگ محصولات</a><a href="<?= e(url('about')) ?>">درباره ما</a><a href="<?= e(url('contact')) ?>">تماس با ما</a>
    </div>
    <div>
      <h3>ارتباط با فروشگاه</h3>
      <?php if(!empty($storeSettings['phone'])): ?><a href="tel:<?= e(preg_replace('/[^0-9+]/','',$storeSettings['phone'])) ?>"><?= e($storeSettings['phone']) ?></a><?php endif; ?>
      <?php if(!empty($storeSettings['address'])): ?><span><?= e($storeSettings['address']) ?></span><?php endif; ?>
      <?php if(!empty($storeSettings['opening_hours'])): ?><span><?= e($storeSettings['opening_hours']) ?></span><?php endif; ?>
      <?php if(empty($storeSettings['phone'])&&empty($storeSettings['address'])&&empty($storeSettings['opening_hours'])): ?><span>اطلاعات تماس هنوز ثبت نشده است.</span><?php endif; ?>
    </div>
  </div>
  <div class="container footer-bottom"><span>© <?= date('Y') ?> <?= e($storeSettings['store_name'] ?? 'موبایل مدیا') ?></span><span>ویترین دیجیتال محصولات</span></div>
</footer>
</main>
<script type="module" src="<?= e(asset('js/main.js')) ?>"></script>
</body></html>
