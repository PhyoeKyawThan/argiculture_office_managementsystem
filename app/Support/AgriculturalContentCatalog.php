<?php

namespace App\Support;

use App\Models\Category;

class AgriculturalContentCatalog
{
    public const MODULE_NEWS = 'news';

    public const MODULE_WEATHER = 'weather_advisory';

    public const MODULE_FARMING = 'farming_advisory';

    public const MODULE_MAIN_CROPS = 'main_crops';

    public const MODULE_PESTS = 'pests';

    public const MODULE_PESTICIDES = 'pesticides';

    public const MODULE_CROP_DISEASES = 'crop_diseases';
    public const MODULE_SEEDS = 'seeds';

    public const MODULES = [
        self::MODULE_NEWS,
        self::MODULE_WEATHER,
        self::MODULE_FARMING,
        self::MODULE_MAIN_CROPS,
        self::MODULE_PESTS,
        self::MODULE_PESTICIDES,
        self::MODULE_CROP_DISEASES,
        self::MODULE_SEEDS
    ];

    public const MODULES_WITH_SUB_TYPES = [
        self::MODULE_MAIN_CROPS,
        self::MODULE_PESTS,
        self::MODULE_PESTICIDES,
        self::MODULE_CROP_DISEASES,
        self::MODULE_SEEDS,
    ];

    public const SUB_TYPE_RICE = 'rice';

    public const SUB_TYPE_PADDY = 'paddy';

    public const SUB_TYPE_MAIZE = 'maize';

    public const SUB_TYPE_SOYBEAN = 'soybean';

    public const SUB_TYPE_GROUNDNUT = 'groundnut';

    public const SUB_TYPE_SESAME = 'sesame';

    public const SUB_TYPE_COTTON = 'cotton';

    public const SUB_TYPE_SUGARCANE = 'sugarcane';

    public const SUB_TYPE_PULSES = 'pulses';

    public const SUB_TYPE_VEGETABLES = 'vegetables';

    public const CROP_SUB_TYPES = [
        self::SUB_TYPE_RICE,
        self::SUB_TYPE_PADDY,
        self::SUB_TYPE_MAIZE,
        self::SUB_TYPE_SOYBEAN,
        self::SUB_TYPE_GROUNDNUT,
        self::SUB_TYPE_SESAME,
        self::SUB_TYPE_COTTON,
        self::SUB_TYPE_SUGARCANE,
        self::SUB_TYPE_PULSES,
        self::SUB_TYPE_VEGETABLES,
    ];

    public const PEST_SUB_TYPES = [
        'stem_borer',
        'leaf_folder',
        'planthopper',
        'armyworm',
        'aphid',
        'whitefly',
        'thrips',
        'cutworm',
        'fruit_borer',
        'storage_pest',
    ];

    public const PESTICIDE_SUB_TYPES = [
        'insecticide',
        'herbicide',
        'fungicide',
        'nematicide',
        'rodenticide',
        'bio_pesticide',
        'seed_treatment',
        'spray_equipment',
        'safety_guideline',
        'registration_info',
    ];

    // TODO: need to add at least 10 sub types which would main in ayeyarwaddy
    public const SEED_SUB_TYPES = [
        'high_yield_variety',
        'hybrid_seed',
        'local_variety',
        'foundation_seed',
        'certified_seed',
    ];

    public const LEGACY_CATEGORY_MAP = [
        'news' => self::MODULE_NEWS,
        'weather_alert' => self::MODULE_WEATHER,
        'farming_tip' => self::MODULE_FARMING,
    ];

    public static function modules(): array
    {
        return static::publishedModules();
    }

    public static function moduleHasSubTypes(string $module): bool
    {
        return in_array($module, self::MODULES_WITH_SUB_TYPES, true);
    }

    public static function subTypesFor(string $module): array
    {
        return match ($module) {
            self::MODULE_MAIN_CROPS, self::MODULE_CROP_DISEASES => self::CROP_SUB_TYPES,
            self::MODULE_PESTS => self::PEST_SUB_TYPES,
            self::MODULE_PESTICIDES => self::PESTICIDE_SUB_TYPES,
            self::MODULE_SEEDS => self::SEED_SUB_TYPES,
            default => [],
        };
    }

    public static function isValidModule(string $module): bool
    {
        return in_array($module, self::MODULES, true);
    }

    public static function isValidSubType(string $module, ?string $subType): bool
    {
        if (!self::moduleHasSubTypes($module)) {
            return $subType === null || $subType === '';
        }

        return $subType !== null && in_array($subType, self::subTypesFor($module), true);
    }

    public static function featureKeyForModule(string $module): string
    {
        return 'content_' . $module;
    }

    public static function enabledModules(): array
    {
        return array_values(array_filter(
            static::modules(),
            fn(string $module) => Feature::enabled(self::featureKeyForModule($module))
        ));
    }

    public static function publishedModules(): array
    {
        return Category::whereNull('parent_id')
            ->pluck('slug')
            ->map(fn(string $slug) => str_replace('-', '_', $slug))
            // ->filter(fn(string $module) => static::isValidModule($module))
            ->values()
            ->toArray();
    }
}
