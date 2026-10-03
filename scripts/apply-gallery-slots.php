<?php

$root = dirname(__DIR__);
$configPath = $root.'/config/site-images.php';
$generatedPath = $root.'/scripts/gallery-slots.generated.php';

$config = file_get_contents($configPath);
$generated = file_get_contents($generatedPath);

if ($config === false || $generated === false) {
    fwrite(STDERR, "Cannot read files\n");
    exit(1);
}

if (! preg_match('/return \[\n(.*)\n\];\s*$/s', $generated, $m)) {
    fwrite(STDERR, "Cannot parse generated gallery slots\n");
    exit(1);
}

$galleryBody = rtrim($m[1]);
$replacement = "        // Gallery page\n".$galleryBody."\n";

$pattern = '/        \/\/ Gallery page\r?\n(?:        \'gallery\.\d+\' => .*\r?\n)+/';
$new = preg_replace($pattern, $replacement, $config, 1, $count);

if ($count !== 1) {
    fwrite(STDERR, "Replace count={$count}\n");
    exit(1);
}

file_put_contents($configPath, $new);
echo 'Gallery slots replaced OK'.PHP_EOL;
