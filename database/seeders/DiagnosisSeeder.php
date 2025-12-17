<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diagnoses = [
            ['name_ar' => 'نزلة برد', 'name_en' => 'Common Cold', 'category' => 'تنفسي'],
            ['name_ar' => 'التهاب الحلق', 'name_en' => 'Pharyngitis', 'category' => 'تنفسي'],
            ['name_ar' => 'التهاب اللوزتين', 'name_en' => 'Tonsillitis', 'category' => 'تنفسي'],
            ['name_ar' => 'التهاب الجيوب الأنفية', 'name_en' => 'Sinusitis', 'category' => 'تنفسي'],
            ['name_ar' => 'التهاب الشعب الهوائية', 'name_en' => 'Bronchitis', 'category' => 'تنفسي'],
            ['name_ar' => 'التهاب رئوي', 'name_en' => 'Pneumonia', 'category' => 'تنفسي'],

            ['name_ar' => 'التهاب المعدة', 'name_en' => 'Gastritis', 'category' => 'هضمي'],
            ['name_ar' => 'عسر الهضم', 'name_en' => 'Dyspepsia', 'category' => 'هضمي'],
            ['name_ar' => 'إسهال حاد', 'name_en' => 'Acute Diarrhea', 'category' => 'هضمي'],
            ['name_ar' => 'إمساك', 'name_en' => 'Constipation', 'category' => 'هضمي'],
            ['name_ar' => 'ارتجاع المريء', 'name_en' => 'GERD', 'category' => 'هضمي'],
            ['name_ar' => 'قرحة المعدة', 'name_en' => 'Gastric Ulcer', 'category' => 'هضمي'],

            ['name_ar' => 'صداع نصفي', 'name_en' => 'Migraine', 'category' => 'عصبي'],
            ['name_ar' => 'صداع توتري', 'name_en' => 'Tension Headache', 'category' => 'عصبي'],
            ['name_ar' => 'دوار', 'name_en' => 'Vertigo', 'category' => 'عصبي'],

            ['name_ar' => 'ألم أسفل الظهر', 'name_en' => 'Lower Back Pain', 'category' => 'عضلي'],
            ['name_ar' => 'ألم الرقبة', 'name_en' => 'Neck Pain', 'category' => 'عضلي'],
            ['name_ar' => 'التهاب المفاصل', 'name_en' => 'Arthritis', 'category' => 'عضلي'],

            ['name_ar' => 'التهاب المسالك البولية', 'name_en' => 'UTI', 'category' => 'بولي'],
            ['name_ar' => 'حصى الكلى', 'name_en' => 'Kidney Stones', 'category' => 'بولي'],

            ['name_ar' => 'أكزيما', 'name_en' => 'Eczema', 'category' => 'جلدي'],
            ['name_ar' => 'حساسية جلدية', 'name_en' => 'Skin Allergy', 'category' => 'جلدي'],
            ['name_ar' => 'فطريات', 'name_en' => 'Fungal Infection', 'category' => 'جلدي'],

            ['name_ar' => 'أنيميا', 'name_en' => 'Anemia', 'category' => 'دم'],
            ['name_ar' => 'نقص فيتامين د', 'name_en' => 'Vitamin D Deficiency', 'category' => 'تغذية'],
            ['name_ar' => 'نقص فيتامين ب12', 'name_en' => 'Vitamin B12 Deficiency', 'category' => 'تغذية'],

            ['name_ar' => 'قلق', 'name_en' => 'Anxiety', 'category' => 'نفسي'],
            ['name_ar' => 'أرق', 'name_en' => 'Insomnia', 'category' => 'نفسي'],

            ['name_ar' => 'حمى', 'name_en' => 'Fever', 'category' => 'عام'],
            ['name_ar' => 'إعياء عام', 'name_en' => 'General Fatigue', 'category' => 'عام'],
        ];

        foreach ($diagnoses as $diagnosis) {
            Diagnosis::create($diagnosis + ['is_active' => true, 'usage_count' => 0]);
        }
    }
}
