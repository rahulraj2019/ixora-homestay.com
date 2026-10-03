<?php

use App\Services\ImageOptimizer;
use App\Services\SettingsService;
use App\Services\SiteImageService;
use Illuminate\Support\Facades\Cache;

if (! function_exists('asset_versioned')) {
    /**
     * Cache-busted public asset URL based on filemtime.
     */
    function asset_versioned(string $path): string
    {
        $relative = ltrim(str_replace('\\', '/', $path), '/');
        $absolute = public_path($relative);
        $version = is_file($absolute) ? (string) filemtime($absolute) : (string) time();

        return asset($relative).'?v='.$version;
    }
}

if (! function_exists('forget_frontend_content_cache')) {
    /**
     * Drop cached public page/FAQ/review payloads after admin edits.
     */
    function forget_frontend_content_cache(?string $pageSlug = null): void
    {
        $keys = [
            'faqs.home',
            'faqs.page',
            'reviews.approved.all',
            'reviews.approved.6',
            'schema_approved_reviews',
        ];

        if ($pageSlug) {
            $keys[] = 'page.'.$pageSlug;
        } else {
            $keys[] = 'page.home';
        }

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        if ($pageSlug === null) {
            // Best-effort: clear common page slugs without a full cache wipe.
            foreach (['stay', 'events', 'explore', 'gallery', 'booking', 'about', 'faq', 'reviews', 'contact'] as $slug) {
                Cache::forget('page.'.$slug);
            }
        }
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingsService::class)->get($key, $default);
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }
}

if (! function_exists('asset_image')) {
    function asset_image(string $filename): string
    {
        return asset('assets/images/'.$filename);
    }
}

if (! function_exists('site_image')) {
    /**
     * @return array{
     *     key: string,
     *     url: string,
     *     alt: string,
     *     width: int|null,
     *     height: int|null,
     *     caption: string|null,
     *     category: string|null,
     *     label: string,
     *     group: string|null,
     *     is_custom: bool
     * }|null
     */
    function site_image(string $key): ?array
    {
        return app(SiteImageService::class)->get($key);
    }
}

if (! function_exists('site_image_group')) {
    /**
     * @return list<array<string, mixed>>
     */
    function site_image_group(string $group): array
    {
        return app(SiteImageService::class)->group($group);
    }
}

if (! function_exists('site_image_url')) {
    function site_image_url(string $key, ?string $fallback = null): string
    {
        $image = site_image($key);

        if ($image) {
            return $image['url'];
        }

        return $fallback ? asset($fallback) : '';
    }
}

if (! function_exists('whatsapp_number')) {
    function whatsapp_number(): string
    {
        return preg_replace('/\D+/', '', (string) setting('whatsapp', '918921525086')) ?? '';
    }
}

if (! function_exists('whatsapp_message')) {
    function whatsapp_message(?string $override = null): string
    {
        $default = 'Hi IXORA Homestay! I found your details on the website and I\'d love to know more about booking a stay or celebration with you.';

        if ($override !== null && trim($override) !== '') {
            return trim($override);
        }

        $configured = trim((string) setting('whatsapp_message', $default));

        return $configured !== '' ? $configured : $default;
    }
}

if (! function_exists('whatsapp_url')) {
    /**
     * Prefer api.whatsapp.com so phones open the personal WhatsApp app
     * (not WhatsApp Business) when both are installed.
     */
    function whatsapp_url(?string $message = null): string
    {
        $phone = whatsapp_number();
        if ($phone === '') {
            return '#';
        }

        return 'https://api.whatsapp.com/send?phone='.$phone.'&text='.rawurlencode(whatsapp_message($message));
    }
}

if (! function_exists('homestay_maps_link')) {
    function homestay_maps_link(): string
    {
        $link = trim((string) setting(
            'maps_link',
            config('nearby-places.homestay.maps_link')
        ));

        return $link !== ''
            ? $link
            : (string) config('nearby-places.homestay.maps_link');
    }
}

if (! function_exists('homestay_maps_origin')) {
    /**
     * Exact lat,lng for Google Directions origin (Irikkur pin).
     * Do not use a place-name search — Google may route from a different POI.
     */
    function homestay_maps_origin(): string
    {
        $lat = config('nearby-places.homestay.lat');
        $lng = config('nearby-places.homestay.lng');

        $custom = trim((string) setting('map_query', ''));
        if ($custom !== '' && preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $custom)) {
            return preg_replace('/\s+/', '', $custom) ?? $custom;
        }

        return "{$lat},{$lng}";
    }
}

if (! function_exists('homestay_maps_query')) {
    /**
     * @deprecated Prefer homestay_maps_origin() for directions.
     */
    function homestay_maps_query(): string
    {
        return homestay_maps_origin();
    }
}

