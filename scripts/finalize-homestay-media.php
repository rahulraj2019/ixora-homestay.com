<?php

/**
 * Rename placeholder imports to SEO filenames and emit gallery slot PHP.
 * Usage: C:\xampp\php\php.exe scripts/finalize-homestay-media.php
 */

$root = dirname(__DIR__);
$imgDir = $root.'/public/assets/images';

$renames = [
    'ixora-homestay-interior-view-2910' => ['ixora-homestay-bedroom-carrom-board', 'Bedroom with carrom', 'bedrooms', 'Spacious bedroom with carrom board at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-interior-view-2912' => ['ixora-homestay-bedroom-serene-art', 'Bedroom serene art', 'bedrooms', 'Guest bedroom with Buddha wall art at IXORA Homestay Kannur'],
    'ixora-homestay-interior-view-2916' => ['ixora-homestay-bedroom-warm-lamp', 'Bedroom warm lamp', 'bedrooms', 'Cozy bedroom with warm lamp and wood ceiling at IXORA Homestay Niduvaloor'],
    'ixora-homestay-interior-view-2924' => ['ixora-homestay-living-tv-lounge', 'TV lounge', 'living', 'Modern TV lounge with designer chairs at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-interior-view-2926' => ['ixora-homestay-washbasin-led-mirror', 'Washbasin mirror', 'living', 'Modern washbasin with illuminated LED mirror at IXORA Homestay Kannur'],
    'ixora-homestay-interior-view-2929' => ['ixora-homestay-bathroom-geometric-tiles', 'Modern bathroom', 'living', 'Modern bathroom with geometric tiles at IXORA Homestay Niduvaloor'],
    'ixora-homestay-interior-view-2930' => ['ixora-homestay-common-lobby-seating', 'Lobby seating', 'living', 'Common lobby seating with wood ceiling at IXORA Homestay Kannur'],
    'ixora-homestay-interior-view-2934' => ['ixora-homestay-bedroom-green-wardrobe', 'Green wardrobe room', 'bedrooms', 'Air-conditioned bedroom with green wardrobe at IXORA Homestay Niduvaloor'],
    'ixora-homestay-interior-view-2938' => ['ixora-homestay-kitchenette-fridge', 'Guest kitchenette', 'living', 'Guest kitchenette with fridge and gas stove at IXORA Homestay Kannur'],
    'ixora-homestay-outdoor-view-2941' => ['ixora-homestay-dining-marble-table', 'Dining table', 'living', 'Marble dining table seating six at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-outdoor-view-2947' => ['ixora-homestay-covered-veranda-utility', 'Covered veranda', 'courtyard', 'Covered veranda utility area at IXORA Homestay Niduvaloor Kerala'],
    'ixora-homestay-outdoor-view-2952' => ['ixora-homestay-cottage-forest-daylight', 'Cottage in forest', 'homestay', 'IXORA Homestay cottage with red-tiled roof amid forest Niduvaloor Kannur'],
    'ixora-homestay-outdoor-view-2954' => ['ixora-homestay-grounds-view-a', 'Property grounds', 'courtyard', 'Outdoor grounds and greenery at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-outdoor-view-2955' => ['ixora-homestay-grounds-view-b', 'Garden grounds', 'courtyard', 'Garden grounds surrounded by trees at IXORA Homestay Kannur'],
    'ixora-homestay-outdoor-view-2956' => ['ixora-homestay-grounds-view-c', 'Courtyard greenery', 'courtyard', 'Courtyard greenery at IXORA Homestay Niduvaloor Gate'],
    'ixora-homestay-outdoor-view-2959' => ['ixora-homestay-grounds-view-d', 'Outdoor seating', 'courtyard', 'Outdoor seating area at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-outdoor-view-2960' => ['ixora-homestay-grounds-view-e', 'Garden path', 'courtyard', 'Garden path through the property at IXORA Homestay Kannur'],
    'ixora-homestay-outdoor-view-2964' => ['ixora-homestay-grounds-view-f', 'Lush grounds', 'courtyard', 'Lush property grounds at IXORA Homestay Niduvaloor'],
    'ixora-homestay-outdoor-view-2965' => ['ixora-homestay-grounds-view-g', 'Outdoor amenity', 'courtyard', 'Outdoor amenity space at IXORA Homestay Kannur Kerala'],
    'ixora-homestay-outdoor-view-2966' => ['ixora-homestay-grounds-view-h', 'Homestay outdoors', 'homestay', 'Outdoor view of IXORA Homestay Niduvaloor Gate Kannur'],
    'ixora-homestay-room-view-2968' => ['ixora-homestay-bedroom-detail-a', 'Bedroom detail', 'bedrooms', 'Guest bedroom detail at IXORA Homestay Niduvaloor Kannur'],
    'ixora-homestay-room-view-2973' => ['ixora-homestay-bedroom-detail-b', 'Bedroom detail', 'bedrooms', 'Bedroom interior at IXORA Homestay Kannur Kerala'],
    'ixora-homestay-room-view-2974' => ['ixora-homestay-bedroom-detail-c', 'Bedroom detail', 'bedrooms', 'Homestay bedroom at IXORA Niduvaloor Gate Kannur'],
];

$metaBySlug = [];

foreach ($renames as $old => [$new, $caption, $category, $alt]) {
    foreach (['jpg', 'webp'] as $ext) {
        $from = $imgDir.'/'.$old.'.'.$ext;
        $to = $imgDir.'/'.$new.'.'.$ext;
        if (is_file($from)) {
            if (is_file($to) && realpath($from) !== realpath($to)) {
                unlink($to);
            }
            rename($from, $to);
            echo "rename {$old}.{$ext} → {$new}.{$ext}\n";
        }
    }
    $metaBySlug[$new] = compact('caption', 'category', 'alt');
}

// Collect all ixora-homestay-*.jpg that are from this import (exclude explore-*)
$galleryOrder = [
    'ixora-homestay-niduvaloor-exterior-sunset',
    'ixora-homestay-courtyard-sunset-sign',
    'ixora-homestay-entrance-golden-hour',
    'ixora-homestay-forest-edge-dusk',
    'ixora-homestay-front-stairs-evening',
    'ixora-homestay-evening-lights-cottage',
    'ixora-homestay-twilight-front-view',
    'ixora-homestay-reception-entrance-night',
    'ixora-homestay-night-sign-crescent',
    'ixora-homestay-welcome-sign-garden',
    'ixora-homestay-brick-garden-feature',
    'ixora-homestay-marigold-garden-swing',
    'ixora-homestay-giraffe-bench-night',
    'ixora-homestay-bedroom-double-green',
    'ixora-homestay-bedroom-wardrobe-view',
    'ixora-homestay-bedroom-to-dining',
    'ixora-homestay-bedroom-wood-ceiling',
    'ixora-homestay-bedroom-art-wall',
    'ixora-homestay-bedroom-buddha-art',
    'ixora-homestay-bedroom-carrom-board',
    'ixora-homestay-bedroom-serene-art',
    'ixora-homestay-bedroom-warm-lamp',
    'ixora-homestay-living-room-lounge',
    'ixora-homestay-living-tv-lounge',
    'ixora-homestay-washbasin-led-mirror',
    'ixora-homestay-bathroom-geometric-tiles',
    'ixora-homestay-common-lobby-seating',
    'ixora-homestay-bedroom-green-wardrobe',
    'ixora-homestay-kitchenette-fridge',
    'ixora-homestay-dining-marble-table',
    'ixora-homestay-outdoor-screen-courtyard',
    'ixora-homestay-covered-veranda-utility',
    'ixora-homestay-cottage-forest-daylight',
    'ixora-homestay-garden-walkway-forest',
    'ixora-homestay-grounds-view-a',
    'ixora-homestay-grounds-view-b',
    'ixora-homestay-grounds-view-c',
    'ixora-homestay-grounds-view-d',
    'ixora-homestay-grounds-view-e',
    'ixora-homestay-grounds-view-f',
    'ixora-homestay-grounds-view-g',
    'ixora-homestay-grounds-view-h',
    'ixora-homestay-bedroom-detail-a',
    'ixora-homestay-cozy-single-bedroom',
    'ixora-homestay-bedroom-detail-b',
    'ixora-homestay-bedroom-detail-c',
];

$defaults = [
    'ixora-homestay-niduvaloor-exterior-sunset' => ['Homestay at dusk', 'homestay', 'IXORA Homestay Niduvaloor exterior at sunset with play area Kannur'],
    'ixora-homestay-courtyard-sunset-sign' => ['Courtyard sunset', 'homestay', 'IXORA Homestay courtyard at golden hour with welcome sign Niduvaloor'],
    'ixora-homestay-entrance-golden-hour' => ['Golden hour entrance', 'homestay', 'IXORA Homestay entrance and playground at golden hour Kannur'],
    'ixora-homestay-forest-edge-dusk' => ['Forest edge dusk', 'homestay', 'IXORA Homestay cottage at forest edge with evening lights Kerala'],
    'ixora-homestay-front-stairs-evening' => ['Front stairs evening', 'homestay', 'IXORA Homestay front stairs and balcony at dusk Niduvaloor Kannur'],
    'ixora-homestay-evening-lights-cottage' => ['Evening cottage lights', 'homestay', 'IXORA 2 BHK cottage warmly lit at blue hour Niduvaloor Gate'],
    'ixora-homestay-twilight-front-view' => ['Twilight front view', 'homestay', 'Twilight front view of IXORA Homestay surrounded by trees'],
    'ixora-homestay-reception-entrance-night' => ['Reception at night', 'homestay', 'IXORA Homestay reception entrance lit at night Niduvaloor'],
    'ixora-homestay-night-sign-crescent' => ['Night with moon', 'homestay', 'IXORA Homestay night exterior with welcome sign and crescent moon'],
    'ixora-homestay-welcome-sign-garden' => ['Welcome sign garden', 'homestay', 'IXORA Home Stay Niduvaloor welcome sign beside garden at night'],
    'ixora-homestay-brick-garden-feature' => ['Garden feature', 'courtyard', 'Decorative brick garden feature at IXORA Homestay Niduvaloor'],
    'ixora-homestay-marigold-garden-swing' => ['Garden swing night', 'photo', 'Marigold-decorated garden swing at IXORA Homestay Kannur'],
    'ixora-homestay-giraffe-bench-night' => ['Giraffe photo bench', 'photo', 'Yellow giraffe garden bench under flower arch at IXORA Homestay'],
    'ixora-homestay-bedroom-double-green' => ['Bedroom double', 'bedrooms', 'Bright double bedroom with green accents at IXORA Homestay Kannur'],
    'ixora-homestay-bedroom-wardrobe-view' => ['Bedroom wardrobe', 'bedrooms', 'Spacious bedroom with olive wardrobe at IXORA 2 BHK Homestay'],
    'ixora-homestay-bedroom-to-dining' => ['Bedroom to dining', 'bedrooms', 'Air-conditioned bedroom opening to dining at IXORA Homestay'],
    'ixora-homestay-bedroom-wood-ceiling' => ['Wood ceiling bedroom', 'bedrooms', 'Modern bedroom with wood ceiling at IXORA Homestay Kannur'],
    'ixora-homestay-bedroom-art-wall' => ['Bedroom art wall', 'bedrooms', 'Guest bedroom with colourful wall art at IXORA Homestay'],
    'ixora-homestay-bedroom-buddha-art' => ['Bedroom decor', 'bedrooms', 'Clean guest bedroom with artistic decor at IXORA Homestay Kannur'],
    'ixora-homestay-living-room-lounge' => ['Living lounge', 'living', 'Modern living lounge with blue sofas at IXORA Homestay Niduvaloor'],
    'ixora-homestay-outdoor-screen-courtyard' => ['Outdoor screen', 'events', 'Outdoor courtyard with screen stage at IXORA Homestay Kannur'],
    'ixora-homestay-garden-walkway-forest' => ['Garden walkway', 'courtyard', 'Stone garden walkway beside forest at IXORA Homestay Niduvaloor'],
    'ixora-homestay-cozy-single-bedroom' => ['Cozy bedroom', 'bedrooms', 'Cozy single bedroom at IXORA Homestay Niduvaloor Kannur'],
];

$lines = [];
$n = 1;
foreach ($galleryOrder as $slug) {
    $jpg = $imgDir.'/'.$slug.'.jpg';
    if (! is_file($jpg)) {
        echo "MISSING {$slug}.jpg\n";
        continue;
    }
    $size = @getimagesize($jpg);
    $w = is_array($size) ? (int) $size[0] : 1600;
    $h = is_array($size) ? (int) $size[1] : 1067;

    if (isset($metaBySlug[$slug])) {
        $caption = $metaBySlug[$slug]['caption'];
        $category = $metaBySlug[$slug]['category'];
        $alt = $metaBySlug[$slug]['alt'];
    } elseif (isset($defaults[$slug])) {
        [$caption, $category, $alt] = $defaults[$slug];
    } else {
        $caption = 'Homestay view';
        $category = 'homestay';
        $alt = 'IXORA Homestay Niduvaloor Kannur — '.str_replace('-', ' ', $slug);
    }

    $key = sprintf('gallery.%02d', $n);
    $lines[] = sprintf(
        "        '%s' => ['label' => 'Gallery %02d', 'group' => 'gallery', 'fallback' => 'assets/images/%s.jpg', 'alt' => %s, 'caption' => %s, 'category' => %s, 'width' => %d, 'height' => %d],",
        $key,
        $n,
        $slug,
        var_export($alt, true),
        var_export($caption, true),
        var_export($category, true),
        $w,
        $h
    );
    $n++;
}

$out = $root.'/scripts/gallery-slots.generated.php';
file_put_contents($out, "<?php\n\nreturn [\n".implode("\n", $lines)."\n];\n");
echo "Wrote {$out} with ".($n - 1)." gallery slots\n";
