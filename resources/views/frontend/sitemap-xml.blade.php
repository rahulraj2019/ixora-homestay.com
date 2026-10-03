<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($pages as $page)
@php
    $loc = $page->slug === 'home' ? url('/') : url('/'.$page->slug);
    $priority = match ($page->slug) {
        'home' => '1.0',
        'stay', 'booking', 'events', 'gallery' => '0.9',
        'explore', 'faq', 'contact' => '0.8',
        default => '0.6',
    };
@endphp
    <url>
        <loc>{{ $loc }}</loc>
        <lastmod>{{ $page->updated_at?->toAtomString() }}</lastmod>
        <changefreq>{{ $page->slug === 'home' ? 'daily' : 'weekly' }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
@endforeach
</urlset>
