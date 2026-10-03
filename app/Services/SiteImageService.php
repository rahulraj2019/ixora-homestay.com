<?php

namespace App\Services;

use App\Models\Media;
use App\Models\SiteImageAssignment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteImageService
{
    protected string $cacheKey = 'site_image_assignments';

    /**
     * Request-level Media lookup to avoid N+1 when rendering many slots.
     *
     * @var array<int, Media>|null
     */
    private ?array $mediaCache = null;

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
    public function get(string $key): ?array
    {
        $definition = config('site-images.slots', [])[$key] ?? null;

        if (! is_array($definition)) {
            return null;
        }

        $mediaId = $this->assignments()[$key] ?? null;
        $media = $mediaId ? $this->mediaById($mediaId) : null;

        $originalUrl = $media?->url() ?: asset((string) ($definition['fallback'] ?? ''));
        $webpUrl = $this->webpUrlFor($media, (string) ($definition['fallback'] ?? ''));
        $url = $webpUrl ?: $originalUrl;
        $srcset = $media ? null : $this->responsiveSrcset((string) ($definition['fallback'] ?? ''));

        $width = $media?->width ?: ($definition['width'] ?? null);
        $height = $media?->height ?: ($definition['height'] ?? null);

        if ($webpUrl && ! $media) {
            $webpRelative = app(ImageOptimizer::class)->webpPublicPath((string) ($definition['fallback'] ?? ''));
            if ($webpRelative) {
                $size = @getimagesize(public_path($webpRelative));
                if (is_array($size)) {
                    $width = $size[0];
                    $height = $size[1];
                }
            }
        }

        return [
            'key' => $key,
            'media_id' => $media?->id,
            'url' => $url,
            'srcset' => $srcset['srcset'] ?? null,
            'sizes' => $srcset['sizes'] ?? null,
            'alt' => $media?->alt ?: ($definition['alt'] ?? $definition['label'] ?? $key),
            'width' => $width,
            'height' => $height,
            'caption' => $definition['caption'] ?? null,
            'category' => $definition['category'] ?? null,
            'label' => $definition['label'] ?? $key,
            'group' => $definition['group'] ?? null,
            'is_custom' => $media !== null,
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function group(string $group): array
    {
        $keys = collect(config('site-images.slots', []))
            ->filter(fn (array $slot) => ($slot['group'] ?? null) === $group)
            ->keys()
            ->values();

        return $keys
            ->map(fn (string $key) => $this->get($key))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function definitions(): array
    {
        return config('site-images.slots', []);
    }

    public function assign(string $key, ?int $mediaId): void
    {
        if (! array_key_exists($key, $this->definitions())) {
            return;
        }

        if ($mediaId === null) {
            SiteImageAssignment::query()->where('key', $key)->delete();
        } else {
            SiteImageAssignment::query()->updateOrCreate(
                ['key' => $key],
                ['media_id' => $mediaId]
            );
        }

        $this->forgetCache();
    }

    /**
     * @return array<string, int|null>
     */
    protected function assignments(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return SiteImageAssignment::query()
                ->pluck('media_id', 'key')
                ->all();
        });
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
        $this->mediaCache = null;
    }

    private function mediaById(int $mediaId): ?Media
    {
        if ($this->mediaCache === null) {
            $ids = array_values(array_filter($this->assignments()));
            $this->mediaCache = $ids === []
                ? []
                : Media::query()->whereIn('id', $ids)->get()->keyBy('id')->all();
        }

        return $this->mediaCache[$mediaId] ?? null;
    }

    private function webpUrlFor(?Media $media, string $fallbackRelative): ?string
    {
        if ($media) {
            $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', (string) $media->path);
            if (is_string($webpPath) && $webpPath !== $media->path && Storage::disk($media->disk)->exists($webpPath)) {
                return Storage::disk($media->disk)->url($webpPath);
            }

            return null;
        }

        if ($fallbackRelative === '') {
            return null;
        }

        $webpRelative = app(ImageOptimizer::class)->webpPublicPath($fallbackRelative);

        return $webpRelative ? asset($webpRelative) : null;
    }

    /**
     * Build srcset from optional `{name}-800.webp` + `{name}.webp` public derivatives.
     *
     * @return array{srcset: string, sizes: string}|null
     */
    private function responsiveSrcset(string $fallbackRelative): ?array
    {
        if ($fallbackRelative === '') {
            return null;
        }

        $relative = ltrim(str_replace('\\', '/', $fallbackRelative), '/');
        $webpRelative = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative);
        if (! is_string($webpRelative)) {
            return null;
        }

        $base = preg_replace('/\.webp$/i', '', $webpRelative);
        if (! is_string($base)) {
            return null;
        }

        $candidates = [
            $base.'-800.webp',
            $webpRelative,
        ];

        $parts = [];
        foreach ($candidates as $candidate) {
            $absolute = public_path($candidate);
            if (! is_file($absolute)) {
                continue;
            }
            $size = @getimagesize($absolute);
            $w = is_array($size) ? (int) $size[0] : 0;
            if ($w < 1) {
                continue;
            }
            $parts[] = asset($candidate).' '.$w.'w';
        }

        if (count($parts) < 2) {
            return null;
        }

        return [
            'srcset' => implode(', ', $parts),
            'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 1100px',
        ];
    }
}
