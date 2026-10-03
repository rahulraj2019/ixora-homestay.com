<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\ActivityLogger;
use App\Services\SiteImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteImageController extends Controller
{
    public function index(SiteImageService $images): View
    {
        $slots = collect($images->definitions())
            ->map(function (array $definition, string $key) use ($images) {
                return array_merge($definition, $images->get($key) ?? [], ['key' => $key]);
            })
            ->groupBy(fn (array $slot) => $slot['group'] ?? 'other');

        $mediaOptions = Media::query()
            ->latest()
            ->get(['id', 'filename', 'title', 'alt', 'path']);

        return view('admin.site-images.index', compact('slots', 'mediaOptions'));
    }

    public function update(Request $request, SiteImageService $images, ActivityLogger $logger): RedirectResponse
    {
        $raw = $request->input('assignments', []);

        if (! is_array($raw)) {
            return back()->with('error', 'Invalid assignments.');
        }

        $count = 0;

        foreach ($raw as $key => $mediaId) {
            if (! is_string($key)) {
                continue;
            }

            $resolvedId = ($mediaId === null || $mediaId === '') ? null : (int) $mediaId;

            if ($resolvedId !== null && ! Media::query()->whereKey($resolvedId)->exists()) {
                continue;
            }

            $images->assign($key, $resolvedId);

            if ($resolvedId !== null) {
                $count++;
            }
        }

        $logger->log('site_images.updated', null, ['assigned' => $count]);

        return back()->with('success', 'Site images updated. Upload new files in Media Library, then assign them here.');
    }
}
