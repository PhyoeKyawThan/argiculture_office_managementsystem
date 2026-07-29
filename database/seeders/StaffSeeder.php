<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffLog;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff1 = Staff::withoutEvents(fn () => Staff::updateOrCreate(
            ['personal_no' => 'AGRI-2026-001'],
            [
                'name' => 'Ma Thae Thae',
                'gender' => 'female',
                'date_of_birth' => '1998-05-12',
                'first_joining_date' => '2022-01-15',
                'current_position' => 'Assistant Director',
                'current_position_joining_date' => '2025-06-01',
                'assigned_position' => 'Regional Supervisor',
                'current_region' => 'Yangon Region',
                'current_office' => 'Hlegu Township Office',
                'current_branch' => 'Crop Administration & Records',
                'education_level' => 'Bachelor of Agricultural Science (B.Agr.Sc)',
                'is_married' => true,
            ]
        ));

        if ($staff1->logs()->count() === 0) {
            StaffLog::create([
                'staff_id' => $staff1->id,
                'action' => 'created',
                'changes' => [
                    'initial_snapshot' => [
                        'personal_no' => $staff1->personal_no,
                        'name' => $staff1->name,
                        'current_position' => 'Junior Officer',
                        'current_office' => 'Hmawbi Office',
                    ],
                ],
                'created_at' => '2022-01-15 09:00:00',
            ]);

            StaffLog::create([
                'staff_id' => $staff1->id,
                'action' => 'updated_profile',
                'changes' => ['is_married' => ['old' => false, 'new' => true]],
                'created_at' => '2023-11-20 10:30:00',
            ]);

            StaffLog::create([
                'staff_id' => $staff1->id,
                'action' => 'transferred',
                'changes' => [
                    'current_office' => ['old' => 'Hmawbi Office', 'new' => 'Hlegu Township Office'],
                    'current_branch' => ['old' => 'General Logistics', 'new' => 'Crop Administration & Records'],
                ],
                'created_at' => '2024-04-01 08:00:00',
            ]);

            StaffLog::create([
                'staff_id' => $staff1->id,
                'action' => 'promoted_demoted',
                'changes' => [
                    'current_position' => ['old' => 'Junior Officer', 'new' => 'Assistant Director'],
                    'current_position_joining_date' => ['old' => '2022-01-15', 'new' => '2025-06-01'],
                ],
                'created_at' => '2025-06-01 09:00:00',
            ]);
        }

        $staff2 = Staff::withoutEvents(fn () => Staff::updateOrCreate(
            ['personal_no' => 'AGRI-2026-002'],
            [
                'name' => 'Ma Hnin Hnin Wai',
                'gender' => 'female',
                'date_of_birth' => '1999-09-25',
                'first_joining_date' => '2023-03-10',
                'current_position' => 'Data Analyst',
                'current_position_joining_date' => '2023-03-10',
                'assigned_position' => 'Database Administrator',
                'current_region' => 'Mandalay Region',
                'current_office' => 'Regional Head Office',
                'current_branch' => 'Information Technology & Statistics',
                'education_level' => 'B.C.Sc (Computer Science)',
                'is_married' => false,
            ]
        ));

        if ($staff2->logs()->count() === 0) {
            StaffLog::create([
                'staff_id' => $staff2->id,
                'action' => 'created',
                'changes' => [
                    'initial_snapshot' => [
                        'personal_no' => $staff2->personal_no,
                        'name' => $staff2->name,
                        'current_position' => $staff2->current_position,
                        'current_office' => $staff2->current_office,
                    ],
                ],
                'created_at' => '2023-03-10 09:15:00',
            ]);
        }

        $staff3 = Staff::withoutEvents(fn () => Staff::updateOrCreate(
            ['personal_no' => 'AGRI-2026-003'],
            [
                'name' => 'U Thura Aung',
                'gender' => 'male',
                'date_of_birth' => '1985-02-14',
                'first_joining_date' => '2015-08-01',
                'current_position' => 'Senior Field Inspector',
                'current_position_joining_date' => '2021-02-01',
                'assigned_position' => 'Equipment Manager',
                'current_region' => 'Naypyitaw Union Territory',
                'current_office' => 'Central Seed Inspection Sub-office',
                'current_branch' => 'Equipment and Resource Tracking',
                'education_level' => 'Diploma in Agriculture',
                'is_married' => true,
            ]
        ));

        if ($staff3->logs()->count() === 0) {
            StaffLog::create([
                'staff_id' => $staff3->id,
                'action' => 'created',
                'changes' => [
                    'initial_snapshot' => [
                        'personal_no' => $staff3->personal_no,
                        'name' => $staff3->name,
                    ],
                ],
                'created_at' => '2015-08-01 10:00:00',
            ]);
        }
    }
}
