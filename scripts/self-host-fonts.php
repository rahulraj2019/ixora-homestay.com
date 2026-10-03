<?php

/**
 * One-shot: download Google Fonts WOFF2 + write local @font-face CSS.
 * Run with: php scripts/self-host-fonts.php
 */

$cssUrl = 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Great+Vibes&family=Outfit:wght@400;500;600&display=swap';
$ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';
$fontDir = dirname(__DIR__).'/public/assets/fonts';
$outCss = dirname(__DIR__).'/public/assets/css/fonts.css';

if (! is_dir($fontDir)) {
    mkdir($fontDir, 0775, true);
}

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: {$ua}\r\nAccept: text/css,*/*;q=0.1\r\n",
        'timeout' => 30,
    ],
]);

$css = file_get_contents($cssUrl, false, $ctx);
if ($css === false) {
    fwrite(STDERR, "Failed to fetch Google Fonts CSS\n");
    exit(1);
}

if (! preg_match_all('/url\((https:\/\/fonts\.gstatic\.com\/[^)]+\.woff2)\)/', $css, $matches)) {
    fwrite(STDERR, "No woff2 URLs found\n");
    exit(1);
}

$urls = array_values(array_unique($matches[1]));
$map = [];

foreach ($urls as $i => $url) {
    $name = 'gf-'.($i + 1).'.woff2';
    $path = $fontDir.'/'.$name;
    $bin = file_get_contents($url, false, $ctx);
    if ($bin === false) {
        fwrite(STDERR, "Failed download: {$url}\n");
        exit(1);
    }
    file_put_contents($path, $bin);
    $map[$url] = '../fonts/'.$name;
    echo 'saved '.$name.' '.(int) (strlen($bin) / 1024)."KB\n";
}

$local = str_replace(array_keys($map), array_values($map), $css);
file_put_contents($outCss, $local);
echo "wrote fonts.css (".strlen($local)." bytes)\n";
