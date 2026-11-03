<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Middleware\AdminGuard;
use App\Middleware\Csrf;
use App\Services\AdminAccountService;

AdminGuard::require();

$admin = (new \App\Services\AuthService())->admin() ?? [];
$adminId = (int) ($admin['id'] ?? 0);
$pageTitle = 'تنظیمات حساب مدیر';
$activeSection = 'account';
$service = new AdminAccountService();
$error = '';
$success = (string) ($_SESSION['admin_account_flash'] ?? '');
unset($_SESSION['admin_account_flash']);
$profile = $service->profile($adminId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $token = $_POST['_csrf'] ?? null;
        if (!Csrf::verify(is_string($token) ? $token : null)) {
            throw new InvalidArgumentException('درخواست معتبر نیست؛ صفحه را تازه‌سازی کنید.');
        }

        $service->update(
            $adminId,
            (string) ($_POST['name'] ?? ''),
            (string) ($_POST['email'] ?? ''),
            (string) ($_POST['current_password'] ?? ''),
            (string) ($_POST['new_password'] ?? '')
        );

        $_SESSION['admin_account_flash'] = 'اطلاعات حساب مدیر با موفقیت به‌روزرسانی شد.';
        header('Location: ' . url('admin/account.php'), true, 303);
        exit;
    } catch (InvalidArgumentException $exception) {
        $error = $exception->getMessage();
        $profile['name'] = (string) ($_POST['name'] ?? $profile['name']);
        $profile['email'] = (string) ($_POST['email'] ?? $profile['email']);
    } catch (Throwable $exception) {
        $error = 'ذخیره تغییرات انجام نشد. اتصال دیتابیس را بررسی کنید.';
    }
}

require __DIR__ . '/partials/header.php';
?>
<section class="admin-panel account-panel">
    <div class="panel-heading">
        <div>
            <span>امنیت و مشخصات ورود</span>
            <h2>اطلاعات حساب مدیر</h2>
        </div>
    </div>

    <?php if ($error !== ''): ?>
        <div class="crud-alert error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>
    <?php if ($success !== ''): ?>
        <div class="crud-alert success" role="status"><?= e($success) ?></div>
    <?php endif; ?>

    <form class="crud-form account-form" method="post" action="<?= e(url('admin/account.php')) ?>" autocomplete="off">
        <input type="hidden" name="_csrf" value="<?= e(Csrf::token()) ?>">

        <label>
            نام مدیر
            <input type="text" name="name" maxlength="120" value="<?= e($profile['name'] ?? '') ?>" autocomplete="name" required>
        </label>

        <label>
            ایمیل ورود
            <input type="email" name="email" maxlength="190" value="<?= e($profile['email'] ?? '') ?>" autocomplete="username" dir="ltr" required>
        </label>

        <div class="account-section-title wide">
            <strong>تغییر رمز عبور</strong>
            <span>اگر قصد تغییر رمز را ندارید، فیلد رمز جدید را خالی بگذارید.</span>
        </div>

        <label class="wide">
            رمز عبور فعلی
            <input type="password" name="current_password" autocomplete="current-password" required>
        </label>

        <label class="wide">
            رمز عبور جدید
            <input type="password" name="new_password" minlength="12" autocomplete="new-password" placeholder="حداقل ۱۲ کاراکتر؛ اختیاری">
            <small>برای حفظ امنیت حساب، رمز جدید باید حداقل ۱۲ کاراکتر داشته باشد.</small>
        </label>

        <div class="crud-actions">
            <button class="crud-button primary" type="submit">ذخیره تغییرات حساب</button>
        </div>
    </form>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
