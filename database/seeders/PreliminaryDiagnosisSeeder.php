<?php

namespace Database\Seeders;

use App\Models\PreliminaryDiagnosis;
use Illuminate\Database\Seeder;

class PreliminaryDiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preliminaryDiagnoses = [
            // التشخيصات المبدئية للجهاز الهضمي
            ['name_ar' => 'قلاعات للدراسة', 'name_en' => 'Oral Thrush for Study', 'category' => 'هضمي - المريء'],
            ['name_ar' => 'عسر بلع للدراسة', 'name_en' => 'Dysphagia for Study', 'category' => 'هضمي - المريء'],
            ['name_ar' => 'شك قلس مريئي', 'name_en' => 'Suspected GERD', 'category' => 'هضمي - المريء'],
            ['name_ar' => 'عسر هضم للدراسة', 'name_en' => 'Dyspepsia for Study', 'category' => 'هضمي - المعدة'],
            ['name_ar' => 'فقر دم للدراسة', 'name_en' => 'Anemia for Study', 'category' => 'هضمي - عام'],
            ['name_ar' => 'نزف هضمي للدراسة', 'name_en' => 'GI Bleeding for Study', 'category' => 'هضمي - عام'],
            ['name_ar' => 'شك سوء امتصاص', 'name_en' => 'Suspected Malabsorption', 'category' => 'هضمي - الأمعاء'],
            ['name_ar' => 'شك داء معوي التهابي', 'name_en' => 'Suspected IBD', 'category' => 'هضمي - الأمعاء'],
            ['name_ar' => 'تشنج كولون للدراسة', 'name_en' => 'IBS for Study', 'category' => 'هضمي - الكولون'],
            ['name_ar' => 'إسهال مزمن للدراسة', 'name_en' => 'Chronic Diarrhea for Study', 'category' => 'هضمي - الأمعاء'],
            ['name_ar' => 'شك انسداد أمعاء', 'name_en' => 'Suspected Bowel Obstruction', 'category' => 'هضمي - الأمعاء'],
            ['name_ar' => 'شك بطن حاد', 'name_en' => 'Suspected Acute Abdomen', 'category' => 'هضمي - عام'],
            ['name_ar' => 'حبن للدراسة', 'name_en' => 'Ascites for Study', 'category' => 'هضمي - الكبد'],
            ['name_ar' => 'ارتفاع خمائر كبد للدراسة', 'name_en' => 'Elevated Liver Enzymes for Study', 'category' => 'هضمي - الكبد'],
            ['name_ar' => 'التهاب كبد للدراسة', 'name_en' => 'Hepatitis for Study', 'category' => 'هضمي - الكبد'],
            ['name_ar' => 'شك تشمع كبد', 'name_en' => 'Suspected Liver Cirrhosis', 'category' => 'هضمي - الكبد'],
            ['name_ar' => 'كتل كبد للدراسة', 'name_en' => 'Liver Masses for Study', 'category' => 'هضمي - الكبد'],
            ['name_ar' => 'انسداد صفراوي للدراسة', 'name_en' => 'Biliary Obstruction for Study', 'category' => 'هضمي - الطرق الصفراوية'],
        ];

        foreach ($preliminaryDiagnoses as $diagnosis) {
            PreliminaryDiagnosis::create($diagnosis + ['is_active' => true]);
        }
    }
}
