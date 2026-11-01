<?php
declare(strict_types=1);
$pageTitle='تماس با ما | '.($storeSettings['store_name']??'موبایل‌استور');
require BASE_PATH.'/partials/header.php';
$phone=trim((string)($storeSettings['phone']??''));$whatsapp=trim((string)($storeSettings['whatsapp']??''));
?>
<section class="page-hero"><div class="container"><span class="eyebrow">ارتباط با فروشگاه</span><h1>سؤالی داری؟<br><em>از ما بپرس.</em></h1><p>برای استعلام محصول، دریافت راهنمایی یا هماهنگی مراجعه از راه‌های ارتباطی فروشگاه استفاده کن.</p></div></section>
<section class="section"><div class="container contact-layout"><div class="contact-cards">
<article><span>01 / PHONE</span><h2>تماس تلفنی</h2><p><?= $phone!==''?e($phone):'شماره تماس هنوز ثبت نشده است.' ?></p><?php if($phone!==''): ?><a href="tel:<?= e(preg_replace('/[^0-9+]/','',$phone)) ?>">تماس با فروشگاه ←</a><?php endif; ?></article>
<article><span>02 / ADDRESS</span><h2>آدرس فروشگاه</h2><p><?= e($storeSettings['address']??'نشانی فروشگاه هنوز ثبت نشده است.') ?></p><?php if(!empty($storeSettings['map_url'])): ?><a href="<?= e($storeSettings['map_url']) ?>" target="_blank" rel="noopener noreferrer">مشاهده نقشه ←</a><?php endif; ?></article>
<article><span>03 / HOURS</span><h2>ساعات فعالیت</h2><p><?= e($storeSettings['opening_hours']??'ساعات کاری هنوز ثبت نشده است.') ?></p></article>
</div><aside class="contact-aside"><span class="eyebrow eyebrow-light">ارتباط مستقیم</span><h2>اطلاعات فروشگاه</h2><p>برای دریافت اطلاعات موجودی و قیمت با فروشگاه در ارتباط باش.</p><?php if($whatsapp!==''): ?><a class="button button-light" href="https://wa.me/<?= e(preg_replace('/\D+/','',$whatsapp)) ?>" target="_blank" rel="noopener noreferrer">گفت‌وگو در واتساپ</a><?php endif; ?><?php if(!empty($storeSettings['instagram_url'])): ?><a href="<?= e($storeSettings['instagram_url']) ?>" target="_blank" rel="noopener noreferrer">اینستاگرام ←</a><?php endif; ?><?php if(!empty($storeSettings['telegram_url'])): ?><a href="<?= e($storeSettings['telegram_url']) ?>" target="_blank" rel="noopener noreferrer">تلگرام ←</a><?php endif; ?><?php if(!empty($storeSettings['contact_email'])): ?><a href="mailto:<?= e($storeSettings['contact_email']) ?>"><?= e($storeSettings['contact_email']) ?></a><?php endif; ?></aside></div></section>
<?php require BASE_PATH.'/partials/footer.php'; ?>
