<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizer;
use Illuminate\Console\Command;

class OptimizeImagesCommand extends Command
{
    protected $signature = 'images:optimize
        {--path=assets/images : Directory under public/ to optimize}
        {--max-width=1600 : Maximum output width in pixels}
        {--quality=78 : WebP quality 1-100}';

    protected $description = 'Generate smaller WebP derivatives for JPG/PNG assets';

    public function handle(ImageOptimizer $optimizer): int
    {
        if (! function_exists('imagewebp')) {
            $this->error('PHP GD with WebP support is required.');

            return self::FAILURE;
        }

        $relative = trim(str_replace('\\', '/', (string) $this->option('path')), '/');
        $directory = public_path($relative);
        $maxWidth = max(320, (int) $this->option('max-width'));
        $quality = min(100, max(40, (int) $this->option('quality')));

        $this->info("Optimizing images in {$directory}");

        $results = $optimizer->optimizeDirectory($directory, $maxWidth, $quality);
        $created = 0;
        $saved = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($results as $result) {
            $label = str_replace(public_path().DIRECTORY_SEPARATOR, '', $result['source']);

            if (! ($result['ok'] ?? false)) {
                if (isset($result['skipped'])) {
                    $skipped++;
                    $this->line("skip  {$label} ({$result['skipped']})");
                } else {
                    $failed++;
                    $this->warn("fail  {$label} — ".($result['error'] ?? 'unknown'));
                }

                continue;
            }

            if (($result['skipped'] ?? null) === 'up to date') {
                $skipped++;

                continue;
            }

            $created++;
            $in = (int) ($result['bytes_in'] ?? 0);
            $out = (int) ($result['bytes_out'] ?? 0);
            $saved += max(0, $in - $out);
            $this->line(sprintf(
                'webp  %s  %s → %s (−%s)',
                $label,
                $this->formatBytes($in),
                $this->formatBytes($out),
                $this->formatBytes(max(0, $in - $out))
            ));
        }

        $this->newLine();
        $this->info("Created: {$created} | Skipped: {$skipped} | Failed: {$failed} | Saved: ".$this->formatBytes($saved));

        return $failed > 0 && $created === 0 ? self::FAILURE : self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes.' B';
        }

        if ($bytes < 1048576) {
            return round($bytes / 1024, 1).' KB';
        }

        return round($bytes / 1048576, 2).' MB';
    }
}
