<?php
declare(strict_types=1);

namespace App\\Services;

use InvalidArgumentException;
use RuntimeException;

final class ImageUploadService
{
    private const MAX_BYTES = 5_242_880;
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif',
    ];

    /**
     * Store a validated image in the public uploads directory.
     * Returns a site-relative path, or null when no file was selected.
     */
    public function store(?array $file): ?string
    {
        if ($file === null || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!is_int($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $message = match ($file['error']) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'حجم تصویر از محدودیت مجاز بیشتر است.',
                UPLOAD_ERR_PARTIAL => 'آپلود تصویر کامل نشد؛ دوباره تلاش کنید.',
                UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'امکان ذخیره فایل روی سرور وجود ندارد.',
                UPLOAD_ERR_EXTENSION => 'آپلود فایل توسط تنظیمات سرور متوقف شد.',
                default => 'آپلود تصویر ناموفق بود.',
            };
            throw new InvalidArgumentException($message);
        }

        $tmp = $file['tmp_name'] ?? null;
        $size = $file['size'] ?? 0;
        if (!is_string($tmp) || !is_uploaded_file($tmp) || !is_int($size) || $size < 1 || $size > self::MAX_BYTES) {
            throw new InvalidArgumentException('تصویر باید معتبر و حداکثر ۵ مگابایت باشد.');
        }

        $finfo = new \\finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmp);
        if (!is_string($mime) || !isset(self::MIME_EXTENSIONS[$mime])) {
            throw new InvalidArgumentException('فرمت مجاز: JPG، JPEG، PNG، WEBP و AVIF.');
        }

        $imageInfo = @getimagesize($tmp);
        if (!is_array($imageInfo) || ($imageInfo['mime'] ?? null) !== $mime) {
            throw new InvalidArgumentException('فایل انتخاب‌شده یک تصویر معتبر نیست.');
        }

        $directory = BASE_PATH . '/assets/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('ساخت پوشه آپلود امکان‌پذیر نیست.');
        }
        if (!is_writable($directory)) {
            throw new RuntimeException('پوشه assets/uploads مجوز نوشتن ندارد.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . self::MIME_EXTENSIONS[$mime];
        if (!move_uploaded_file($tmp, $directory . '/' . $filename)) {
            throw new RuntimeException('ذخیره تصویر روی سرور انجام نشد.');
        }

        return '/assets/uploads/' . $filename;
    }
}
