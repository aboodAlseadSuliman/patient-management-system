<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // admin
                'phone' => '0501234567',
                'is_active' => true,
            ],
            [
                'name' => 'د. أحمد محمد',
                'email' => 'doctor1@clinic.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // doctor
                'phone' => '0507654321',
                'is_active' => true,
            ],
            [
                'name' => 'د. فاطمة علي',
                'email' => 'doctor2@clinic.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // doctor
                'phone' => '0551234567',
                'is_active' => true,
            ],
            [
                'name' => 'محمد الموظف',
                'email' => 'staff1@clinic.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // staff
                'phone' => '0559876543',
                'is_active' => true,
            ],
            [
                'name' => 'نورة الموظفة',
                'email' => 'staff2@clinic.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // staff
                'phone' => '0541234567',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
