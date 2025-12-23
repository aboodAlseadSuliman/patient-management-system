<?php

namespace Database\Seeders;

use App\Models\ImagingStudy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImagingStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studies = [
            ['name_ar' => 'أشعة صدر', 'name_en' => 'Chest X-Ray', 'abbreviation' => 'CXR', 'type' => 'x-ray', 'body_part' => 'صدر'],
            ['name_ar' => 'إيكو بطن', 'name_en' => 'Abdominal US', 'type' => 'ultrasound', 'body_part' => 'بطن'],
            ['name_ar' => 'CT دماغ', 'name_en' => 'Brain CT', 'type' => 'ct', 'body_part' => 'رأس'],
            ['name_ar' => 'دوبلر أوعية', 'name_en' => 'Vascular Doppler', 'type' => 'doppler'],
            ['name_ar' => 'إيكو قلب', 'name_en' => 'Echocardiography', 'type' => 'ultrasound', 'body_part' => 'قلب'],
            ['name_ar' => 'MRI عمود فقري', 'name_en' => 'Spine MRI', 'type' => 'mri', 'body_part' => 'عمود فقري'],
        ];

        foreach ($studies as $studie) {
            ImagingStudy::create($studie);
        }
    }
}
