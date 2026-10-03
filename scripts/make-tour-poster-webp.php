<?php

$jpg = dirname(__DIR__).'/public/assets/images/ixora-homestay-tour-poster.jpg';
$webp = dirname(__DIR__).'/public/assets/images/ixora-homestay-tour-poster.webp';
$im = imagecreatefromjpeg($jpg);
if ($im === false) {
    fwrite(STDERR, "decode failed\n");
    exit(1);
}
imagewebp($im, $webp, 78);
imagedestroy($im);
echo 'webp='.filesize($webp)."\n";
