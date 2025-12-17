<?php

namespace Database\Seeders;

use App\Models\ChronicDisease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChronicDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            ['name_ar' => 'السكري', 'name_en' => 'Diabetes Mellitus', 'abbreviation' => 'DM', 'icd_code' => 'E11'],
            ['name_ar' => 'ضغط الدم المرتفع', 'name_en' => 'Hypertension', 'abbreviation' => 'HTN', 'icd_code' => 'I10'],
            ['name_ar' => 'الربو', 'name_en' => 'Asthma', 'abbreviation' => 'Asthma', 'icd_code' => 'J45'],
            ['name_ar' => 'أمراض القلب', 'name_en' => 'Heart Disease', 'abbreviation' => 'HD', 'icd_code' => 'I51'],
            ['name_ar' => 'الكولسترول المرتفع', 'name_en' => 'Hyperlipidemia', 'abbreviation' => 'HLD', 'icd_code' => 'E78'],
            ['name_ar' => 'الفشل الكلوي المزمن', 'name_en' => 'Chronic Kidney Disease', 'abbreviation' => 'CKD', 'icd_code' => 'N18'],
            ['name_ar' => 'التهاب المفاصل الروماتيزمي', 'name_en' => 'Rheumatoid Arthritis', 'abbreviation' => 'RA', 'icd_code' => 'M06'],
            ['name_ar' => 'هشاشة العظام', 'name_en' => 'Osteoporosis', 'abbreviation' => 'OP', 'icd_code' => 'M81'],
            ['name_ar' => 'الغدة الدرقية', 'name_en' => 'Thyroid Disease', 'abbreviation' => 'TD', 'icd_code' => 'E07'],
            ['name_ar' => 'الصرع', 'name_en' => 'Epilepsy', 'abbreviation' => 'EP', 'icd_code' => 'G40'],
            ['name_ar' => 'الاكتئاب', 'name_en' => 'Depression', 'abbreviation' => 'Dep', 'icd_code' => 'F32'],
            ['name_ar' => 'القولون العصبي', 'name_en' => 'IBS', 'abbreviation' => 'IBS', 'icd_code' => 'K58'],
            ['name_ar' => 'الأنيميا المزمنة', 'name_en' => 'Chronic Anemia', 'abbreviation' => 'CA', 'icd_code' => 'D50'],
            ['name_ar' => 'الصدفية', 'name_en' => 'Psoriasis', 'abbreviation' => 'Ps', 'icd_code' => 'L40'],
            ['name_ar' => 'الشقيقة المزمنة', 'name_en' => 'Chronic Migraine', 'abbreviation' => 'CM', 'icd_code' => 'G43'],
            ['name_ar' => 'التهاب الكبد المزمن', 'name_en' => 'Chronic Hepatitis', 'abbreviation' => 'CH', 'icd_code' => 'K73'],
            ['name_ar' => 'مرض كرون', 'name_en' => 'Crohn\'s Disease', 'abbreviation' => 'CD', 'icd_code' => 'K50'],
            ['name_ar' => 'التهاب القولون التقرحي', 'name_en' => 'Ulcerative Colitis', 'abbreviation' => 'UC', 'icd_code' => 'K51'],
            ['name_ar' => 'الذئبة الحمراء', 'name_en' => 'Lupus', 'abbreviation' => 'SLE', 'icd_code' => 'M32'],
            ['name_ar' => 'النقرس', 'name_en' => 'Gout', 'abbreviation' => 'Gout', 'icd_code' => 'M10'],
            ['name_ar' => 'انقطاع النفس النومي', 'name_en' => 'Sleep Apnea', 'abbreviation' => 'SA', 'icd_code' => 'G47'],
            ['name_ar' => 'البروستاتا', 'name_en' => 'Prostate Disease', 'abbreviation' => 'PD', 'icd_code' => 'N40'],
            ['name_ar' => 'الجلوكوما', 'name_en' => 'Glaucoma', 'abbreviation' => 'Glau', 'icd_code' => 'H40'],
            ['name_ar' => 'البهاق', 'name_en' => 'Vitiligo', 'abbreviation' => 'Vit', 'icd_code' => 'L80'],
            ['name_ar' => 'السمنة المفرطة', 'name_en' => 'Obesity', 'abbreviation' => 'Ob', 'icd_code' => 'E66'],
        ];

        foreach ($diseases as $disease) {
            ChronicDisease::create($disease + ['is_active' => true]);
        }
    }
}
