<?php

namespace Database\Seeders;

use App\Models\FeatureSetting;
use App\Support\Feature;
use Illuminate\Database\Seeder;

class FeatureSettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Feature::keys() as $key) {
            FeatureSetting::query()->updateOrCreate(
                ['key' => $key],
                ['is_enabled' => true]
            );
        }

        Feature::flush();
    }
}
