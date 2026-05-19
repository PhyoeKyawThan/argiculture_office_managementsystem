<?php

namespace Database\Seeders;

use App\Models\LandingSection;
use Illuminate\Database\Seeder;

class LandingSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'slug' => 'hero-main',
                'type' => 'hero',
                'title' => 'AgriManage',
                'subtitle' => 'Myanmar Agriculture Office Management',
                'body' => 'Streamline staff records, regional offices, and farmer services from one unified platform built for agriculture departments.',
                'icon' => 'leaf',
                'link_url' => '/login',
                'link_label' => 'Staff Sign In',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'slug' => 'feature-staff',
                'type' => 'feature',
                'title' => 'Staff Lifecycle',
                'subtitle' => 'Complete audit trail',
                'body' => 'Track promotions, transfers, and profile updates with automatic history logging.',
                'icon' => 'users',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'feature-regions',
                'type' => 'feature',
                'title' => 'Regional Offices',
                'subtitle' => 'Multi-branch support',
                'body' => 'Manage Yangon, Mandalay, Naypyitaw and branch-level assignments in one system.',
                'icon' => 'map-pin',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'feature-reports',
                'type' => 'feature',
                'title' => 'Reports & Analytics',
                'subtitle' => 'Coming soon',
                'body' => 'Generate departmental reports and export data for planning and compliance.',
                'icon' => 'bar-chart-3',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'stat-offices',
                'type' => 'stat',
                'title' => '14+',
                'subtitle' => 'Regional Offices',
                'body' => null,
                'icon' => 'building-2',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'slug' => 'stat-staff',
                'type' => 'stat',
                'title' => '500+',
                'subtitle' => 'Staff Records',
                'body' => null,
                'icon' => 'user-check',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'stat-services',
                'type' => 'stat',
                'title' => '24/7',
                'subtitle' => 'Service Access',
                'body' => null,
                'icon' => 'clock',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'cta-contact',
                'type' => 'cta',
                'title' => 'Ready to modernize your office?',
                'subtitle' => null,
                'body' => 'Contact your regional IT branch to request access or schedule a demonstration.',
                'icon' => 'mail',
                'link_url' => 'mailto:support@agrimanage.local',
                'link_label' => 'Contact Support',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'slug' => 'footer-main',
                'type' => 'footer',
                'title' => 'AgriManage',
                'subtitle' => null,
                'body' => 'Ministry of Agriculture · Office Management System · © ' . date('Y'),
                'icon' => null,
                'sort_order' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            LandingSection::updateOrCreate(
                ['slug' => $section['slug']],
                $section
            );
        }
    }
}
