<?php $storeSettings=$storeSettings??[]; ?>
<footer class="site-footer">
  <div class="container footer-main">
    <div class="footer-brand">
      <a class="brand brand-light" href="<?= e(url()) ?>"><span class="brand-mark" aria-hidden="true">M</span><span class="brand-name"><?= e($storeSettings['store_name'] ?? 'موبایل مدیا') ?><small>MOBILE MEDIA</small></span></a>
      <p><?= e($storeSettings['footer_description'] ?? '') ?></p>
    </div>
    <div><h3>دسترسی سریع</h3><a href="<?= e(url()) ?>">خانه</a><a href="<?= e(url('catalog')) ?>">کاتالوگ محصولات</a><a href="<?= e(url('about')) ?>">درباره ما</a><a href="<?= e(url('contact')) ?>">تماس با ما</a></div>
    <div><h3>ارتباط با فروشگاه</h3>
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