if (! function_exists('homestay_maps_embed')) {
    function homestay_maps_embed(): string
    {
        $default = (string) config('nearby-places.homestay.embed');
        $custom = trim((string) setting('maps_embed', ''));

        if ($custom === '') {
            return $default;
        }

        if (str_contains($custom, '<iframe')) {
            if (preg_match('/src=["\']([^"\']+)["\']/', $custom, $matches)) {
                return $matches[1];
            }
        }

        $lat = (string) config('nearby-places.homestay.lat');
        $lng = (string) config('nearby-places.homestay.lng');
        $latPattern = preg_quote($lat, '/');
        $lngPattern = preg_quote($lng, '/');

        // Text-name search embeds can land on the wrong POI — keep the exact pin.
        if (! preg_match('/[?&]q='.$latPattern.'\s*,\s*'.$lngPattern.'/', $custom)) {
            return $default;
        }

        return $custom;
    }
}

if (! function_exists('nearby_attractions')) {
    /**
     * @return list<array<string, mixed>>
     */
    function nearby_attractions(): array
    {
        static $cached = null;

        if ($cached !== null) {
            return $cached;
        }

        $origin = homestay_maps_origin();
        $optimizer = app(ImageOptimizer::class);
        $overridesRaw = setting('nearby_place_overrides', []);
        if (is_string($overridesRaw)) {
            $decoded = json_decode($overridesRaw, true);
            $overridesRaw = is_array($decoded) ? $decoded : [];
        }
        $overrides = is_array($overridesRaw) ? $overridesRaw : [];

        $cached = collect(config('nearby-places.attractions', []))
            ->sortBy([
                ['distance_km', 'asc'],
                ['title', 'asc'],
            ])
            ->values()
            ->map(function (array $place) use ($origin, $optimizer, $overrides) {
                $title = (string) ($place['title'] ?? '');
                $override = is_array($overrides[$title] ?? null) ? $overrides[$title] : [];
                if (isset($override['distance_km'])) {
                    $place['distance_km'] = (int) $override['distance_km'];
                }
                if (isset($override['drive_mins'])) {
                    $place['drive_mins'] = (int) $override['drive_mins'];
                }

                $query = rawurlencode($place['maps_query']);
                $imageRelative = (string) ($place['image'] ?? '');
                $imageUrl = null;

                if ($imageRelative !== '') {
                    $webpRelative = $optimizer->webpPublicPath($imageRelative);
                    $servedRelative = $webpRelative ?: $imageRelative;
                    $absolute = public_path($servedRelative);
                    $version = is_file($absolute) ? (string) filemtime($absolute) : (string) time();
                    $imageUrl = asset($servedRelative).'?v='.$version;
                }

                return [
                    ...$place,
                    'image_url' => $imageUrl,
                    'maps_url' => 'https://www.google.com/maps/search/?api=1&query='.$query,
                    'directions_url' => 'https://www.google.com/maps/dir/?api=1&origin='.rawurlencode($origin).'&destination='.$query,
                ];
            })
            ->sortBy([
                ['distance_km', 'asc'],
                ['title', 'asc'],
            ])
            ->values()
            ->all();

        return $cached;
    }
}

if (! function_exists('nearby_home_highlights')) {
    /**
     * Balanced mix for the home page so every filter tab has at least one place.
     *
     * @return list<array<string, mixed>>
     */
    function nearby_home_highlights(int $limit = 6): array
    {
        $priority = ['temple', 'hill', 'waterfall', 'beach', 'heritage', 'family'];
        $picked = [];
        $used = [];
        $places = nearby_attractions();

        foreach ($priority as $filter) {
            foreach ($places as $place) {
                $key = (string) ($place['title'] ?? '');
                if ($key === '' || isset($used[$key])) {
                    continue;
                }

                $cats = preg_split('/\s+/', trim((string) ($place['cat'] ?? ''))) ?: [];
                if (! in_array($filter, $cats, true)) {
                    continue;
                }

                $picked[] = $place;
                $used[$key] = true;
                break;
            }

            if (count($picked) >= $limit) {
                break;
            }
        }

        foreach ($places as $place) {
            if (count($picked) >= $limit) {
                break;
            }

            $key = (string) ($place['title'] ?? '');
            if ($key === '' || isset($used[$key])) {
                continue;
            }

            $picked[] = $place;
            $used[$key] = true;
        }

        return $picked;
    }
}

if (! function_exists('nearby_sacred_places')) {
    /**
     * @return list<array<string, mixed>>
     */
    function nearby_sacred_places(): array
    {
        return collect(nearby_attractions())
            ->filter(function (array $place) {
                $cat = strtolower((string) ($place['cat'] ?? ''));
                $type = strtolower((string) ($place['type'] ?? ''));

                return str_contains($cat, 'temple')
                    || str_contains($type, 'temple')
                    || str_contains($type, 'pilgrimage');
            })
            ->values()
            ->map(function (array $place) {
                return [
                    ...$place,
                    'name' => $place['title'],
                    'significance' => $place['blurb'],
                ];
            })
            ->all();
    }
}
