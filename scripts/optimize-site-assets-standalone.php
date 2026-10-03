<?php

/**
 * Standalone asset optimizer (no Laravel bootstrap).
 * php scripts/optimize-site-assets-standalone.php
 */

$root = dirname(__DIR__);
$imagesDir = $root.'/public/assets/images';
$jsPath = $root.'/public/assets/js/main.js';
$minJsPath = $root.'/public/assets/js/main.min.js';
$cssPath = $root.'/public/assets/css/style.css';
$minCssPath = $root.'/public/assets/css/style.min.css';

function optimize_to_webp(string $absolutePath, int $maxWidth = 1600, int $quality = 76): array
{
    if (! is_file($absolutePath) || ! function_exists('imagewebp')) {
        return ['ok' => false, 'error' => 'missing'];
    }

    $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
    if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        return ['ok' => false, 'skipped' => 'type'];
    }

    $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $absolutePath);
    if (! is_string($target)) {
        return ['ok' => false, 'error' => 'path'];
    }

    $bytesIn = (int) filesize($absolutePath);
    if (is_file($target) && filemtime($target) >= filemtime($absolutePath) && filesize($target) < $bytesIn) {
        return ['ok' => true, 'skipped' => 'up to date', 'bytes_in' => $bytesIn, 'bytes_out' => (int) filesize($target)];
    }

    $binary = @file_get_contents($absolutePath);
    if ($binary === false) {
        return ['ok' => false, 'error' => 'read'];
    }
    $source = @imagecreatefromstring($binary);
    if ($source === false) {
        return ['ok' => false, 'error' => 'decode'];
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

    $ok = @imagewebp($source, $target, $quality);
    imagedestroy($source);
    if (! $ok || ! is_file($target)) {
        return ['ok' => false, 'error' => 'encode'];
    }

    $bytesOut = (int) filesize($target);
    if ($bytesOut >= $bytesIn) {
        @unlink($target);

        return ['ok' => false, 'skipped' => 'not smaller', 'bytes_in' => $bytesIn];
    }

    return ['ok' => true, 'bytes_in' => $bytesIn, 'bytes_out' => $bytesOut, 'path' => $target];
}

function make_width_variant(string $absolutePath, int $targetWidth = 800, int $quality = 76): array
{
    if (! is_file($absolutePath) || ! function_exists('imagewebp')) {
        return ['ok' => false];
    }
    $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
    if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
        return ['ok' => false];
    }

    $dir = dirname($absolutePath);
    $base = pathinfo($absolutePath, PATHINFO_FILENAME);
    // Prefer generating from original jpg/png named without -800
    if (str_ends_with($base, '-800')) {
        return ['ok' => false, 'skipped' => 'already variant'];
    }

    $out = $dir.DIRECTORY_SEPARATOR.$base.'-800.webp';
    if (is_file($out) && filemtime($out) >= filemtime($absolutePath)) {
        return ['ok' => true, 'skipped' => 'up to date', 'path' => $out];
    }

    $binary = @file_get_contents($absolutePath);
    if ($binary === false) {
        return ['ok' => false];
    }
    $source = @imagecreatefromstring($binary);
    if ($source === false) {
        return ['ok' => false];
    }

    $width = imagesx($source);
    $height = imagesy($source);
    if ($width <= $targetWidth) {
        imagedestroy($source);

        return ['ok' => false, 'skipped' => 'already small'];
    }

    $newHeight = (int) max(1, round($height * ($targetWidth / $width)));
    $canvas = imagecreatetruecolor($targetWidth, $newHeight);
    imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetWidth, $newHeight, $width, $height);
    imagedestroy($source);
    $ok = @imagewebp($canvas, $out, $quality);
    imagedestroy($canvas);

    return $ok && is_file($out)
        ? ['ok' => true, 'path' => $out, 'bytes_out' => filesize($out)]
        : ['ok' => false];
}

$created = 0;
$saved = 0;
$variants = 0;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imagesDir, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if (! $file->isFile()) {
        continue;
    }
    $ext = strtolower($file->getExtension());
    if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        continue;
    }
    $path = $file->getPathname();
    if (str_contains($path, DIRECTORY_SEPARATOR.'_thumbs'.DIRECTORY_SEPARATOR)) {
        continue;
    }

    $result = optimize_to_webp($path, 1600, 76);
    if (! empty($result['ok']) && empty($result['skipped'])) {
        $created++;
        $saved += max(0, ($result['bytes_in'] ?? 0) - ($result['bytes_out'] ?? 0));
        echo 'webp '.basename($path).' '.round(($result['bytes_out'] ?? 0) / 1024)."KB\n";
    }

    // 800w responsive variant from source
    $v = make_width_variant($path, 800, 74);
    if (! empty($v['ok']) && empty($v['skipped'])) {
        $variants++;
        echo '800w '.basename((string) $v['path'])."\n";
    }
}

echo "webp_created={$created} variants_800={$variants} bytes_saved={$saved}\n";

// Minify JS
$js = file_get_contents($jsPath);
$js = preg_replace('#/\*.*?\*/#s', '', $js) ?? $js;
$js = preg_replace('#^\s*//.*$#m', '', $js) ?? $js;
$js = preg_replace("/\n{2,}/", "\n", $js) ?? $js;
$js = preg_replace('/[ \t]+/', ' ', $js) ?? $js;
$js = preg_replace('/\s*([{}();,:\[\]])\s*/', '$1', $js) ?? $js;
$js = preg_replace('/\b(return|var|let|const|new|typeof|delete|throw|else|in|of|case|function)\b(?=\S)/', '$1 ', $js) ?? $js;
file_put_contents($minJsPath, trim($js)."\n");
echo 'js '.filesize($jsPath).' -> '.filesize($minJsPath)."\n";

// Minify CSS (keep spaces around + / - inside calc()/min()/max()/clamp() —
// CSS requires whitespace around those operators or values resolve incorrectly)
$css = file_get_contents($cssPath);
$css = preg_replace('#/\*.*?\*/#s', '', $css) ?? $css;
$placeholders = [];
$css = preg_replace_callback(
    '/(?:calc|min|max|clamp)\((?:[^()]+|\([^()]*\))*\)/i',
    function (array $matches) use (&$placeholders): string {
        $key = '___CALC'.count($placeholders).'___';
        $placeholders[$key] = $matches[0];

        return $key;
    },
    $css
) ?? $css;
$css = preg_replace('/\s+/', ' ', $css) ?? $css;
$css = preg_replace('/\s*([{};:,>~])\s*/', '$1', $css) ?? $css;
$css = str_replace(';}', '}', $css);
$css = strtr($css, $placeholders);
file_put_contents($minCssPath, trim($css));
echo 'css '.filesize($cssPath).' -> '.filesize($minCssPath)."\n";
echo "Done\n";
