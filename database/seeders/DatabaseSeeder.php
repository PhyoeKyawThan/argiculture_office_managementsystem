<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FeatureSettingSeeder::class,
            LandingSectionSeeder::class,
            StaffSeeder::class,
            // AgriculturalAnnouncementSeeder::class,
            CategorySeeder::class,
            // FertilizerLicenseSeeder::class,
        ]);
    }
}
