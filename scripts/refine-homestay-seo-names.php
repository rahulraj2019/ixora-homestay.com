<?php

/**
 * Apply refined SEO names from photo classification.
 * Usage: C:\xampp\php\php.exe scripts/refine-homestay-seo-names.php
 */

$root = dirname(__DIR__);
$imgDir = $root.'/public/assets/images';
$configPath = $root.'/config/site-images.php';

/** @var array<string, array{0:string,1:string,2:string,3:string}> oldSlug => [newSlug, caption, category, alt] */
$map = [
    'ixora-homestay-bedroom-carrom-board' => ['ixora-homestay-bedroom-carrom-night', 'Bedroom with carrom', 'bedrooms', 'Spacious bedroom at IXORA Homestay with marble floors, wooden ceiling and carrom board Niduvaloor'],
    'ixora-homestay-bedroom-serene-art' => ['ixora-homestay-bedroom-buddha-mirror', 'Buddha art bedroom', 'bedrooms', 'Modern guest bedroom at IXORA Homestay with dressing mirror and colourful Buddha wall art Kannur'],
    'ixora-homestay-bedroom-warm-lamp' => ['ixora-homestay-bedroom-buddha-painting', 'Cozy Buddha bedroom', 'bedrooms', 'Cozy IXORA Homestay bedroom with beige bedding and large Buddha painting Niduvaloor'],
    'ixora-homestay-living-tv-lounge' => ['ixora-homestay-living-room-tv', 'TV lounge seating', 'living', 'Indoor living area at IXORA Homestay with patterned chairs and wall-mounted TV Kannur'],
    'ixora-homestay-washbasin-led-mirror' => ['ixora-homestay-courtyard-washbasin', 'Courtyard washbasin', 'courtyard', 'Outdoor washbasin with backlit oval mirror at IXORA Homestay Niduvaloor'],
    'ixora-homestay-bathroom-geometric-tiles' => ['ixora-homestay-modern-bathroom', 'Modern tiled bathroom', 'living', 'Clean modern bathroom with geometric tiles at IXORA Homestay Kannur'],
    'ixora-homestay-common-lobby-seating' => ['ixora-homestay-lounge-wooden-ceiling', 'Wood ceiling lounge', 'living', 'Guest lounge with white chairs and wooden ceiling at IXORA Homestay Niduvaloor'],
    'ixora-homestay-kitchenette-fridge' => ['ixora-homestay-guest-kitchen', 'Green cabinet kitchen', 'living', 'Guest kitchen with mint cabinets, stove and fridge at IXORA Homestay Kannur'],
    'ixora-homestay-dining-marble-table' => ['ixora-homestay-dining-room-marble', 'Marble dining table', 'living', 'Indoor dining area with marble-top table and wooden chairs at IXORA Homestay Niduvaloor'],
    'ixora-homestay-covered-veranda-utility' => ['ixora-homestay-veranda-mural', 'Veranda village mural', 'courtyard', 'Sheltered outdoor veranda with traditional mural at IXORA Homestay Kannur'],
    'ixora-homestay-cottage-forest-daylight' => ['ixora-homestay-exterior-aerial', 'Aerial homestay exterior', 'homestay', 'High-angle exterior of IXORA Homestay with red tiled roof amid lush trees Niduvaloor'],
    'ixora-homestay-grounds-view-a' => ['ixora-homestay-courtyard-flower-swing', 'Flower garland swing', 'courtyard', 'Yellow garden swing with marigold garlands in the courtyard at IXORA Homestay Kannur'],
    'ixora-homestay-grounds-view-b' => ['ixora-homestay-playground-seesaw', 'Swing and seesaw', 'courtyard', 'Outdoor play area with yellow swing and seesaw at IXORA Homestay Niduvaloor'],
    'ixora-homestay-grounds-view-c' => ['ixora-homestay-garden-swing-area', 'Garden swing courtyard', 'courtyard', 'Courtyard garden swing with floral garlands at IXORA Homestay Kannur'],
    'ixora-homestay-grounds-view-d' => ['ixora-homestay-terrace-garden-view', 'Terrace garden view', 'courtyard', 'Lush plantation view from the terrace at IXORA Homestay Niduvaloor'],
    'ixora-homestay-grounds-view-e' => ['ixora-homestay-garden-walkway-bench', 'Garden stone walkway', 'courtyard', 'Stone-paved garden walkway with yellow bench at IXORA Homestay Kannur'],
    'ixora-homestay-grounds-view-f' => ['ixora-homestay-plantation-driveway', 'Plantation entrance path', 'homestay', 'Red dirt driveway through rubber plantation leading to IXORA Homestay Niduvaloor'],
    'ixora-homestay-grounds-view-g' => ['ixora-homestay-rubber-plantation-path', 'Rubber grove approach', 'homestay', 'Sunny rubber-tree approach path toward IXORA Homestay Kannur'],
    'ixora-homestay-grounds-view-h' => ['ixora-homestay-main-entrance-gate', 'Main entrance gate', 'homestay', 'Open front gate and green archway at IXORA Homestay Niduvaloor Forest setting'],
    'ixora-homestay-bedroom-detail-a' => ['ixora-homestay-bedroom-carrom-daylight', 'Sunlit carrom bedroom', 'bedrooms', 'Sunlit bedroom with carrom board and green glass door at IXORA Homestay Kannur'],
    'ixora-homestay-bedroom-detail-b' => ['ixora-homestay-interior-hallway', 'Marble interior hallway', 'homestay', 'Bright polished marble hallway at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-bedroom-detail-c' => ['ixora-homestay-indoor-carrom-room', 'Indoor carrom room', 'living', 'Indoor recreation room with carrom board at IXORA Homestay Kannur'],
];

$config = file_get_contents($configPath);
if ($config === false) {
    fwrite(STDERR, "Cannot read config\n");
    exit(1);
}

foreach ($map as $old => [$new, $caption, $category, $alt]) {
    foreach (['jpg', 'webp'] as $ext) {
        $from = $imgDir.'/'.$old.'.'.$ext;
        $to = $imgDir.'/'.$new.'.'.$ext;
        if (! is_file($from)) {
            if (is_file($to)) {
                echo "already {$new}.{$ext}\n";
            } else {
                echo "MISSING {$old}.{$ext}\n";
            }
            continue;
        }
        if (is_file($to) && realpath($from) !== realpath($to)) {
            // Prefer classified name; keep old target if different asset already owned that slug.
            echo "TARGET EXISTS skip overwrite {$new}.{$ext} (keeping {$old})\n";
            continue;
        }
        rename($from, $to);
        echo "rename {$old}.{$ext} → {$new}.{$ext}\n";
    }

    // Replace fallback path references
    $config = str_replace(
        "assets/images/{$old}.jpg",
        "assets/images/{$new}.jpg",
        $config
    );

    // Update gallery row meta when the path was updated (best-effort alt/caption/category)
    $config = preg_replace_callback(
        "/('gallery\\.\\d+' => \\[.*?'fallback' => 'assets\\/images\\/".preg_quote($new, '/')."\\.jpg', )'alt' => '.*?', 'caption' => '.*?', 'category' => '.*?',/",
        function (array $m) use ($alt, $caption, $category) {
            return $m[1]
                ."'alt' => ".var_export($alt, true)
                .", 'caption' => ".var_export($caption, true)
                .", 'category' => ".var_export($category, true)
                .',';
        },
        $config
    );
}

// Also refresh stay.kitchen / home.gallery_7 / home.reel_5 / events if they still point at old names — already handled by str_replace.

file_put_contents($configPath, $config);
echo "Updated site-images.php\n";

// Verify no leftover placeholder refs
foreach (array_keys($map) as $old) {
    if (str_contains($config, "assets/images/{$old}.jpg")) {
        echo "STILL REFERENCED {$old}\n";
    }
}
