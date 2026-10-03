<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\ActivityLogger;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Media::query()->latest();

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('filename', 'like', "%{$search}%")
                    ->orWhere('alt', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate(24)->withQueryString();

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request, MediaService $mediaService, ActivityLogger $logger): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:10240'],
            'alt' => ['nullable', 'string', 'max:180'],
            'title' => ['nullable', 'string', 'max:180'],
        ]);

        foreach ($request->file('files', []) as $file) {
            if ($file->getMimeType() === 'image/svg+xml') {
                $contents = file_get_contents($file->getRealPath());
                if (preg_match('/<script|onload=|javascript:/i', $contents)) {
                    return back()->with('error', 'Unsafe SVG rejected.');
                }
            }

            $item = $mediaService->store($file, [
                'alt' => $request->input('alt'),
                'title' => $request->input('title'),
            ]);
            $logger->log('media.uploaded', $item);
        }

        return back()->with('success', 'Media uploaded.');
    }

    public function update(Request $request, Media $medium, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'alt' => ['nullable', 'string', 'max:180'],
            'title' => ['nullable', 'string', 'max:180'],
            'caption' => ['nullable', 'string', 'max:500'],
        ]);

        $medium->update($data);
        $logger->log('media.updated', $medium);

        return back()->with('success', 'Media updated.');
    }

    public function destroy(Media $medium, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('media.deleted', $medium);
        $medium->delete();

        return back()->with('success', 'Media soft-deleted. File kept on disk.');
    }
}
