@php
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
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($seoDesc), 160, '') }}">
@if(filled(setting('seo_keywords')))
<meta name="keywords" content="{{ setting('seo_keywords') }}">
@endif
<meta name="robots" content="{{ $robots }}">
<meta name="author" content="{{ $brand }}">
<meta name="theme-color" content="#173126">
<meta name="format-detection" content="telephone=yes">
<meta name="geo.region" content="{{ setting('geo_region', 'IN-KL') }}">
<meta name="geo.placename" content="{{ setting('geo_placename', 'Niduvaloor, Irikkur, Thaliparamba, Kannur, Kerala') }}">
@php
    $geoLat = setting('geo_latitude', config('nearby-places.homestay.lat'));
    $geoLng = setting('geo_longitude', config('nearby-places.homestay.lng'));
    $geoPosition = setting('geo_position', $geoLat.';'.$geoLng);
@endphp
@if(filled($geoPosition))
<meta name="geo.position" content="{{ $geoPosition }}">
<meta name="ICBM" content="{{ $geoLat }}, {{ $geoLng }}">
@endif
<link rel="canonical" href="{{ $canonical }}">
<link rel="alternate" hreflang="en-IN" href="{{ $canonical }}">
<link rel="alternate" hreflang="x-default" href="{{ url('/') }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $brand }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDesc }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $ogImageAlt }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $twTitle }}">
<meta name="twitter:description" content="{{ $twDesc }}">
<meta name="twitter:image" content="{{ $twImage }}">
<meta name="twitter:image:alt" content="{{ $ogImageAlt }}">
