<?php

/**
 * Force-refresh WebP derivatives for nearby-places attraction images.
 * Card display is ~640px wide; 960w @ q72 keeps quality sharp and files light.
 */

$dir = dirname(__DIR__).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images';
$config = require dirname(__DIR__).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'nearby-places.php';
$max = 960;
$q = 72;

if (! function_exists('imagewebp')) {
    fwrite(STDERR, "GD WebP support is required.\n");
    exit(1);
}

$paths = [];
foreach ($config['attractions'] ?? [] as $place) {
    $relative = (string) ($place['image'] ?? '');
    if ($relative === '') {
        continue;
    }
    $basename = basename(str_replace('\\', '/', $relative));
    $jpg = $dir.DIRECTORY_SEPARATOR.preg_replace('/\.webp$/i', '.jpg', $basename);
    $jpg = preg_replace('/\.jpeg$/i', '.jpg', $jpg) ?: $jpg;

    // Prefer exact configured basename first.
    $configured = $dir.DIRECTORY_SEPARATOR.$basename;
    if (is_file($configured) && preg_match('/\.(jpe?g|png)$/i', $configured)) {
        $paths[$configured] = true;
        continue;
    }

    if (is_file($jpg)) {
        $paths[$jpg] = true;
    }
}

// Also catch any sacred-/explore- sources that may have been updated.
foreach (array_merge(
    glob($dir.DIRECTORY_SEPARATOR.'sacred-*.{jpg,jpeg,png}', GLOB_BRACE) ?: [],
    glob($dir.DIRECTORY_SEPARATOR.'explore-*.{jpg,jpeg,png}', GLOB_BRACE) ?: [],
) as $extra) {
    $paths[$extra] = true;
}

ksort($paths);

$created = 0;
$failed = 0;

foreach (array_keys($paths) as $path) {
    $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
    if (! is_string($target)) {
        continue;
    }

    $binary = @file_get_contents($path);
    if ($binary === false) {
        echo 'fail read '.basename($path)."\n";
        $failed++;
        continue;
    }

    $src = @imagecreatefromstring($binary);
    if ($src === false) {
        echo 'fail decode '.basename($path)."\n";
        $failed++;
        continue;
    }

    $w = imagesx($src);
    $h = imagesy($src);
    if ($w > $max) {
        $nw = $max;
        $nh = (int) max(1, round($h * ($max / $w)));
        $canvas = imagecreatetruecolor($nw, $nh);
        if ($canvas === false) {
            imagedestroy($src);
            echo 'fail resize '.basename($path)."\n";
            $failed++;
            continue;
        }
        imagecopyresampled($canvas, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($src);
        $src = $canvas;
    }

    $ok = @imagewebp($src, $target, $q);
    imagedestroy($src);

    if (! $ok || ! is_file($target)) {
        echo 'fail webp '.basename($path)."\n";
        $failed++;
        continue;
    }

    $created++;
    echo sprintf(
        "%-52s %4dKB -> %4dKB\n",
        basename($path),
        (int) round(filesize($path) / 1024),
        (int) round(filesize($target) / 1024)
    );
}

echo "\nCreated/refreshed: {$created} | Failed: {$failed}\n";
exit($failed > 0 ? 1 : 0);
