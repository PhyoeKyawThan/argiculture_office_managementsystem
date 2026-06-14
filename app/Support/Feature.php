<?php

namespace App\Support;

use App\Models\FeatureSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Feature
{
    protected static ?Collection $settings = null;

    public static function enabled(string $key): bool
    {
        return (bool) static::all()->get($key, true);
    }

    public static function all(): Collection
    {
        if (static::$settings !== null) {
            return static::$settings;
        }

        $cached = Cache::get('feature_settings');

        if (! is_array($cached)) {
            $cached = FeatureSetting::query()
                ->pluck('is_enabled', 'key')
                ->map(fn ($value) => (bool) $value)
                ->all();

            Cache::put('feature_settings', $cached, 3600);
        }

        static::$settings = collect($cached);

        return static::$settings;
    }

    public static function flush(): void
    {
        static::$settings = null;
        Cache::forget('feature_settings');
    }

    public static function keys(): array
    {
        return [
            'content_news',
            'content_weather_advisory',
            'content_farming_advisory',
            'content_main_crops',
            'content_pests',
            'content_pesticides',
            'content_crop_diseases',
            'farmer_inquiries',
            'farmer_registration',
            'shop_registration',
            'shop_inspections',
            'staff_management',
            'landing_cms',
        ];
    }
}
