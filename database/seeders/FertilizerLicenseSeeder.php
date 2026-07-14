<?php

namespace Database\Seeders;

use App\Models\FertilizerDistributionLicense;
use App\Models\FertilizerLicenseItem;
use Illuminate\Database\Seeder;

class FertilizerLicenseSeeder extends Seeder
{
    public function run(): void
    {
        FertilizerDistributionLicense::factory()
            ->count(5)
            ->has(
                FertilizerLicenseItem::factory()->count(3)->state(function (array $attributes, FertilizerDistributionLicense $license) {
                    return [
                        'fertilizer_name'  => fake()->randomElement(['ယူရီးယား', 'ကွန်ပေါင်း', 'Gypsum']),
                        'chemical_formula' => fake()->randomElement(['N-46%', '15:7:8', 'Ca-23%, S-18%']),
                        'fertilizer_type'  => fake()->randomElement(['ဩဘာ', 'တက်တိုး', 'အာမို']),
                        'weight_volume'    => '50kg',
                    ];
                }),
                'items'
            )
            ->create();
    }
}