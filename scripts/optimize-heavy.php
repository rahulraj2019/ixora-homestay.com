<?php

$dir = dirname(__DIR__).'/public/assets/images';
$files = [
    'ixora-event-venue-photo-swing.jpg',
    'ixora-homestay-private-courtyard.jpg',
    'ixora-homestay-niduvaloor-exterior-sunset.jpg',
    'ixora-homestay-flower-decorated-swing.jpg',
    'ixora-homestay-lush-garden.jpg',
    'ixora-homestay-kids-playground.jpg',
    'ixora-homestay-garden-pathway.jpg',
    'explore-alakapuri-waterfalls-kannur.jpg',
];
$max = 1280;
$q = 70;

foreach ($files as $f) {
    $path = $dir.'/'.$f;
    $target = preg_replace('/\.jpe?g$/i', '.webp', $path);
    if (! is_file($path)) {
        continue;
    }
    $src = imagecreatefromstring(file_get_contents($path));
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
    echo $f.' '.(int) (filesize($path) / 1024).'KB -> '.(int) (filesize($target) / 1024)."KB\n";
}
