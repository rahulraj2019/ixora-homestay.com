<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected string $cacheKey = 'app_settings';

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default;
    }

    public function set(string $group, string $key, mixed $value, string $type = 'text'): Setting
    {
        $setting = Setting::query()->updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type],
        );

        $this->forget();

        return $setting;
    }

    /**
     * @return array<string, mixed>
     */
    public function getGroup(string $group): array
    {
        return Setting::query()
            ->where('group', $group)
            ->get()
            ->mapWithKeys(fn (Setting $setting) => [$setting->key => $setting->value])
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return Setting::query()
                ->get()
                ->mapWithKeys(fn (Setting $setting) => [$setting->key => $setting->value])
                ->all();
        });
    }

    public function forget(): void
    {
        Cache::forget($this->cacheKey);
    }
}
