<?php
declare(strict_types=1);

namespace App\Middleware;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function verify(?string $token): bool
    {
        return is_string($token)
            && isset($_SESSION['_csrf'])
            && hash_equals($_SESSION['_csrf'], $token);
    }

    public static function formToken(string $scope): string
    {
        self::assertScope($scope);
        $_SESSION['_form_tokens'] ??= [];
        if (empty($_SESSION['_form_tokens'][$scope])) {
            $_SESSION['_form_tokens'][$scope] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_form_tokens'][$scope];
    }

    public static function verifyForm(string $scope, ?string $token): bool
    {
        self::assertScope($scope);
        $expected = $_SESSION['_form_tokens'][$scope] ?? null;
        return is_string($token) && is_string($expected) && hash_equals($expected, $token);
    }

    public static function consumeForm(string $scope): void
    {
        self::assertScope($scope);
        unset($_SESSION['_form_tokens'][$scope]);
        if (empty($_SESSION['_form_tokens'])) {
            unset($_SESSION['_form_tokens']);
        }
    }

    private static function assertScope(string $scope): void
    {
        if (!preg_match('/^[a-z][a-z0-9_-]{1,40}$/', $scope)) {
            throw new \InvalidArgumentException('Invalid CSRF form scope.');
        }
    }
}
