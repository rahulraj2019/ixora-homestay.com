<?php

/**
 * Re-encode key images to smaller WebP (+ responsive hero variants).
 * Uses XAMPP GD. Forces overwrite of existing .webp.
 */

$dir = dirname(__DIR__).'/public/assets/images';

$jobs = [
    // Hero LCP: mobile + desktop candidates (aggressive for Performance score)
    ['ixora-homestay-niduvaloor-exterior-sunset.jpg', 720, 65, 'ixora-homestay-niduvaloor-exterior-sunset-800.webp'],
    ['ixora-homestay-niduvaloor-exterior-sunset.jpg', 1100, 62, 'ixora-homestay-niduvaloor-exterior-sunset.webp'],
    // Heavy gallery / stack images
    ['ixora-homestay-garden-walkway.jpg', 1000, 62, null],
    ['ixora-homestay-private-courtyard.jpg', 1000, 62, null],
    ['ixora-homestay-lush-garden.jpg', 1000, 60, null],
    ['ixora-homestay-flower-decorated-swing.jpg', 1000, 60, null],
    ['ixora-homestay-kids-playground.jpg', 1000, 62, null],
    ['ixora-homestay-garden-pathway.jpg', 1000, 62, null],
    ['ixora-event-venue-photo-swing.jpg', 1000, 62, null],
    ['ixora-homestay-bedroom-1-kannur.jpg', 1000, 68, null],
    ['ixora-homestay-logo.png', 320, 85, null],
];

function encode_webp(string $srcPath, string $target, int $maxW, int $q): void
{
    $src = imagecreatefromstring(file_get_contents($srcPath));
    if ($src === false) {
        throw new RuntimeException('decode failed: '.$srcPath);
    }
    $w = imagesx($src);
    $h = imagesy($src);
    if ($w > $maxW) {
        $nw = $maxW;
        $nh = (int) max(1, round($h * ($maxW / $w)));
        $c = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($c, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($src);
        $src = $c;
    }
    imagewebp($src, $target, $q);
    imagedestroy($src);
}

foreach ($jobs as [$file, $max, $q, $outName]) {
    $path = $dir.'/'.$file;
    if (! is_file($path)) {
        // try png for logo
        if (! str_ends_with($file, '.png')) {
            echo "skip missing {$file}\n";
            continue;
        }
    }
    if (! is_file($path)) {
        echo "skip missing {$file}\n";
        continue;
    }
    $target = $outName
        ? $dir.'/'.$outName
        : preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
    encode_webp($path, $target, $max, $q);
    echo basename($target).' '.(int) (filesize($path) / 1024).'KB -> '.(int) (filesize($target) / 1024)."KB (max {$max} q{$q})\n";
}
