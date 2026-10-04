<?php
    $brand = setting('business_name', 'IXORA Homestay');
    $rawTitle = $page->meta_title ?? $page->title ?? $brand;
    $seoTitle = str_contains((string) $rawTitle, 'IXORA') ? $rawTitle : $rawTitle.' | '.$brand;
    $seoDesc = $page->meta_description ?? setting('meta_description', setting('default_meta_description', 'Best homestay in Kannur near Irikkur and Thaliparamba — affordable family home stay in Kannur Kerala at IXORA Niduvaloor.'));
    $canonical = $page->canonical_url ?: url()->current();
    $robots = $page->robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $ogTitle = $page->og_title ?? $seoTitle;
    $ogDesc = $page->og_description ?? $seoDesc;
    $defaultOg = 'assets/images/ixora-homestay-niduvaloor-exterior-sunset.jpg';
    $ogImagePath = $page->og_image ?: $defaultOg;
    $ogImage = str_starts_with((string) $ogImagePath, 'http') ? $ogImagePath : asset($ogImagePath);
    $ogImageAlt = $page->title
        ? $page->title.' — '.$brand.' Niduvaloor Kannur'
        : 'IXORA private 2 BHK homestay exterior at sunset in Niduvaloor Kannur Kerala';
    $twTitle = $page->twitter_title ?? $ogTitle;
    $twDesc = $page->twitter_description ?? $ogDesc;
    $twImage = $page->twitter_image
        ? (str_starts_with($page->twitter_image, 'http') ? $page->twitter_image : asset($page->twitter_image))
        : $ogImage;
?>
<title><?php echo e($seoTitle); ?></title>
<meta name="description" content="<?php echo e(\Illuminate\Support\Str::limit(strip_tags($seoDesc), 160, '')); ?>">
<?php if(filled(setting('seo_keywords'))): ?>
<meta name="keywords" content="<?php echo e(setting('seo_keywords')); ?>">
<?php endif; ?>
<meta name="robots" content="<?php echo e($robots); ?>">
<meta name="author" content="<?php echo e($brand); ?>">
<meta name="theme-color" content="#173126">
<meta name="format-detection" content="telephone=yes">
<meta name="geo.region" content="<?php echo e(setting('geo_region', 'IN-KL')); ?>">
<meta name="geo.placename" content="<?php echo e(setting('geo_placename', 'Niduvaloor, Irikkur, Thaliparamba, Kannur, Kerala')); ?>">
<?php
    $geoLat = setting('geo_latitude', config('nearby-places.homestay.lat'));
    $geoLng = setting('geo_longitude', config('nearby-places.homestay.lng'));
    $geoPosition = setting('geo_position', $geoLat.';'.$geoLng);
?>
<?php if(filled($geoPosition)): ?>
<meta name="geo.position" content="<?php echo e($geoPosition); ?>">
<meta name="ICBM" content="<?php echo e($geoLat); ?>, <?php echo e($geoLng); ?>">
<?php endif; ?>
<link rel="canonical" href="<?php echo e($canonical); ?>">
<link rel="alternate" hreflang="en-IN" href="<?php echo e($canonical); ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo e(url('/')); ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo e($brand); ?>">
<meta property="og:title" content="<?php echo e($ogTitle); ?>">
<meta property="og:description" content="<?php echo e($ogDesc); ?>">
<meta property="og:url" content="<?php echo e($canonical); ?>">
<meta property="og:image" content="<?php echo e($ogImage); ?>">
<meta property="og:image:alt" content="<?php echo e($ogImageAlt); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($twTitle); ?>">
<meta name="twitter:description" content="<?php echo e($twDesc); ?>">
<meta name="twitter:image" content="<?php echo e($twImage); ?>">
<meta name="twitter:image:alt" content="<?php echo e($ogImageAlt); ?>">
<?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/partials/seo.blade.php ENDPATH**/ ?>