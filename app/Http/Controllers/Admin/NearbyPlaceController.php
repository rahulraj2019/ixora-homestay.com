<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NearbyPlaceController extends Controller
{
    public function index(SettingsService $settings): View
    {
        $overrides = $this->overrides($settings);
        $places = collect(config('nearby-places.attractions', []))
            ->map(function (array $place) use ($overrides) {
                $title = (string) ($place['title'] ?? '');
                $override = $overrides[$title] ?? [];

                return [
                    'title' => $title,
                    'type' => (string) ($place['type'] ?? ''),
                    'direction' => (string) ($place['direction'] ?? ''),
                    'distance_km' => (int) ($override['distance_km'] ?? $place['distance_km'] ?? 0),
                    'drive_mins' => (int) ($override['drive_mins'] ?? $place['drive_mins'] ?? 0),
                    'default_distance_km' => (int) ($place['distance_km'] ?? 0),
                    'default_drive_mins' => (int) ($place['drive_mins'] ?? 0),
                    'has_override' => isset($overrides[$title]),
                ];
            })
            ->sortBy('distance_km')
            ->values()
            ->all();

        return view('admin.nearby-places.index', compact('places'));
    }

    public function update(Request $request, SettingsService $settings, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'places' => ['required', 'array'],
            'places.*.title' => ['required', 'string', 'max:180'],
            'places.*.distance_km' => ['required', 'integer', 'min:0', 'max:500'],
            'places.*.drive_mins' => ['required', 'integer', 'min:0', 'max:600'],
        ]);

        $defaults = collect(config('nearby-places.attractions', []))
            ->keyBy('title');

        $overrides = [];
        foreach ($data['places'] as $row) {
            $title = (string) $row['title'];
            $default = $defaults->get($title);
            if (! is_array($default)) {
                continue;
            }

            $distance = (int) $row['distance_km'];
            $mins = (int) $row['drive_mins'];
            $defaultDistance = (int) ($default['distance_km'] ?? 0);
            $defaultMins = (int) ($default['drive_mins'] ?? 0);

            if ($distance === $defaultDistance && $mins === $defaultMins) {
                continue;
            }

            $overrides[$title] = [
                'distance_km' => $distance,
                'drive_mins' => $mins,
            ];
        }

        $settings->set('content', 'nearby_place_overrides', $overrides, 'json');
        $logger->log('nearby_places.updated', null, ['count' => count($overrides)]);

        return back()->with('success', 'Distances and drive times saved.');
    }

    /**
     * @return array<string, array{distance_km?: int, drive_mins?: int}>
     */
    private function overrides(SettingsService $settings): array
    {
        $raw = $settings->get('nearby_place_overrides', []);
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $raw = is_array($decoded) ? $decoded : [];
        }

        return is_array($raw) ? $raw : [];
    }
}
