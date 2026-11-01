<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/Config/bootstrap.php';

use App\Core\Database;
use App\Middleware\Csrf;
use App\Services\AdminCatalogService;
use App\Services\AdminStorefrontService;
use App\Services\AuthService;

$expect = static function (bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $message);
    }
};

$pdo = Database::connection();
$pdo->exec('DELETE FROM login_attempts');
$pdo->exec('DELETE FROM products');
$pdo->exec('DELETE FROM categories');
$pdo->exec('DELETE FROM banners');
$pdo->exec('DELETE FROM store_settings');
$pdo->exec("DELETE FROM admins WHERE email LIKE '%@integration.test'");

try {
    // One-time form tokens must validate once and reject replay.
    $_SESSION = [];
    $formToken = Csrf::formToken('integration');
    $expect(Csrf::verifyForm('integration', $formToken), 'one-time form token should validate');
    Csrf::consumeForm('integration');
    $expect(!Csrf::verifyForm('integration', $formToken), 'consumed form token must not replay');

    // Core catalog CRUD and category deletion integrity.
    $catalog = new AdminCatalogService();
    $categoryId = $catalog->saveCategory([
        'name' => 'Integration Category',
        'slug' => 'integration-category',
        'description' => 'Test category',
        'image_path' => '',
        'sort_order' => 1,
        'is_active' => 1,
    ]);
    $productId = $catalog->saveProduct([
        'name' => 'Integration Product',
        'slug' => 'integration-product',
        'category_id' => (string) $categoryId,
        'short_description' => 'Test product',
        'description' => 'Integration test body',
        'image_path' => '',
        'sort_order' => 1,
        'featured' => 1,
        'is_active' => 1,
    ]);
    $catalog->saveProduct([
        'name' => 'Integration Product Updated',
        'slug' => 'integration-product-updated',
        'category_id' => (string) $categoryId,
        'short_description' => 'Updated product',
        'description' => '',
        'image_path' => '',
        'sort_order' => 2,
        'featured' => 0,
        'is_active' => 1,
    ], $productId);
    $catalog->deleteCategory($categoryId);
    $product = $catalog->product($productId);
    $expect($product !== null && $product['category_id'] === null, 'category deletion must preserve product and null its category');
    $catalog->deleteProduct($productId);

    // Banner and settings CRUD.
    $storefront = new AdminStorefrontService();
    $bannerId = $storefront->saveBanner([
        'title' => 'Integration Banner',
        'subtitle' => 'Test',
        'image_path' => '',
        'link_url' => '',
        'sort_order' => 0,
        'is_active' => 1,
    ]);
    $storefront->saveBanner([
        'title' => 'Integration Banner Updated',
        'subtitle' => '',
        'image_path' => '',
        'link_url' => '',
        'sort_order' => 1,
        'is_active' => 0,
    ], $bannerId);
    $expect($storefront->banner($bannerId) !== null, 'banner update should preserve banner');
    $storefront->deleteBanner($bannerId);
    $storefront->saveSettings([
        'store_name' => 'Integration Store',
        'phone' => '',
        'whatsapp' => '',
        'contact_email' => 'integration@integration.test',
        'address' => '',
        'opening_hours' => '',
        'instagram_url' => '',
        'telegram_url' => '',
        'map_url' => '',
    ]);
    $expect(($storefront->settings()['store_name'] ?? '') === 'Integration Store', 'store settings should round-trip');

    // Admin login, session validation, and immediate revocation of disabled accounts.
    $email = 'active-admin@integration.test';
    $password = 'Integration-Password-123!';
    $insertAdmin = $pdo->prepare(
        'INSERT INTO admins (name, email, password_hash, is_active)
         VALUES (:name, :email, :password_hash, 1)'
    );
    $insertAdmin->execute([
        'name' => 'Integration Admin',
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);
    $adminId = (int) $pdo->lastInsertId();

    $_SESSION = [];
    $_SERVER['REMOTE_ADDR'] = '192.0.2.10';
    $auth = new AuthService();
    $expect($auth->login($email, $password), 'valid admin credentials should authenticate');
    $expect($auth->check(), 'authenticated session should be valid');

    $disable = $pdo->prepare('UPDATE admins SET is_active = 0 WHERE id = :id');
    $disable->execute(['id' => $adminId]);
    $expect(!$auth->check(), 'disabled admin account must invalidate existing session');

    $pdo->prepare('UPDATE admins SET is_active = 1 WHERE id = :id')->execute(['id' => $adminId]);

    // Account/IP throttling must persist across requests.
    $_SESSION = [];
    $_SERVER['REMOTE_ADDR'] = '192.0.2.20';
    $lockedEmail = 'locked-admin@integration.test';
    for ($attempt = 0; $attempt < 5; $attempt++) {
        $expect(!$auth->login($lockedEmail, 'incorrect-password'), 'invalid credentials must not authenticate');
    }
    $accountScope = hash('sha256', 'account:192.0.2.20:' . $lockedEmail);
    $checkLock = $pdo->prepare(
        'SELECT blocked_until > NOW() FROM login_attempts WHERE scope_hash = :scope_hash'
    );
    $checkLock->execute(['scope_hash' => $accountScope]);
    $expect((int) $checkLock->fetchColumn() === 1, 'five account failures should activate a temporary block');

    $_SERVER['REMOTE_ADDR'] = '192.0.2.30';
    for ($attempt = 0; $attempt < 10; $attempt++) {
        $auth->login('unknown-' . $attempt . '@integration.test', 'incorrect-password');
    }
    $ipScope = hash('sha256', 'ip:192.0.2.30');
    $checkIpLock = $pdo->prepare(
        'SELECT blocked_until > NOW() FROM login_attempts WHERE scope_hash = :scope_hash'
    );
    $checkIpLock->execute(['scope_hash' => $ipScope]);
    $expect((int) $checkIpLock->fetchColumn() === 1, 'ten failures across accounts should activate an IP block');

    fwrite(STDOUT, "Integration checks passed.\n");
} finally {
    $pdo->exec('DELETE FROM login_attempts');
    $pdo->exec('DELETE FROM products');
    $pdo->exec('DELETE FROM categories');
    $pdo->exec('DELETE FROM banners');
    $pdo->exec('DELETE FROM store_settings');
    $pdo->exec("DELETE FROM admins WHERE email LIKE '%@integration.test'");
}
