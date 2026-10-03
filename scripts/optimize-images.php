<?php

/**
 * Standalone image optimizer for environments where CLI PHP has GD
 * but Laravel's PHP binary may not (e.g. local XAMPP).
 *
 * Usage: c:\xampp\php\php.exe scripts/optimize-images.php
 */

$root = dirname(__DIR__);
$dir = $root.'/public/assets/images';
$maxWidth = 1600;
$quality = 78;

if (! function_exists('imagewebp')) {
    fwrite(STDERR, "GD WebP support required.\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
);

$created = 0;
$saved = 0;
$skipped = 0;

foreach ($iterator as $file) {
    if (! $file->isFile()) {
        continue;
    }

    $path = $file->getPathname();
    if (str_contains($path, DIRECTORY_SEPARATOR.'_thumbs'.DIRECTORY_SEPARATOR)) {
        continue;
    }

    $ext = strtolower($file->getExtension());
    if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        continue;
    }

    $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
    if (! is_string($target)) {
        continue;
    }

    $bytesIn = filesize($path) ?: 0;
    if (is_file($target) && filemtime($target) >= filemtime($path)) {
        $skipped++;
        continue;
    }

    $binary = file_get_contents($path);
    $source = $binary !== false ? @imagecreatefromstring($binary) : false;
    if ($source === false) {
        echo "fail decode {$path}\n";
        continue;
    }

    $width = imagesx($source);
    $height = imagesy($source);
    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int) max(1, round($height * ($maxWidth / $width)));
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        if ($ext === 'png') {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
        }
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);
        $source = $canvas;
    }

    if (! @imagewebp($source, $target, $quality)) {
        imagedestroy($source);
        echo "fail encode {$path}\n";
        continue;
    }
    imagedestroy($source);

    $bytesOut = filesize($target) ?: 0;
    if ($bytesOut >= $bytesIn) {
        unlink($target);
        $skipped++;
        echo "skip larger ".basename($path)."\n";
        continue;
    }

    $created++;
    $saved += ($bytesIn - $bytesOut);
    echo sprintf(
        "webp %s  %.0fKB → %.0fKB\n",
        basename($path),
        $bytesIn / 1024,
        $bytesOut / 1024
    );
}

// Also optimize media library uploads if present.
$mediaDir = $root.'/storage/app/public/media';
if (is_dir($mediaDir)) {
    foreach (glob($mediaDir.'/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE) ?: [] as $path) {
        $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
        if (! is_string($target) || (is_file($target) && filemtime($target) >= filemtime($path))) {
            continue;
        }
        $bytesIn = filesize($path) ?: 0;
        $binary = file_get_contents($path);
        $source = $binary !== false ? @imagecreatefromstring($binary) : false;
        if ($source === false) {
            continue;
        }
        $width = imagesx($source);
        $height = imagesy($source);
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) max(1, round($height * ($maxWidth / $width)));
            $canvas = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $canvas;
        }
        if (@imagewebp($source, $target, $quality)) {
            $bytesOut = filesize($target) ?: 0;
            if ($bytesOut < $bytesIn) {
                $created++;
                $saved += ($bytesIn - $bytesOut);
                echo sprintf("webp media/%s  %.0fKB → %.0fKB\n", basename($path), $bytesIn / 1024, $bytesOut / 1024);
            } else {
                unlink($target);
            }
        }
        imagedestroy($source);
    }
}

echo sprintf("\nDone. Created %d WebP files, saved %.2f MB (%d skipped)\n", $created, $saved / 1048576, $skipped);
