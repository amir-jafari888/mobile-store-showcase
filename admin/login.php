<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Core\Response;
use App\Middleware\Csrf;
use App\Services\AuthService;

$auth = new AuthService();

$resolveNext = static function ($candidate): string {
    if (!is_string($candidate) || $candidate === ''
        || preg_match('/[\x00-\x1F\x7F\\\\]/', $candidate)) {
        return '/admin/';
    }

    $parts = parse_url($candidate);
    if ($parts === false
        || isset($parts['scheme'])
        || isset($parts['host'])
        || isset($parts['user'])
        || isset($parts['pass'])
        || !str_starts_with((string) ($parts['path'] ?? ''), '/admin/')) {
        return '/admin/';
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
    <link rel="stylesheet" href="/admin/assets/css/main.css">
    <style>
        .admin-auth-page{min-height:100vh;display:grid;place-items:center;padding:24px;background:var(--admin-bg,#f8fafc)}
        .admin-auth-card{width:min(100%,430px);background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:32px;box-shadow:0 18px 50px rgba(15,23,42,.08)}
        .admin-auth-brand{display:flex;align-items:center;gap:12px;margin-bottom:28px;color:#0f172a;text-decoration:none}
        .admin-auth-brand>span{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#172554;color:#fff;font-weight:800}
        .admin-auth-brand b{display:block;font-size:18px}.admin-auth-brand small{display:block;color:#64748b;margin-top:3px}
        .admin-auth-card h1{margin:0 0 8px;font-size:26px;color:#0f172a}.admin-auth-card>p{margin:0 0 24px;color:#64748b;line-height:1.8}
        .admin-auth-field{display:grid;gap:8px;margin-bottom:16px}.admin-auth-field label{font-weight:700;color:#0f172a}.admin-auth-field input{width:100%;box-sizing:border-box;border:1px solid #cbd5e1;border-radius:10px;padding:12px 14px;font:inherit;outline:none}.admin-auth-field input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12)}
        .admin-auth-error{margin-bottom:18px;padding:12px 14px;border-radius:10px;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;line-height:1.7}
        .admin-auth-submit{width:100%;border:0;border-radius:10px;padding:13px 16px;background:#2563eb;color:#fff;font:inherit;font-weight:700;cursor:pointer}.admin-auth-submit:hover{background:#1d4ed8}
        .admin-auth-back{display:block;margin-top:18px;text-align:center;color:#64748b;text-decoration:none;font-size:14px}
    </style>
</head>
<body class="admin-auth-page">
<main class="admin-auth-card">
    <a class="admin-auth-brand" href="/">
        <span>M</span><div><b>موبایل‌استور</b><small>پنل مدیریت</small></div>
    </a>
    <h1>ورود مدیر</h1>
    <p>برای دسترسی به پنل مدیریت، اطلاعات حساب مدیر را وارد کنید.</p>

    <?php if ($errors): ?>
        <div class="admin-auth-error" role="alert"><?= e($errors[0]) ?></div>
    <?php endif; ?>

    <form method="post" action="/admin/login.php">
        <input type="hidden" name="_csrf" value="<?= e(Csrf::token()) ?>">
        <input type="hidden" name="next" value="<?= e($next) ?>">
        <div class="admin-auth-field">
            <label for="email">ایمیل</label>
            <input id="email" name="email" type="email" value="<?= e($email) ?>" autocomplete="username" required autofocus>
        </div>
        <div class="admin-auth-field">
            <label for="password">رمز عبور</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
        </div>
        <button class="admin-auth-submit" type="submit">ورود به پنل</button>
    </form>
    <a class="admin-auth-back" href="/">بازگشت به وب‌سایت</a>
</main>
</body>
</html>
