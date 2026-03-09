<?php

namespace Database\Seeders;

use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            // ==================== 1. تعداد الدم ====================
            ['name_ar' => 'تعداد دم شامل',            'name_en' => 'Complete Blood Count',                    'abbreviation' => 'CBC',                   'category' => 'blood'],
            ['name_ar' => 'شبكيات',                   'name_en' => 'Reticulocytes',                           'abbreviation' => 'Retic',                 'category' => 'blood'],
            ['name_ar' => 'لطاخة محيطية',             'name_en' => 'Peripheral Blood Smear',                  'abbreviation' => 'PBS',                   'category' => 'blood'],

            // ==================== 2. المشعرات الالتهابية ====================
            ['name_ar' => 'سرعة ترسب الكريات',       'name_en' => 'Erythrocyte Sedimentation Rate',          'abbreviation' => 'ESR',                   'category' => 'blood', 'unit' => 'mm/hr'],
            ['name_ar' => 'بروتين سي التفاعلي',       'name_en' => 'C-Reactive Protein',                      'abbreviation' => 'CRP',                   'category' => 'blood', 'unit' => 'mg/L'],
            ['name_ar' => 'بروكالسيتونين',            'name_en' => 'Procalcitonin',                           'abbreviation' => 'PCT',                   'category' => 'blood', 'unit' => 'ng/mL'],

            // ==================== 3. المشعرات الانحلالية ====================
            ['name_ar' => 'نازعة هيدروجين اللاكتات',  'name_en' => 'Lactate Dehydrogenase',                  'abbreviation' => 'LDH',                   'category' => 'blood', 'unit' => 'U/L'],
            ['name_ar' => 'كرياتين فوسفوكيناز',       'name_en' => 'Creatine Phosphokinase',                  'abbreviation' => 'CPK',                   'category' => 'blood', 'unit' => 'U/L'],
            ['name_ar' => 'د-ثنائي',                  'name_en' => 'D-Dimer',                                 'abbreviation' => 'D-Dimer',               'category' => 'blood', 'unit' => 'mg/L FEU'],

            // ==================== 4. تحاليل التخثر ====================
            ['name_ar' => 'زمن البروثرومبين',         'name_en' => 'Prothrombin Time',                        'abbreviation' => 'PT',                    'category' => 'blood', 'unit' => 'sec', 'normal_range' => '11-13.5 sec'],
            ['name_ar' => 'زمن الثرومبوبلاستين الجزئي', 'name_en' => 'Partial Thromboplastin Time',          'abbreviation' => 'PTT',                   'category' => 'blood', 'unit' => 'sec', 'normal_range' => '25-35 sec'],

            // ==================== 5. خمائر الكبد ====================
            ['name_ar' => 'ألانين أمينوترانسفيراز',   'name_en' => 'Alanine Aminotransferase',                'abbreviation' => 'ALT',                   'category' => 'blood', 'unit' => 'U/L', 'normal_range' => '7-56 U/L'],
            ['name_ar' => 'أسبارتات أمينوترانسفيراز', 'name_en' => 'Aspartate Aminotransferase',              'abbreviation' => 'AST',                   'category' => 'blood', 'unit' => 'U/L', 'normal_range' => '10-40 U/L'],
            ['name_ar' => 'بيليروبين',                'name_en' => 'Bilirubin (Total/Direct/Indirect)',        'abbreviation' => 'Bili',                  'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'فوسفاتاز القلوية',         'name_en' => 'Alkaline Phosphatase',                    'abbreviation' => 'ALP',                   'category' => 'blood', 'unit' => 'U/L', 'normal_range' => '44-147 U/L'],
            ['name_ar' => 'غاما غلوتاميل ترانسفيراز', 'name_en' => 'Gamma-Glutamyl Transferase',              'abbreviation' => 'GGT',                   'category' => 'blood', 'unit' => 'U/L'],

            // ==================== 6. البروتينات ====================
            ['name_ar' => 'بروتين كلي',               'name_en' => 'Total Protein',                           'abbreviation' => 'TP',                    'category' => 'blood', 'unit' => 'g/dL', 'normal_range' => '6-8 g/dL'],
            ['name_ar' => 'ألبومين',                  'name_en' => 'Albumin',                                 'abbreviation' => 'Alb',                   'category' => 'blood', 'unit' => 'g/dL', 'normal_range' => '3.5-5 g/dL'],
            ['name_ar' => 'رحلان بروتينات',           'name_en' => 'Protein Electrophoresis',                 'abbreviation' => 'SPEP',                  'category' => 'blood'],
            ['name_ar' => 'إيمونوغلوبولين م',         'name_en' => 'Immunoglobulin M',                        'abbreviation' => 'IgM',                   'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'إيمونوغلوبولين ج',         'name_en' => 'Immunoglobulin G',                        'abbreviation' => 'IgG',                   'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'إيمونوغلوبولين أ',         'name_en' => 'Immunoglobulin A',                        'abbreviation' => 'IgA',                   'category' => 'blood', 'unit' => 'mg/dL'],

            // ==================== 7. الداء الزلاقي ====================
            ['name_ar' => 'أضداد ترانسغلوتاميناز IgA', 'name_en' => 'Anti-tTG IgA',                         'abbreviation' => 'Anti-tTG IgA',          'category' => 'blood'],
            ['name_ar' => 'أضداد الغليادين المشوه IgG', 'name_en' => 'Anti-DGP IgG',                         'abbreviation' => 'Anti-DGP IgG',          'category' => 'blood'],
            ['name_ar' => 'أضداد الشغاف IgA',         'name_en' => 'Anti-Endomysial Antibody IgA',            'abbreviation' => 'Anti-EMA IgA',          'category' => 'blood'],
            ['name_ar' => 'HLA DQ2/DQ8',              'name_en' => 'HLA-DQ2/DQ8 Genotyping',                  'abbreviation' => 'HLA-DQ2/DQ8',           'category' => 'blood'],

            // ==================== 8. تحاليل الكليتين ====================
            ['name_ar' => 'بولة',                     'name_en' => 'Urea',                                    'abbreviation' => 'Urea',                  'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '15-40 mg/dL'],
            ['name_ar' => 'كرياتينين',                'name_en' => 'Creatinine',                              'abbreviation' => 'Cr',                    'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '0.6-1.2 mg/dL'],
            ['name_ar' => 'شوارد الدم',               'name_en' => 'Electrolytes (Na/K/Cl)',                   'abbreviation' => 'Elec',                  'category' => 'blood', 'unit' => 'mEq/L'],
            ['name_ar' => 'تحليل بول وراسب',          'name_en' => 'Urinalysis with Sediment',                 'abbreviation' => 'U/A',                   'category' => 'urine'],
            ['name_ar' => 'زرع بول وتحسس',            'name_en' => 'Urine Culture & Sensitivity',              'abbreviation' => 'UC&S',                  'category' => 'urine'],

            // ==================== 9. فيروسات الكبد ====================
            ['name_ar' => 'فيروس الكبد أ IgM',        'name_en' => 'Hepatitis A Virus IgM',                   'abbreviation' => 'HAV IgM',               'category' => 'blood'],
            ['name_ar' => 'مستضد سطح الكبد B',        'name_en' => 'Hepatitis B Surface Antigen',              'abbreviation' => 'HBs Ag',                'category' => 'blood'],
            ['name_ar' => 'أضداد القلب B IgM',        'name_en' => 'Anti-HBc IgM',                            'abbreviation' => 'Anti-HBc IgM',          'category' => 'blood'],
            ['name_ar' => 'مستضد e الكبد B',          'name_en' => 'Hepatitis B e Antigen',                    'abbreviation' => 'HBe Ag',                'category' => 'blood'],
            ['name_ar' => 'حمض نووي فيروس الكبد B',  'name_en' => 'HBV DNA PCR',                              'abbreviation' => 'HBV DNA',               'category' => 'blood', 'unit' => 'IU/mL'],
            ['name_ar' => 'أضداد فيروس الكبد C',      'name_en' => 'Anti-HCV Antibody',                       'abbreviation' => 'Anti-HCV',              'category' => 'blood'],
            ['name_ar' => 'حمض نووي فيروس الكبد C',  'name_en' => 'HCV RNA PCR',                              'abbreviation' => 'HCV RNA',               'category' => 'blood', 'unit' => 'IU/mL'],
            ['name_ar' => 'نمط فيروس الكبد C',        'name_en' => 'HCV Genotyping',                           'abbreviation' => 'HCV GT',                'category' => 'blood'],

            // ==================== 10. التحاليل الجرثومية ====================
            ['name_ar' => 'تفاعل فيدال',              'name_en' => 'Widal Test (Typhoid)',                     'abbreviation' => 'Widal',                 'category' => 'blood'],
            ['name_ar' => 'تفاعل رايت',               'name_en' => 'Brucella Agglutination Test',              'abbreviation' => 'Wright',                'category' => 'blood'],
            ['name_ar' => 'أضداد الجرثومة الحلزونية', 'name_en' => 'Helicobacter pylori Antibody',             'abbreviation' => 'HP Ab',                 'category' => 'blood'],
            ['name_ar' => 'أضداد المشوكة',            'name_en' => 'Anti-Echinococcus Antibody',               'abbreviation' => 'Anti-Echi',             'category' => 'blood'],

            // ==================== 11. مناعيات الكبد ====================
            ['name_ar' => 'أضداد النوى',              'name_en' => 'Anti-Nuclear Antibody',                    'abbreviation' => 'ANA',                   'category' => 'blood'],
            ['name_ar' => 'أضداد العضلة الملساء',     'name_en' => 'Anti-Smooth Muscle Antibody',              'abbreviation' => 'ASMA',                  'category' => 'blood'],
            ['name_ar' => 'أضداد الميتوكوندريا',      'name_en' => 'Anti-Mitochondrial Antibody',              'abbreviation' => 'AMA',                   'category' => 'blood'],
            ['name_ar' => 'إيمونوغلوبولين G4',        'name_en' => 'Immunoglobulin G4',                        'abbreviation' => 'IgG4',                  'category' => 'blood', 'unit' => 'mg/dL'],

            // ==================== 13. داء ويلسون ====================
            ['name_ar' => 'سيرولوبلازمين',            'name_en' => 'Ceruloplasmin',                            'abbreviation' => 'Cerul',                 'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'نحاس بول 24 ساعة',         'name_en' => '24-hour Urine Copper',                     'abbreviation' => 'Cu-Urine',              'category' => 'urine', 'unit' => 'μg/24hr'],

            // ==================== 14. التحاليل الاستقلابية ====================
            ['name_ar' => 'سكر الدم',                 'name_en' => 'Blood Glucose',                            'abbreviation' => 'GLU',                   'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '70-110 mg/dL'],
            ['name_ar' => 'سكر تراكمي',               'name_en' => 'Glycated Hemoglobin',                      'abbreviation' => 'HbA1C',                 'category' => 'blood', 'unit' => '%', 'normal_range' => '< 5.7%'],
            ['name_ar' => 'كوليسترول كلي',            'name_en' => 'Total Cholesterol',                        'abbreviation' => 'Chol',                  'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '< 200 mg/dL'],
            ['name_ar' => 'كوليسترول LDL / HDL',      'name_en' => 'LDL / HDL Cholesterol',                    'abbreviation' => 'LDL/HDL',               'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'ثلاثيات الغليسيريد',       'name_en' => 'Triglycerides',                            'abbreviation' => 'TG',                    'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '< 150 mg/dL'],
            ['name_ar' => 'حمض البول',                'name_en' => 'Uric Acid',                                'abbreviation' => 'UA',                    'category' => 'blood', 'unit' => 'mg/dL'],

            // ==================== 15. الهرمونات ====================
            ['name_ar' => 'هرمون محفز الغدة الدرقية', 'name_en' => 'Thyroid Stimulating Hormone',              'abbreviation' => 'TSH',                   'category' => 'blood', 'unit' => 'mIU/L'],
            ['name_ar' => 'ثيروكسين حر',              'name_en' => 'Free Thyroxine',                           'abbreviation' => 'FT4',                   'category' => 'blood', 'unit' => 'ng/dL'],
            ['name_ar' => 'هرمون الغدة جارة الدرق',  'name_en' => 'Parathyroid Hormone',                      'abbreviation' => 'PTH',                   'category' => 'blood', 'unit' => 'pg/mL'],
            ['name_ar' => 'كورتيزول الساعة 8 صباحاً', 'name_en' => 'Morning Cortisol (8 AM)',                  'abbreviation' => 'Cortisol',              'category' => 'blood', 'unit' => 'μg/dL'],

            // ==================== 16. الفيتامينات والمعادن ====================
            ['name_ar' => 'حديد مصل',                 'name_en' => 'Serum Iron',                               'abbreviation' => 'Fe',                    'category' => 'blood', 'unit' => 'μg/dL'],
            ['name_ar' => 'طاقة ربط الحديد الكلية',   'name_en' => 'Total Iron Binding Capacity',              'abbreviation' => 'TIBC',                  'category' => 'blood', 'unit' => 'μg/dL'],
            ['name_ar' => 'فيريتين',                  'name_en' => 'Ferritin',                                 'abbreviation' => 'Ferritin',              'category' => 'blood', 'unit' => 'ng/mL'],
            ['name_ar' => 'فيتامين B12',              'name_en' => 'Vitamin B12',                              'abbreviation' => 'B12',                   'category' => 'blood', 'unit' => 'pg/mL'],

            // ==================== 17. التحاليل العظمية ====================
            ['name_ar' => 'كالسيوم',                  'name_en' => 'Calcium',                                  'abbreviation' => 'Ca',                    'category' => 'blood', 'unit' => 'mg/dL', 'normal_range' => '8.5-10.5 mg/dL'],
            ['name_ar' => 'فوسفور',                   'name_en' => 'Phosphorus',                               'abbreviation' => 'P',                     'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'مغنيزيوم',                 'name_en' => 'Magnesium',                                'abbreviation' => 'Mg',                    'category' => 'blood', 'unit' => 'mg/dL'],
            ['name_ar' => 'فيتامين د 25-هيدروكسي',   'name_en' => '25-OH Vitamin D',                          'abbreviation' => '25OH-VitD',             'category' => 'blood', 'unit' => 'ng/mL'],

            // ==================== 18. فحوص البراز ====================
            ['name_ar' => 'فحص براز',                 'name_en' => 'Stool Examination',                        'abbreviation' => 'S/E',                   'category' => 'stool'],
            ['name_ar' => 'دم خفي بالبراز',           'name_en' => 'Fecal Occult Blood Test',                  'abbreviation' => 'FOBT',                  'category' => 'stool'],
            ['name_ar' => 'كالبروتكتين براز',         'name_en' => 'Fecal Calprotectin',                       'abbreviation' => 'FCP',                   'category' => 'stool', 'unit' => 'μg/g'],
            ['name_ar' => 'توكسين كلوستريديوم A,B',   'name_en' => 'C. Difficile Toxin A & B',                 'abbreviation' => 'C.Diff A,B',            'category' => 'stool'],
            ['name_ar' => 'مستضد الجرثومة الحلزونية براز', 'name_en' => 'H. pylori Stool Antigen',             'abbreviation' => 'HP Stool Ag',           'category' => 'stool'],
        ];

        foreach ($tests as $test) {
            LabTest::create($test + ['is_active' => true, 'usage_count' => 0]);
        }
    }
}
