<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageOptimizer
{
    /**
     * Create or refresh a WebP derivative next to the source image.
     *
     * @return array{ok: bool, path?: string, bytes_in?: int, bytes_out?: int, skipped?: string, error?: string}
     */
    public function toWebp(string $absolutePath, int $maxWidth = 1600, int $quality = 78): array
    {
        if (! is_file($absolutePath)) {
            return ['ok' => false, 'error' => 'File not found'];
        }

        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring')) {
            return ['ok' => false, 'error' => 'GD WebP support is not available'];
        }

        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        if (! in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            return ['ok' => false, 'skipped' => 'unsupported type'];
        }

        $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $absolutePath);
        if (! is_string($target)) {
            return ['ok' => false, 'error' => 'Could not build WebP path'];
        }

        $bytesIn = (int) filesize($absolutePath);

        if (is_file($target) && filemtime($target) >= filemtime($absolutePath)) {
            return [
                'ok' => true,
                'path' => $target,
                'bytes_in' => $bytesIn,
                'bytes_out' => (int) filesize($target),
                'skipped' => 'up to date',
            ];
        }

        $binary = @file_get_contents($absolutePath);
        if ($binary === false) {
            return ['ok' => false, 'error' => 'Unreadable source'];
        }

        $source = @imagecreatefromstring($binary);
        if ($source === false) {
            return ['ok' => false, 'error' => 'Decode failed'];
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) max(1, round($height * ($maxWidth / $width)));
            $canvas = imagecreatetruecolor($newWidth, $newHeight);
            if ($canvas === false) {
                imagedestroy($source);

                return ['ok' => false, 'error' => 'Resize failed'];
            }

            if ($extension === 'png') {
                imagealphablending($canvas, false);
                imagesavealpha($canvas, true);
            }

            imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $canvas;
        } elseif ($extension === 'png') {
            imagealphablending($source, true);
            imagesavealpha($source, true);
        }

        $written = @imagewebp($source, $target, $quality);
        imagedestroy($source);

        if (! $written || ! is_file($target)) {
            return ['ok' => false, 'error' => 'WebP encode failed'];
        }

        $bytesOut = (int) filesize($target);

        if ($bytesOut >= $bytesIn) {
            // Keep original when WebP is not smaller.
            File::delete($target);

            return ['ok' => false, 'skipped' => 'webp not smaller', 'bytes_in' => $bytesIn];
        }

        return [
            'ok' => true,
            'path' => $target,
            'bytes_in' => $bytesIn,
            'bytes_out' => $bytesOut,
        ];
    }

    /**
     * @return list<array{ok: bool, source: string, path?: string, bytes_in?: int, bytes_out?: int, skipped?: string, error?: string}>
     */
    public function optimizeDirectory(string $directory, int $maxWidth = 1600, int $quality = 78): array
    {
        if (! is_dir($directory)) {
            return [];
        }

        $results = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
        );

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $ext = strtolower($file->getExtension());
            if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                continue;
            }

            // Skip thumbnail helpers and already-tiny assets.
            if (str_contains($file->getPathname(), DIRECTORY_SEPARATOR.'_thumbs'.DIRECTORY_SEPARATOR)) {
                continue;
            }

            $result = $this->toWebp($file->getPathname(), $maxWidth, $quality);
            $results[] = array_merge(['source' => $file->getPathname()], $result);
        }

        return $results;
    }

    public function webpPublicPath(string $publicRelativePath): ?string
    {
        $relative = ltrim(str_replace('\\', '/', $publicRelativePath), '/');
        $webpRelative = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative);

        if (! is_string($webpRelative) || $webpRelative === $relative) {
            return null;
        }

        return is_file(public_path($webpRelative)) ? $webpRelative : null;
    }
}
