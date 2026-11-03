<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\\Core\\Response;
use App\\Middleware\\Csrf;
use App\\Services\\AuthService;

$auth = new AuthService();

$adminHome = url('admin/');

$resolveNext = static function ($candidate) use ($adminHome): string {
    if (!is_string($candidate) || $candidate === ''
        || preg_match('/[\\x00-\\x1F\\x7F\\\\\\\\]/', $candidate)) {
        return $adminHome;
    }

    $parts = parse_url($candidate);
    if ($parts === false
        || isset($parts['scheme'])
        || isset($parts['host'])
        || isset($parts['user'])
        || isset($parts['pass'])
        || !str_starts_with((string) ($parts['path'] ?? ''), $adminHome)) {
        return $adminHome;
    }

    return $candidate;
};

$nextCandidate = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? ($_POST['next'] ?? null)
    : ($_GET['next'] ?? null);
$next = $resolveNext($nextCandidate);

if ($auth->check()) {
    Response::redirect($next);
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $token = $_POST['_csrf'] ?? null;

    if (!Csrf::verify(is_string($token) ? $token : null)) {
        $errors[] = 'درخواست نامعتبر است. صفحه را تازه‌سازی کنید و دوباره تلاش کنید.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $errors[] = 'ایمیل یا رمز عبور صحیح نیست.';
    } elseif (!$auth->login($email, $password)) {
        $errors[] = 'ایمیل یا رمز عبور صحیح نیست یا موقتاً امکان ورود وجود ندارد.';
    } else {
        Response::redirect($next);
    }
}

$pageTitle = 'ورود مدیر | پنل مدیریت';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= e(url('admin/assets/css/login.css')) ?>">
    <script src="<?= e(url('admin/assets/js/login.js')) ?>" defer></script>
</head>
<body class="admin-auth-page">
<main class="admin-auth-card">
    <h1>ورود به حساب مدیریت</h1>
    <p class="admin-auth-intro">برای ادامه، ایمیل و رمز عبور حساب مدیریتی خود را وارد کنید.</p>

    <?php if ($errors): ?>
        <div class="admin-auth-error" role="alert" aria-live="assertive"><?= e($errors[0]) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(url('admin/login.php')) ?>">
        <input type="hidden" name="_csrf" value="<?= e(Csrf::token()) ?>">
        <input type="hidden" name="next" value="<?= e($next) ?>">

        <div class="admin-auth-field">
            <label for="email">ایمیل</label>
            <input
                id="email"
                name="email"
                type="email"
                value="<?= e($email) ?>"
                autocomplete="username"
                inputmode="email"
                dir="ltr"
                placeholder="name@example.com"
                required
                autofocus
            >
        </div>

        <div class="admin-auth-field">
            <label for="password">رمز عبور</label>
            <div class="admin-auth-password-wrap">
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="رمز عبور خود را وارد کنید"
                    required
                >
                <button
                    class="admin-auth-password-toggle"
                    type="button"
                    data-password-toggle
                    aria-label="نمایش رمز عبور"
                    aria-pressed="false"
                    aria-controls="password"
                >
                    <svg data-icon="eye-off" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"></path>
                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c5.2 0 8.8 4.8 9.8 6.5a1 1 0 0 1 0 1c-.4.7-1.3 2-2.7 3.2"></path>
                        <path d="M6.2 6.2C3.9 7.6 2.5 9.7 2.2 11.5a1 1 0 0 0 0 1C3.2 14.2 6.8 19 12 19c1 0 2-.2 2.9-.5"></path>
                    </svg>
                    <svg data-icon="eye" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M2.2 12s3.6-7 9.8-7 9.8 7 9.8 7-3.6 7-9.8 7-9.8-7-9.8-7Z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <button class="admin-auth-submit" type="submit">ورود به پنل</button>
    </form>

    <a class="admin-auth-back" href="<?= e(url()) ?>">بازگشت به وب‌سایت</a>
</main>
</body>
</html>
