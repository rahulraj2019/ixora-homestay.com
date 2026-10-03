<?php

/**
 * Apply maps + SEO updates to live settings and pages.
 * Usage: php84 artisan tinker --execute "require 'scripts/apply-seo-maps-boost.php';"
 * Or: php84 scripts/apply-seo-maps-boost.php (bootstraps Laravel)
 */

use App\Models\Faq;
use App\Models\Page;
use App\Services\SettingsService;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = app(SettingsService::class);

$mapRows = [
    ['contact', 'maps_link', 'https://maps.app.goo.gl/ht4uuSDodgYPxeKT6'],
    ['contact', 'maps_embed', 'https://www.google.com/maps?q=12.043528,75.466966+(IXORA+Homestay)&z=16&output=embed'],
    ['contact', 'map_query', '12.043528,75.466966'],
    ['contact', 'geo_placename', 'Niduvaloor, Irikkur, Thaliparamba, Kannur, Kerala'],
    ['contact', 'geo_position', '12.043528;75.466966'],
    ['contact', 'geo_latitude', '12.043528'],
    ['contact', 'geo_longitude', '75.466966'],
    ['general', 'site_description', 'IXORA is an affordable family homestay in Kannur at Niduvaloor Gate near Irikkur and Thaliparamba - private 2 BHK home stay in Kannur Kerala with courtyard, kitchen, parking and easy access to beaches, forts and temples.'],
    ['general', 'schema_description', 'Best homestay in Kannur near Irikkur and Thaliparamba: private 2 BHK family rooms, kitchen, parking, courtyard, campfire and grill. Ideal affordable homestay in Kannur Kerala for families and weekend getaways.'],
    ['seo', 'meta_description', 'Best homestay in Kannur at IXORA Niduvaloor near Irikkur & Thaliparamba - affordable family homestay in Kannur Kerala with private 2 BHK, parking and courtyard.'],
    ['seo', 'default_meta_title', 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba'],
    ['seo', 'default_meta_description', 'Book IXORA - affordable family homestay in Kannur near Irikkur and Thaliparamba. Private 2 BHK home stay in Kannur Kerala with kitchen, parking and courtyard.'],
    ['seo', 'seo_keywords', 'Homestay in Kannur, Best homestay in Kannur, Affordable homestay in Kannur, Family homestay in Kannur, Homestay near Kannur, Homestay in Thaliparamba, Homestay in Irikkur, Homestay near Irikkur, Homestay near Thaliparamba, Home stay in Kannur Kerala, Niduvaloor Homestay'],
];

foreach ($mapRows as [$group, $key, $value]) {
    $settings->set($group, $key, $value, 'text');
    echo "setting {$key}\n";
}

$pageMeta = [
    'home' => [
        'meta_title' => 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba',
        'meta_description' => 'Book the best homestay in Kannur at IXORA Niduvaloor - affordable family homestay near Irikkur & Thaliparamba. Private 2 BHK home stay in Kannur Kerala with parking & courtyard.',
    ],
    'stay' => [
        'meta_title' => 'Family Homestay in Kannur | Affordable Homestay near Irikkur',
        'meta_description' => 'Affordable family rooms at IXORA - a private homestay in Kannur near Irikkur and Thaliparamba with 2 bedrooms, kitchen, dining, courtyard and parking.',
    ],
    'events' => [
        'meta_title' => 'Homestay in Kannur for Celebrations | Event Venue Niduvaloor',
        'meta_description' => 'Host birthdays and family gatherings at IXORA - a Kannur homestay near Thaliparamba & Irikkur with courtyard, stage, photo point, campfire and grill.',
    ],
    'explore' => [
        'meta_title' => 'Things to Do near Homestay in Kannur | Explore from IXORA',
        'meta_description' => 'From your homestay near Kannur & Irikkur explore Muzhappilangad Beach, St. Angelo Fort, Parassinikadavu Temple, Paithalmala and more day trips.',
    ],
    'gallery' => [
        'meta_title' => 'Homestay in Kannur Photos | IXORA Rooms & Courtyard Gallery',
        'meta_description' => 'See rooms, courtyard and celebration spaces at IXORA - an affordable family home stay in Kannur Kerala at Niduvaloor Gate near Irikkur.',
    ],
    'booking' => [
        'meta_title' => 'Book Homestay in Kannur | IXORA near Irikkur & Thaliparamba',
        'meta_description' => 'Book an affordable family homestay in Kannur at IXORA Niduvaloor Gate. Check dates for private 2 BHK stay near Irikkur and Thaliparamba - WhatsApp rates.',
    ],
    'about' => [
        'meta_title' => 'About IXORA | Homestay near Irikkur, Thaliparamba & Kannur',
        'meta_description' => 'IXORA is a traditional Kerala family homestay in Niduvaloor near Irikkur and Thaliparamba - private house, courtyard, kitchen and parking in Kannur district.',
    ],
    'faq' => [
        'meta_title' => 'Homestay in Kannur FAQ | Location near Irikkur & Booking Tips',
        'meta_description' => 'FAQs for the best homestay in Kannur near Irikkur & Thaliparamba: location, parking, kitchen, check-in, events and day trips around Kannur Kerala.',
    ],
    'reviews' => [
        'meta_title' => 'IXORA Homestay Reviews | Best Homestay in Kannur Guests',
        'meta_description' => 'Guest reviews of IXORA - family homestay in Kannur near Irikkur and Thaliparamba. Real stays, celebrations and Kerala hospitality at Niduvaloor.',
    ],
    'contact' => [
        'meta_title' => 'Contact Homestay in Kannur | IXORA Niduvaloor near Irikkur',
        'meta_description' => 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur & Thaliparamba. IXORA Niduvaloor Gate - +91 80757 71824 / +91 94968 50582.',
    ],
];

foreach ($pageMeta as $slug => $meta) {
    $page = Page::query()->where('slug', $slug)->first();
    if (! $page) {
        echo "missing page {$slug}\n";
        continue;
    }
    $page->fill([
        'meta_title' => $meta['meta_title'],
        'meta_description' => $meta['meta_description'],
        'og_title' => $meta['meta_title'],
        'og_description' => $meta['meta_description'],
        'twitter_title' => $meta['meta_title'],
        'twitter_description' => $meta['meta_description'],
    ])->save();
    echo "page {$slug}\n";
}

$faq = Faq::query()->where('question', 'Where is IXORA Homestay located?')->first();
if ($faq) {
    $faq->answer = 'IXORA is at <strong>Building No. 7-334, Ixora Homestay, Niduvaloor Gate, Niduvaloor, 670142</strong>, Kannur district, Kerala - a private <strong>family homestay in Kannur</strong> near <strong>Irikkur</strong> and <strong>Thaliparamba</strong>. See the exact pin on <a href="https://maps.app.goo.gl/ht4uuSDodgYPxeKT6" target="_blank" rel="noopener">Google Maps</a>.';
    $faq->save();
    echo "faq location updated\n";
}

echo "maps_link=".homestay_maps_link().PHP_EOL;
echo "origin=".homestay_maps_origin().PHP_EOL;
echo "embed=".homestay_maps_embed().PHP_EOL;
echo "Done\n";
