<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class JsonStore
{
    public function __construct(private readonly string $directory = DATA_PATH) {}

    public function read(string $file, array $fallback = []): array
    {
        $path = $this->path($file);
        if (!is_file($path)) {
            return $fallback;
        }
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new RuntimeException('Unable to open data file.');
        }
        try {
            if (!flock($handle, LOCK_SH)) {
                throw new RuntimeException('Unable to lock data file.');
            }
            $contents = stream_get_contents($handle);
            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }
        $decoded = json_decode($contents ?: '', true);
        return is_array($decoded) ? $decoded : $fallback;
    }

    public function write(string $file, array $data): void
    {
        $path = $this->path($file);
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new RuntimeException('Unable to encode JSON data.');
        }
        $handle = fopen($path, 'c+b');
        if ($handle === false) {
            throw new RuntimeException('Unable to open data file for writing.');
        }
        try {
            if (!flock($handle, LOCK_EX)) {
                throw new RuntimeException('Unable to lock data file.');
            }
            ftruncate($handle, 0);
            rewind($handle);
            if (fwrite($handle, $json . PHP_EOL) === false) {
                throw new RuntimeException('Unable to write data file.');
            }
            fflush($handle);
            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }
    }

    private function path(string $file): string
    {
        if (!preg_match('/^[a-z0-9_-]+\.json$/i', $file)) {
            throw new RuntimeException('Invalid data filename.');
        }
        if (!is_dir($this->directory) || !is_writable($this->directory)) {
            throw new RuntimeException('Data directory is not writable.');
        }
        return $this->directory . '/' . $file;
    }
}
