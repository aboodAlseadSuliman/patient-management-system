<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalAbbreviation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicalAbbreviationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abbreviations = [
            // أعراض
            ['abbreviation' => 'غث', 'full_text' => 'غثيان', 'category' => 'symptom'],
            ['abbreviation' => 'قي', 'full_text' => 'قيء', 'category' => 'symptom'],
            ['abbreviation' => 'إمس', 'full_text' => 'إمساك', 'category' => 'symptom'],
            ['abbreviation' => 'إسهال', 'full_text' => 'إسهال', 'category' => 'symptom'],
            ['abbreviation' => 'صداع', 'full_text' => 'صداع', 'category' => 'symptom'],
            ['abbreviation' => 'دوار', 'full_text' => 'دوار', 'category' => 'symptom'],
            ['abbreviation' => 'سعال', 'full_text' => 'سعال', 'category' => 'symptom'],
            ['abbreviation' => 'حمى', 'full_text' => 'حمى', 'category' => 'symptom'],
            ['abbreviation' => 'ألم', 'full_text' => 'ألم', 'category' => 'symptom'],
            ['abbreviation' => 'حرارة', 'full_text' => 'ارتفاع درجة الحرارة', 'category' => 'symptom'],

            // تشخيصات
            ['abbreviation' => 'DM', 'full_text' => 'السكري', 'category' => 'diagnosis', 'language' => 'en'],
            ['abbreviation' => 'HTN', 'full_text' => 'ضغط الدم', 'category' => 'diagnosis', 'language' => 'en'],
            ['abbreviation' => 'CAD', 'full_text' => 'أمراض الشرايين', 'category' => 'diagnosis', 'language' => 'en'],
            ['abbreviation' => 'GERD', 'full_text' => 'ارتجاع المريء', 'category' => 'diagnosis', 'language' => 'en'],
            ['abbreviation' => 'UTI', 'full_text' => 'التهاب المسالك البولية', 'category' => 'diagnosis', 'language' => 'en'],

            // فحوصات
            ['abbreviation' => 'CBC', 'full_text' => 'تحليل دم شامل', 'category' => 'examination', 'language' => 'en'],
            ['abbreviation' => 'FBS', 'full_text' => 'سكر صائم', 'category' => 'examination', 'language' => 'en'],
            ['abbreviation' => 'HbA1c', 'full_text' => 'السكر التراكمي', 'category' => 'examination', 'language' => 'en'],
            ['abbreviation' => 'TSH', 'full_text' => 'الغدة الدرقية', 'category' => 'examination', 'language' => 'en'],
            ['abbreviation' => 'Cr', 'full_text' => 'الكرياتينين', 'category' => 'examination', 'language' => 'en'],

            // عام
            ['abbreviation' => 'ط', 'full_text' => 'طبيعي', 'category' => 'general'],
            ['abbreviation' => 'غ ط', 'full_text' => 'غير طبيعي', 'category' => 'general'],
            ['abbreviation' => 'م', 'full_text' => 'مرتفع', 'category' => 'general'],
            ['abbreviation' => 'منخ', 'full_text' => 'منخفض', 'category' => 'general'],
            ['abbreviation' => 'ج', 'full_text' => 'جيد', 'category' => 'general'],
            ['abbreviation' => 'ض', 'full_text' => 'ضعيف', 'category' => 'general'],
            ['abbreviation' => 'مستقر', 'full_text' => 'حالة مستقرة', 'category' => 'general'],
            ['abbreviation' => 'متحسن', 'full_text' => 'حالة متحسنة', 'category' => 'general'],
            ['abbreviation' => 'متدهور', 'full_text' => 'حالة متدهورة', 'category' => 'general'],
            ['abbreviation' => 'متابعة', 'full_text' => 'يحتاج متابعة', 'category' => 'general'],
        ];

        foreach ($abbreviations as $abbr) {
            MedicalAbbreviation::create($abbr + [
                'is_system' => true,
                'is_active' => true,
                'usage_count' => 0,
                'language' => $abbr['language'] ?? 'ar',
            ]);
        }
    }
}
