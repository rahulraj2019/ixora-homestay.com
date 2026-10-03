<?php

$srcWebp = dirname(__DIR__).'/public/assets/images/ixora-homestay-logo.webp';
$srcJpg = dirname(__DIR__).'/public/assets/images/ixora-homestay-logo.jpg';
$dst = dirname(__DIR__).'/public/assets/images/ixora-homestay-logo-mail.png';

$im = null;
if (is_file($srcWebp) && function_exists('imagecreatefromwebp')) {
    $im = @imagecreatefromwebp($srcWebp);
}
if (! $im && is_file($srcJpg)) {
    $im = @imagecreatefromjpeg($srcJpg);
}
if (! $im) {
    fwrite(STDERR, "Could not load logo\n");
    exit(1);
}

$w = imagesx($im);
$h = imagesy($im);
$max = 240;
if ($w > $max) {
    $nw = $max;
    $nh = (int) max(1, round($h * ($max / $w)));
    $resized = imagecreatetruecolor($nw, $nh);
    imagealphablending($resized, false);
    imagesavealpha($resized, true);
    $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
    imagefilledrectangle($resized, 0, 0, $nw, $nh, $transparent);
    imagealphablending($resized, true);
    imagecopyresampled($resized, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
    imagedestroy($im);
    $im = $resized;
    imagealphablending($im, false);
    imagesavealpha($im, true);
}

imagepng($im, $dst, 6);
imagedestroy($im);
echo basename($dst).' '.(int) (filesize($dst) / 1024)."KB\n";
