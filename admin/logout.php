<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Core\Response;
use App\Middleware\Csrf;
use App\Services\AuthService;

$auth = new AuthService();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

$token = $_POST['_csrf'] ?? null;
if (!Csrf::verify(is_string($token) ? $token : null)) {
    http_response_code(403);
    exit('Forbidden');
}

$auth->logout();
unset($_SESSION['_csrf']);
Response::redirect('/admin/login.php');
