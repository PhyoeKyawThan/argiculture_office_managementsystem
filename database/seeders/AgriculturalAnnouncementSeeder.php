<?php

namespace Database\Seeders;

use App\Models\AgriculturalAnnouncement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AgriculturalAnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('role', User::ROLE_ADMIN)->first();

        if (! $author) {
            return;
        }

        $items = [
            [
                'title' => 'Monsoon Planting Advisory',
                'slug' => 'monsoon-planting-advisory',
                'category' => AgriculturalAnnouncement::CATEGORY_TIP,
                'content' => "Prepare seed beds with proper drainage.\nUse certified seeds for better yield.\nContact your township agriculture officer for soil testing support.",
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Heavy Rain Alert — Ayeyarwady Region',
                'slug' => 'heavy-rain-alert-ayeyarwady',
                'category' => AgriculturalAnnouncement::CATEGORY_WEATHER,
                'content' => "Heavy rainfall is expected over the next 48 hours.\nFarmers should secure fertilizer stores and check field drainage channels.",
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Pesticide Retail Compliance Week',
                'slug' => 'pesticide-retail-compliance-week',
                'category' => AgriculturalAnnouncement::CATEGORY_NEWS,
                'content' => "Township agriculture teams will conduct advisory visits to licensed pesticide retailers this week.",
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($items as $data) {
            AgriculturalAnnouncement::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['user_id' => $author->id])
            );
        }
    }
}
