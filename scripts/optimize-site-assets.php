<?php

/**
 * One-off site optimization: compress oversized JPGs to WebP, minify JS.
 * Usage: php84 scripts/optimize-site-assets.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\ImageOptimizer;

$optimizer = app(ImageOptimizer::class);
$dir = public_path('assets/images');

$results = $optimizer->optimizeDirectory($dir, 1600, 76);
$created = 0;
$saved = 0;
foreach ($results as $row) {
    if (! empty($row['ok']) && empty($row['skipped'])) {
        $created++;
        $saved += max(0, ($row['bytes_in'] ?? 0) - ($row['bytes_out'] ?? 0));
        echo 'webp '.$row['source'].' -> '.round(($row['bytes_out'] ?? 0) / 1024).'KB'.PHP_EOL;
    }
}
echo "webp_created={$created} bytes_saved={$saved}".PHP_EOL;

// Minify main.js -> main.min.js (strip comments + collapse whitespace safely enough for this file)
$jsPath = public_path('assets/js/main.js');
$minPath = public_path('assets/js/main.min.js');
$js = file_get_contents($jsPath);
if ($js === false) {
    fwrite(STDERR, "Cannot read main.js\n");
    exit(1);
}

// Remove block comments then line comments (avoid breaking URLs with //)
$js = preg_replace('#/\*.*?\*/#s', '', $js) ?? $js;
$js = preg_replace('#^\s*//.*$#m', '', $js) ?? $js;
$js = preg_replace("/\n{2,}/", "\n", $js) ?? $js;
$js = preg_replace('/[ \t]+/', ' ', $js) ?? $js;
$js = preg_replace('/\s*([{}();,:\[\]])\s*/', '$1', $js) ?? $js;
// Restore needed spaces after keywords
$js = preg_replace('/\b(return|var|let|const|new|typeof|delete|throw|else|in|of|case)\b(?=\S)/', '$1 ', $js) ?? $js;

file_put_contents($minPath, trim($js)."\n");
echo 'js_in='.filesize($jsPath).' js_out='.filesize($minPath).PHP_EOL;

// Minify style.css roughly into style.min.css if newer
$cssPath = public_path('assets/css/style.css');
$cssMinPath = public_path('assets/css/style.min.css');
$css = file_get_contents($cssPath);
if ($css !== false) {
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
    // Do not strip spaces around "+" — required inside calc() for + operators.
    $css = preg_replace('/\s*([{};:,>~])\s*/', '$1', $css) ?? $css;
    $css = str_replace(';}', '}', $css);
    $css = strtr($css, $placeholders);
    file_put_contents($cssMinPath, trim($css));
    echo 'css_in='.filesize($cssPath).' css_out='.filesize($cssMinPath).PHP_EOL;
}

echo "Done\n";
