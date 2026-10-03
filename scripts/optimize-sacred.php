<?php

$dir = dirname(__DIR__).'/public/assets/images';
$files = array_merge(
    glob($dir.'/sacred-*.jpg') ?: [],
    [$dir.'/explore-parassinikadavu-muthappan-temple.jpg']
);
$max = 960;
$q = 72;

foreach ($files as $path) {
    if (! is_file($path)) {
        continue;
    }
    $target = preg_replace('/\.jpe?g$/i', '.webp', $path);
    $src = imagecreatefromstring(file_get_contents($path));
    if ($src === false) {
        echo "fail {$path}\n";
        continue;
    }
    $w = imagesx($src);
    $h = imagesy($src);
    if ($w > $max) {
        $nw = $max;
        $nh = (int) round($h * ($max / $w));
        $c = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($c, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($src);
        $src = $c;
    }
    imagewebp($src, $target, $q);
    imagedestroy($src);
    echo basename($path).' '.(int) (filesize($path) / 1024).'KB -> '.(int) (filesize($target) / 1024)."KB\n";
}
