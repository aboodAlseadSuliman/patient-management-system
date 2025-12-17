<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'مدير النظام',
                'description' => 'صلاحيات كاملة على النظام',
                'is_active' => true,
            ],
            [
                'name' => 'doctor',
                'display_name' => 'طبيب',
                'description' => 'إدارة المرضى والزيارات والتشخيصات',
                'is_active' => true,
            ],
            [
                'name' => 'staff',
                'display_name' => 'موظف استقبال',
                'description' => 'إدخال بيانات المرضى والمواعيد فقط',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
