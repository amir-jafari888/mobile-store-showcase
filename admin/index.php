<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/app/Config/bootstrap.php';
http_response_code(501);
$pageTitle='پنل مدیریت';
require BASE_PATH . '/partials/header.php';
?>
<main class="page container"><h1>پنل مدیریت</h1><p>زیرساخت پنل ایجاد شده است. ورود مدیر و عملیات نوشتن تا زمان پیاده‌سازی احراز هویت امن فعال نیستند.</p></main>
<?php require BASE_PATH . '/partials/footer.php'; ?>