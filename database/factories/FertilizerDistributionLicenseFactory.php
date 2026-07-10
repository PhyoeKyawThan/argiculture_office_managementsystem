<?php

namespace Database\Factories;

use App\Models\FertilizerDistributionLicense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FertilizerDistributionLicense>
 */
class FertilizerDistributionLicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'applicant_name' => fake()->name(),
            'nrc_number' => '12/PaMaNa(N)123456',
            'application_date' => now(),
            'attachment_nrc' => json_encode(['nrc_front' => 'front.jpg', 'nrc_end' => 'back.jpg']),
            'status' => 'pending',
            'township' => 'ပုသိမ်',
        ];
    }
}
