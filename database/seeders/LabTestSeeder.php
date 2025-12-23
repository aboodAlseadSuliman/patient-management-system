<?php

namespace Database\Seeders;

use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            [
                'name_ar' => 'سكر صائم',
                'name_en' => 'Fasting Blood Sugar',
                'abbreviation' => 'FBS',
                'category' => 'blood',
                'normal_range' => '70-110 mg/dl',
                'unit' => 'mg/dl',
            ],
            [
                'name_ar' => 'تعداد دم شامل',
                'name_en' => 'Complete Blood Count',
                'abbreviation' => 'CBC',
                'category' => 'blood',
            ],
            [
                'name_ar' => 'بولة',
                'name_en' => 'Urea',
                'abbreviation' => 'Urea',
                'category' => 'blood',
                'normal_range' => '15-40 mg/dl',
                'unit' => 'mg/dl',
            ],
            [
                'name_ar' => 'كرياتينين',
                'name_en' => 'Creatinine',
                'abbreviation' => 'Cr',
                'category' => 'blood',
                'normal_range' => '0.6-1.2 mg/dl',
                'unit' => 'mg/dl',
            ],
            [
                'name_ar' => 'وظائف كبد',
                'name_en' => 'Liver Function Test',
                'abbreviation' => 'LFT',
                'category' => 'blood',
            ],
            [
                'name_ar' => 'وظائف كلى',
                'name_en' => 'Kidney Function Test',
                'abbreviation' => 'KFT',
                'category' => 'blood',
            ],
            [
                'name_ar' => 'وظائف غدة درقية',
                'name_en' => 'Thyroid Function Test',
                'abbreviation' => 'TFT',
                'category' => 'blood',
            ],
            [
                'name_ar' => 'تحليل بول',
                'name_en' => 'Urine Analysis',
                'abbreviation' => 'U/A',
                'category' => 'urine',
            ],
            [
                'name_ar' => 'تحليل براز',
                'name_en' => 'Stool Analysis',
                'abbreviation' => 'S/A',
                'category' => 'stool',
            ],
            [
                'name_ar' => 'سكر تراكمي',
                'name_en' => 'HbA1c',
                'abbreviation' => 'HbA1c',
                'category' => 'blood',
                'normal_range' => '< 5.7%',
                'unit' => '%',
            ],
        ];

        foreach ($tests as $test) {
            LabTest::create($test);
        }
    }
}
