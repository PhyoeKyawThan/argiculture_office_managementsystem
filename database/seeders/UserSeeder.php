<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@gmail.com',
                'role' => User::ROLE_ADMIN,
                'password' => 'password',
            ],
            [
                'name' => 'Office Staff',
                'email' => 'staff@gmail.com',
                'role' => User::ROLE_STAFF,
                'password' => 'password',
            ],
            [
                'name' => 'Shop Operator',
                'email' => 'shop@gmail.com',
                'role' => User::ROLE_SHOP,
                'password' => 'password',
            ],
            [
                'name' => 'U Aung Farmer',
                'email' => 'farmer@gmail.com',
                'role' => User::ROLE_FARMER,
                'password' => 'password',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'role' => $data['role'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                ]
            );
        }

        $linkedStaff = Staff::query()->where('personal_no', 'AGRI-2026-001')->first();

        if ($linkedStaff) {
            User::query()
                ->where('email', 'staff@gmail.com')
                ->update(['staff_id' => $linkedStaff->id]);
        }
    }
}
