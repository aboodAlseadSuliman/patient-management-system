<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class AppointmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name_ar' => 'عيادة',
                'name_en' => 'Clinic',
                'slug' => 'clinic',
                'description' => 'مواعيد العيادة الخارجية',
                'color' => 'info',
                'icon' => 'heroicon-o-building-office',
            ],
            [
                'name_ar' => 'مشفى',
                'name_en' => 'Hospital',
                'slug' => 'hospital',
                'description' => 'مواعيد المشفى والعمليات',
                'color' => 'success',
                'icon' => 'heroicon-o-building-office-2',
            ],
            [
                'name_ar' => 'تنظير',
                'name_en' => 'Endoscopy',
                'slug' => 'endoscopy',
                'description' => 'مواعيد التنظير والفحوصات الخاصة',
                'color' => 'warning',
                'icon' => 'heroicon-o-beaker',
            ],
            [
                'name_ar' => 'استشارة عن بعد',
                'name_en' => 'Telemedicine',
                'slug' => 'telemedicine',
                'description' => 'استشارات طبية عبر الهاتف أو الفيديو',
                'color' => 'primary',
                'icon' => 'heroicon-o-phone',
            ],
            [
                'name_ar' => 'متابعة',
                'name_en' => 'Follow-up',
                'slug' => 'followup',
                'description' => 'مواعيد المتابعة الدورية',
                'color' => 'gray',
                'icon' => 'heroicon-o-arrow-path',
            ],
        ];

        foreach ($types as $type) {
            AppointmentType::create($type);
        }
    }
}
