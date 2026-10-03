<?php

/**
 * Import + optimize photos/video from "Images and Viedio of homestay"
 * into public/assets/images (+ videos) with SEO filenames, JPG + WebP.
 *
 * Usage: C:\xampp\php\php.exe scripts/import-homestay-media.php
 */

$root = dirname(__DIR__);
$sourceDir = $root.DIRECTORY_SEPARATOR.'Images and Viedio of homestay';
$outImages = $root.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images';
$outVideos = $root.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'videos';
$maxWidth = 1600;
$jpgQuality = 82;
$webpQuality = 78;

if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp') || ! function_exists('imagejpeg')) {
    fwrite(STDERR, "GD with JPEG + WebP required.\n");
    exit(1);
}

if (! is_dir($sourceDir)) {
    fwrite(STDERR, "Source folder missing: {$sourceDir}\n");
    exit(1);
}

if (! is_dir($outImages)) {
    mkdir($outImages, 0755, true);
}
if (! is_dir($outVideos)) {
    mkdir($outVideos, 0755, true);
}

/**
 * source basename => [slug, caption, category, alt]
 * slug is without extension; category matches gallery filters.
 *
 * @var array<string, array{0:string,1:string,2:string,3:string}>
 */
$map = [
    'PUZ_2822.jpg' => ['ixora-homestay-niduvaloor-exterior-sunset', 'Homestay at dusk', 'homestay', 'IXORA Homestay Niduvaloor exterior at sunset with play area and red-tiled roof Kannur'],
    'PUZ_2823.jpg' => ['ixora-homestay-courtyard-sunset-sign', 'Courtyard sunset', 'homestay', 'IXORA Homestay courtyard at golden hour with welcome sign Niduvaloor Kannur'],
    'PUZ_2825.jpg' => ['ixora-homestay-entrance-golden-hour', 'Golden hour entrance', 'homestay', 'IXORA Homestay entrance and playground at golden hour Niduvaloor Gate Kannur'],
    'PUZ_2830.jpg' => ['ixora-homestay-forest-edge-dusk', 'Forest edge dusk', 'homestay', 'IXORA Homestay cottage at forest edge with evening lights Niduvaloor Kerala'],
    'PUZ_2835.jpg' => ['ixora-homestay-front-stairs-evening', 'Front stairs evening', 'homestay', 'IXORA Homestay front stairs and marigold balcony at dusk Niduvaloor Kannur'],
    'PUZ_2842.jpg' => ['ixora-homestay-evening-lights-cottage', 'Evening cottage lights', 'homestay', 'IXORA 2 BHK cottage warmly lit at blue hour Niduvaloor Gate Kannur'],
    'PUZ_2843.jpg' => ['ixora-homestay-twilight-front-view', 'Twilight front view', 'homestay', 'Twilight front view of IXORA Homestay surrounded by trees Niduvaloor'],
    'PUZ_2867.jpg' => ['ixora-homestay-reception-entrance-night', 'Reception at night', 'homestay', 'IXORA Homestay reception entrance lit at night with play area Niduvaloor'],
    'PUZ_2868.jpg' => ['ixora-homestay-night-sign-crescent', 'Night with moon', 'homestay', 'IXORA Homestay Niduvaloor night exterior with welcome sign and crescent moon'],
    'PUZ_2873.jpg' => ['ixora-homestay-welcome-sign-garden', 'Welcome sign garden', 'homestay', 'IXORA Home Stay Niduvaloor welcome sign beside brick planter garden at night'],
    'PUZ_2875.jpg' => ['ixora-homestay-brick-garden-feature', 'Garden feature', 'courtyard', 'Decorative brick and terracotta garden feature at IXORA Homestay Niduvaloor'],
    'PUZ_2879.jpg' => ['ixora-homestay-marigold-garden-swing', 'Garden swing night', 'photo', 'Marigold-decorated garden swing under night lights at IXORA Homestay Kannur'],
    'PUZ_2888.jpg' => ['ixora-homestay-giraffe-bench-night', 'Giraffe photo bench', 'photo', 'Yellow giraffe garden bench under flower arch at IXORA Homestay Niduvaloor'],
    'PUZ_2895.jpg' => ['ixora-homestay-bedroom-double-green', 'Bedroom double', 'bedrooms', 'Bright double bedroom with green accents at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2896.jpg' => ['ixora-homestay-bedroom-wardrobe-view', 'Bedroom wardrobe', 'bedrooms', 'Spacious bedroom with olive wardrobe at IXORA 2 BHK Homestay Kannur'],
    'PUZ_2901.jpg' => ['ixora-homestay-bedroom-to-dining', 'Bedroom to dining', 'bedrooms', 'Air-conditioned bedroom opening to dining area at IXORA Homestay Niduvaloor'],
    'PUZ_2902.jpg' => ['ixora-homestay-bedroom-wood-ceiling', 'Wood ceiling bedroom', 'bedrooms', 'Modern bedroom with wood ceiling and marble floor at IXORA Homestay Kannur'],
    'PUZ_2903.jpg' => ['ixora-homestay-bedroom-art-wall', 'Bedroom art wall', 'bedrooms', 'Guest bedroom with colourful wall art at IXORA Homestay Niduvaloor'],
    'PUZ_2904.jpg' => ['ixora-homestay-bedroom-buddha-art', 'Bedroom decor', 'bedrooms', 'Clean guest bedroom with artistic wall decor at IXORA Homestay Kannur'],
    'PUZ_2910.jpg' => ['ixora-homestay-interior-view-2910', 'Interior view', 'living', 'Interior living space at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2912.jpg' => ['ixora-homestay-interior-view-2912', 'Interior view', 'living', 'Interior room view at IXORA private Homestay Niduvaloor'],
    'PUZ_2916.jpg' => ['ixora-homestay-interior-view-2916', 'Interior view', 'living', 'Homestay interior at IXORA Niduvaloor Gate Kannur'],
    'PUZ_2921.jpg' => ['ixora-homestay-living-room-lounge', 'Living lounge', 'living', 'Modern living lounge with blue sofas at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2924.jpg' => ['ixora-homestay-interior-view-2924', 'Interior view', 'living', 'Common area interior at IXORA Homestay Kannur Kerala'],
    'PUZ_2926.jpg' => ['ixora-homestay-interior-view-2926', 'Interior view', 'living', 'Spacious interior at IXORA 2 BHK Homestay Niduvaloor'],
    'PUZ_2929.jpg' => ['ixora-homestay-interior-view-2929', 'Interior view', 'living', 'Guest living area at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2930.jpg' => ['ixora-homestay-interior-view-2930', 'Interior view', 'living', 'Homestay living space at IXORA Niduvaloor Gate'],
    'PUZ_2934.jpg' => ['ixora-homestay-interior-view-2934', 'Interior view', 'living', 'Interior detail at IXORA Homestay Kannur'],
    'PUZ_2938.jpg' => ['ixora-homestay-interior-view-2938', 'Interior view', 'living', 'Room interior at IXORA private Homestay Kerala'],
    'PUZ_2941.jpg' => ['ixora-homestay-outdoor-view-2941', 'Outdoor grounds', 'courtyard', 'Outdoor grounds at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2944.jpg' => ['ixora-homestay-outdoor-screen-courtyard', 'Outdoor screen', 'events', 'Outdoor courtyard with screen stage at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2947.jpg' => ['ixora-homestay-outdoor-view-2947', 'Outdoor grounds', 'courtyard', 'Garden courtyard path at IXORA Homestay Kannur'],
    'PUZ_2952.jpg' => ['ixora-homestay-outdoor-view-2952', 'Outdoor grounds', 'courtyard', 'Landscaped outdoor area at IXORA Homestay Niduvaloor'],
    'PUZ_2954.jpg' => ['ixora-homestay-outdoor-view-2954', 'Outdoor grounds', 'courtyard', 'Homestay courtyard surrounded by greenery at IXORA Kannur'],
    'PUZ_2955.jpg' => ['ixora-homestay-outdoor-view-2955', 'Outdoor grounds', 'courtyard', 'Lush outdoor space at IXORA Homestay Niduvaloor Gate'],
    'PUZ_2956.jpg' => ['ixora-homestay-outdoor-view-2956', 'Outdoor grounds', 'courtyard', 'Gravel courtyard and garden at IXORA Homestay Kannur'],
    'PUZ_2958.jpg' => ['ixora-homestay-garden-walkway-forest', 'Garden walkway', 'courtyard', 'Stone garden walkway beside forest at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2959.jpg' => ['ixora-homestay-outdoor-view-2959', 'Outdoor grounds', 'courtyard', 'Outdoor garden seating area at IXORA Homestay Kannur'],
    'PUZ_2960.jpg' => ['ixora-homestay-outdoor-view-2960', 'Outdoor grounds', 'courtyard', 'Courtyard greenery at IXORA Homestay Niduvaloor'],
    'PUZ_2964.jpg' => ['ixora-homestay-outdoor-view-2964', 'Outdoor grounds', 'courtyard', 'Property grounds at IXORA Homestay Kannur Kerala'],
    'PUZ_2965.jpg' => ['ixora-homestay-outdoor-view-2965', 'Outdoor grounds', 'courtyard', 'Outdoor amenity area at IXORA Homestay Niduvaloor'],
    'PUZ_2966.jpg' => ['ixora-homestay-outdoor-view-2966', 'Outdoor grounds', 'homestay', 'Homestay outdoor view at IXORA Niduvaloor Gate Kannur'],
    'PUZ_2968.jpg' => ['ixora-homestay-room-view-2968', 'Room view', 'bedrooms', 'Guest room interior at IXORA Homestay Niduvaloor Kannur'],
    'PUZ_2970.JPG' => ['ixora-homestay-cozy-single-bedroom', 'Cozy bedroom', 'bedrooms', 'Cozy single bedroom with lavender bedding at IXORA Homestay Niduvaloor'],
    'PUZ_2973.jpg' => ['ixora-homestay-room-view-2973', 'Room view', 'bedrooms', 'Guest bedroom at IXORA Homestay Kannur Kerala'],
    'PUZ_2974.jpg' => ['ixora-homestay-room-view-2974', 'Room view', 'bedrooms', 'Homestay bedroom interior at IXORA Niduvaloor Gate'],
];

function optimize_image(string $src, string $jpgOut, string $webpOut, int $maxWidth, int $jpgQuality, int $webpQuality): array
{
    $binary = file_get_contents($src);
    if ($binary === false) {
        return ['ok' => false, 'error' => 'unreadable'];
    }

    $source = @imagecreatefromstring($binary);
    if ($source === false) {
        return ['ok' => false, 'error' => 'decode failed'];
    }

    $width = imagesx($source);
    $height = imagesy($source);

    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int) max(1, round($height * ($maxWidth / $width)));
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        if ($canvas === false) {
            imagedestroy($source);

            return ['ok' => false, 'error' => 'resize failed'];
        }
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);
        $source = $canvas;
        $width = $newWidth;
        $height = $newHeight;
    }

    imageinterlace($source, true);
    $jpgOk = @imagejpeg($source, $jpgOut, $jpgQuality);
    $webpOk = @imagewebp($source, $webpOut, $webpQuality);
    imagedestroy($source);

    if (! $jpgOk || ! is_file($jpgOut)) {
        return ['ok' => false, 'error' => 'jpg encode failed'];
    }

    return [
        'ok' => true,
        'width' => $width,
        'height' => $height,
        'jpg_bytes' => filesize($jpgOut) ?: 0,
        'webp_bytes' => ($webpOk && is_file($webpOut)) ? (filesize($webpOut) ?: 0) : 0,
        'webp' => $webpOk && is_file($webpOut),
    ];
}

$results = [];
$okCount = 0;
$failCount = 0;
$bytesIn = 0;
$bytesOut = 0;

foreach ($map as $basename => [$slug, $caption, $category, $alt]) {
    $src = $sourceDir.DIRECTORY_SEPARATOR.$basename;
    if (! is_file($src)) {
        // Try case variants
        $altSrc = $sourceDir.DIRECTORY_SEPARATOR.str_replace('.JPG', '.jpg', $basename);
        if (is_file($altSrc)) {
            $src = $altSrc;
        } else {
            echo "MISSING {$basename}\n";
            $failCount++;
            continue;
        }
    }

    $bytesIn += filesize($src) ?: 0;
    $jpgOut = $outImages.DIRECTORY_SEPARATOR.$slug.'.jpg';
    $webpOut = $outImages.DIRECTORY_SEPARATOR.$slug.'.webp';

    $result = optimize_image($src, $jpgOut, $webpOut, $maxWidth, $jpgQuality, $webpQuality);
    if (! ($result['ok'] ?? false)) {
        echo "FAIL {$basename}: ".($result['error'] ?? 'unknown')."\n";
        $failCount++;
        continue;
    }

    $bytesOut += ($result['jpg_bytes'] ?? 0) + ($result['webp_bytes'] ?? 0);
    $okCount++;
    $results[] = [
        'source' => $basename,
        'slug' => $slug,
        'fallback' => 'assets/images/'.$slug.'.jpg',
        'caption' => $caption,
        'category' => $category,
        'alt' => $alt,
        'width' => $result['width'],
        'height' => $result['height'],
        'jpg_kb' => round(($result['jpg_bytes'] ?? 0) / 1024),
        'webp_kb' => round(($result['webp_bytes'] ?? 0) / 1024),
    ];

    echo sprintf(
        "OK %-40s  %dx%d  JPG %dKB  WebP %dKB\n",
        $slug,
        $result['width'],
        $result['height'],
        (int) round(($result['jpg_bytes'] ?? 0) / 1024),
        (int) round(($result['webp_bytes'] ?? 0) / 1024)
    );
}

// Copy video if present (compress later with ffmpeg when available)
$videoSrc = $sourceDir.DIRECTORY_SEPARATOR.'VID-20260926-WA0011.mp4';
$videoOut = $outVideos.DIRECTORY_SEPARATOR.'ixora-homestay-property-tour.mp4';
$videoNote = 'skipped';
if (is_file($videoSrc)) {
    if (! is_file($videoOut) || filesize($videoOut) !== filesize($videoSrc)) {
        if (! @copy($videoSrc, $videoOut)) {
            $videoNote = 'copy failed';
        } else {
            $videoNote = 'copied raw '.round((filesize($videoOut) ?: 0) / 1048576, 1).'MB (compress with ffmpeg recommended)';
        }
    } else {
        $videoNote = 'already present';
    }
}

$manifestPath = $root.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR.'homestay-media-manifest.json';
file_put_contents($manifestPath, json_encode([
    'generated_at' => date('c'),
    'count' => count($results),
    'images' => $results,
    'video' => [
        'source' => 'VID-20260926-WA0011.mp4',
        'public' => 'assets/videos/ixora-homestay-property-tour.mp4',
        'note' => $videoNote,
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "\nDone. {$okCount} images optimized, {$failCount} failed.\n";
echo sprintf("In %.1f MB → out JPG+WebP %.1f MB\n", $bytesIn / 1048576, $bytesOut / 1048576);
echo "Manifest: {$manifestPath}\n";
echo "Video: {$videoNote}\n";
