@php
    $name = setting('business_name', 'IXORA Homestay');
    $phone = setting('phone_primary', '+918921525086');
    $phone2 = setting('phone_secondary', '+918075771824');
    $desc = setting('schema_description', 'Private 2 BHK homestay and event venue at Niduvaloor Gate, Kannur, Kerala with courtyard, campfire and grill.');
    $image = asset('assets/images/ixora-homestay-niduvaloor-exterior-sunset.jpg');
    $logo = setting('logo') ? asset('storage/'.setting('logo')) : asset('assets/images/ixora-homestay-logo.webp');
    $sameAs = array_values(array_filter([
        setting('instagram'),
        setting('facebook'),
        setting('youtube'),
    ]));

    $approvedReviews = collect(\Illuminate\Support\Facades\Cache::remember('schema_approved_reviews', 3600, function () {
        return \App\Models\Review::query()
            ->where('status', 'approved')
            ->latest()
            ->limit(12)
            ->get(['name', 'location', 'rating', 'message', 'created_at'])
            ->map(static function ($review): array {
                return [
                    'name' => $review->name,
                    'location' => $review->location,
                    'rating' => $review->rating,
                    'message' => $review->message,
                    'created_at' => optional($review->created_at)->toDateString(),
                ];
            })
            ->all();
    }));

    $reviewCount = $approvedReviews->count();
    $ratingValue = $reviewCount > 0
        ? round((float) $approvedReviews->avg('rating'), 1)
        : null;

    $lodging = [
        '@type' => 'LodgingBusiness',
        '@id' => url('/').'/#business',
        'name' => $name,
        'alternateName' => setting('alternate_name', 'Niduvaloor Gate Homestay & Event Venue'),
        'description' => $desc,
        'image' => [
            $image,
            asset('assets/images/ixora-homestay-bedroom-1-kannur.jpg'),
            asset('assets/images/ixora-homestay-private-courtyard.jpg'),
        ],
        'logo' => $logo,
        'url' => url('/'),
        'telephone' => array_values(array_filter([
            preg_replace('/\s+/', '', $phone),
            preg_replace('/\s+/', '', $phone2),
        ])),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => setting('street_address', 'Building No. 7-334, Ixora Homestay, Niduvaloor Gate'),
            'addressLocality' => setting('address_locality', 'Niduvaloor'),
            'addressRegion' => setting('address_region', 'Kerala'),
            'postalCode' => setting('postal_code', '670142'),
            'addressCountry' => 'IN',
        ],
        'priceRange' => setting('price_range', '$$'),
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => (string) setting('geo_latitude', config('nearby-places.homestay.lat')),
            'longitude' => (string) setting('geo_longitude', config('nearby-places.homestay.lng')),
        ],
        'hasMap' => homestay_maps_link(),
        'keywords' => setting('seo_keywords', 'Homestay in Kannur, Best homestay in Kannur, Affordable homestay in Kannur, Family homestay in Kannur, Homestay near Kannur, Homestay in Thaliparamba, Homestay in Irikkur, Homestay near Irikkur, Homestay near Thaliparamba, Home stay in Kannur Kerala'),
        'areaServed' => [
            ['@type' => 'City', 'name' => 'Kannur'],
            ['@type' => 'City', 'name' => 'Irikkur'],
            ['@type' => 'City', 'name' => 'Thaliparamba'],
            ['@type' => 'AdministrativeArea', 'name' => 'Niduvaloor'],
            ['@type' => 'State', 'name' => 'Kerala'],
        ],
        'amenityFeature' => [
            ['@type' => 'LocationFeatureSpecification', 'name' => 'Private kitchen', 'value' => true],
            ['@type' => 'LocationFeatureSpecification', 'name' => 'Free parking', 'value' => true],
            ['@type' => 'LocationFeatureSpecification', 'name' => 'Courtyard', 'value' => true],
            ['@type' => 'LocationFeatureSpecification', 'name' => 'Campfire', 'value' => true],
            ['@type' => 'LocationFeatureSpecification', 'name' => 'BBQ grill', 'value' => true],
            ['@type' => 'LocationFeatureSpecification', 'name' => 'Event stage', 'value' => true],
        ],
        'sameAs' => $sameAs ?: null,
    ];

    if ($ratingValue !== null && $reviewCount > 0) {
        $lodging['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $ratingValue,
            'reviewCount' => (string) $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];

        $lodging['review'] = $approvedReviews->take(8)->map(function (array $review) {
            return [
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => $review['name'],
                ],
                'datePublished' => $review['created_at'],
                'reviewBody' => $review['message'],
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => (string) $review['rating'],
                    'bestRating' => '5',
                    'worstRating' => '1',
                ],
            ];
        })->values()->all();
    }

    $org = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/').'/#website',
                'url' => url('/'),
                'name' => $name,
                'description' => $desc,
                'publisher' => ['@id' => url('/').'/#business'],
                'inLanguage' => 'en-IN',
            ],
            $lodging,
        ],
    ];

    if (empty($org['@graph'][1]['sameAs'])) {
        unset($org['@graph'][1]['sameAs']);
    }
    if (($org['@graph'][1]['address']['postalCode'] ?? '') === '') {
        unset($org['@graph'][1]['address']['postalCode']);
    }

    $slug = $page->slug ?? (request()->routeIs('home') ? 'home' : null);
    if ($slug && $slug !== 'home') {
        $org['@graph'][] = [
            '@type' => 'BreadcrumbList',
            '@id' => url()->current().'/#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $page->title ?? ucfirst((string) $slug),
                    'item' => url()->current(),
                ],
            ],
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode($org, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
@stack('schema')
