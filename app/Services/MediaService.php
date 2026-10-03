<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * @param  array{alt?: string|null, title?: string|null, caption?: string|null, folder?: string|null}  $meta
     */
    public function store(UploadedFile $file, array $meta = []): Media
    {
        $folder = trim($meta['folder'] ?? 'media', '/');
        $disk = 'public';
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $filename = Str::uuid()->toString().($extension ? '.'.$extension : '');
        $path = $file->storeAs($folder, $filename, $disk);

        $width = null;
        $height = null;

        if (str_starts_with((string) $file->getMimeType(), 'image/')) {
            $absolute = Storage::disk($disk)->path($path);
            $dimensions = @getimagesize($absolute);
            if ($dimensions) {
                $width = $dimensions[0];
                $height = $dimensions[1];
            }

            if (in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
                app(ImageOptimizer::class)->toWebp($absolute, 1600, 78);
            }
        }

        return Media::query()->create([
            'disk' => $disk,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize() ?: 0,
            'width' => $width,
            'height' => $height,
            'alt' => $meta['alt'] ?? null,
            'title' => $meta['title'] ?? null,
            'caption' => $meta['caption'] ?? null,
            'folder' => $folder,
        ]);
    }

    public function delete(Media $media): void
    {
        $disk = Storage::disk($media->disk);

        if ($disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', (string) $media->path);
        if (is_string($webpPath) && $webpPath !== $media->path && $disk->exists($webpPath)) {
            $disk->delete($webpPath);
        }

        $media->delete();
    }
}
