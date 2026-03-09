<?php

namespace Database\Seeders;

use App\Models\ChronicDisease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChronicDiseaseSeeder extends Seeder
{
    public function run(): void
    {
        $diseases = [
            // ==================== 1. المريء والمعدة ====================
            [
                'name_ar'      => 'تضيقات المريء',
                'name_en'      => 'Esophageal Strictures',
                'abbreviation' => 'ES',
                'icd_code'     => 'K22.2',
            ],
            [
                'name_ar'      => 'الأكالازيا',
                'name_en'      => 'Achalasia',
                'abbreviation' => 'ACH',
                'icd_code'     => 'K22.0',
            ],
            [
                'name_ar'      => 'أورام المريء والمعدة',
                'name_en'      => 'Esophageal and Gastric Tumors',
                'abbreviation' => 'EGT',
                'icd_code'     => 'C16',
            ],
            [
                'name_ar'      => 'انسداد مخرج المعدة',
                'name_en'      => 'Gastric Outlet Obstruction',
                'abbreviation' => 'GOO',
                'icd_code'     => 'K31.1',
            ],
            [
                'name_ar'      => 'التهاب المعدة الضموري',
                'name_en'      => 'Atrophic Gastritis',
                'abbreviation' => 'AG',
                'icd_code'     => 'K29.4',
            ],
            [
                'name_ar'      => 'حمى البحر المتوسط',
                'name_en'      => 'Familial Mediterranean Fever',
                'abbreviation' => 'FMF',
                'icd_code'     => 'M04.1',
            ],

            // ==================== 2. الأمعاء والكولون ====================
            [
                'name_ar'      => 'الداء الزلاقي',
                'name_en'      => 'Celiac Disease',
                'abbreviation' => 'CD',
                'icd_code'     => 'K90.0',
            ],
            [
                'name_ar'      => 'داء الرتوج الكولونية',
                'name_en'      => 'Colonic Diverticular Disease',
                'abbreviation' => 'CDD',
                'icd_code'     => 'K57',
            ],
            [
                'name_ar'      => 'داء كرون',
                'name_en'      => "Crohn's Disease",
                'abbreviation' => 'CD',
                'icd_code'     => 'K50',
            ],
            [
                'name_ar'      => 'التهاب الكولون التقرحي',
                'name_en'      => 'Ulcerative Colitis',
                'abbreviation' => 'UC',
                'icd_code'     => 'K51',
            ],
            [
                'name_ar'      => 'البوليبات الكولونية',
                'name_en'      => 'Colonic Polyps',
                'abbreviation' => 'CP',
                'icd_code'     => 'K63.5',
            ],
            [
                'name_ar'      => 'أورام الكولون والمستقيم',
                'name_en'      => 'Colorectal Tumors',
                'abbreviation' => 'CRT',
                'icd_code'     => 'C18',
            ],
            [
                'name_ar'      => 'التوسعات الشعرية الوعائية',
                'name_en'      => 'Angiodysplasia',
                'abbreviation' => 'AD',
                'icd_code'     => 'K55.2',
            ],
            [
                'name_ar'      => 'قرحة المستقيم الوحيدة',
                'name_en'      => 'Solitary Rectal Ulcer',
                'abbreviation' => 'SRU',
                'icd_code'     => 'K62.6',
            ],

            // ==================== 3. الكبد ====================
            [
                'name_ar'      => 'التهاب الكبد B',
                'name_en'      => 'Hepatitis B',
                'abbreviation' => 'HBV',
                'icd_code'     => 'B18.1',
            ],
            [
                'name_ar'      => 'التهاب الكبد C',
                'name_en'      => 'Hepatitis C',
                'abbreviation' => 'HCV',
                'icd_code'     => 'B18.2',
            ],
            [
                'name_ar'      => 'التهاب الكبد المناعي',
                'name_en'      => 'Autoimmune Hepatitis',
                'abbreviation' => 'AIH',
                'icd_code'     => 'K75.4',
            ],
            [
                'name_ar'      => 'تشحم الكبد',
                'name_en'      => 'Fatty Liver (NAFLD)',
                'abbreviation' => 'NAFLD',
                'icd_code'     => 'K76.0',
            ],
            [
                'name_ar'      => 'تشمع الكبد',
                'name_en'      => 'Liver Cirrhosis',
                'abbreviation' => 'LC',
                'icd_code'     => 'K74.6',
            ],
            [
                'name_ar'      => 'متلازمة بود كياري',
                'name_en'      => 'Budd-Chiari Syndrome',
                'abbreviation' => 'BCS',
                'icd_code'     => 'I82.0',
            ],
            [
                'name_ar'      => 'داء ويلسون',
                'name_en'      => "Wilson's Disease",
                'abbreviation' => 'WD',
                'icd_code'     => 'E83.0',
            ],
            [
                'name_ar'      => 'كيسات الكبد',
                'name_en'      => 'Liver Cysts',
                'abbreviation' => 'LC',
                'icd_code'     => 'K76.89',
            ],
            [
                'name_ar'      => 'أورام الكبد',
                'name_en'      => 'Liver Tumors',
                'abbreviation' => 'LT',
                'icd_code'     => 'C22',
            ],

            // ==================== 4. الطرق الصفراوية والبنكرياس ====================
            [
                'name_ar'      => 'التهاب البنكرياس المتكرر',
                'name_en'      => 'Recurrent Pancreatitis',
                'abbreviation' => 'RP',
                'icd_code'     => 'K85.9',
            ],
            [
                'name_ar'      => 'التهاب البنكرياس المزمن',
                'name_en'      => 'Chronic Pancreatitis',
                'abbreviation' => 'CP',
                'icd_code'     => 'K86.1',
            ],
            [
                'name_ar'      => 'تضيقات الطرق الصفراوية',
                'name_en'      => 'Biliary Strictures',
                'abbreviation' => 'BS',
                'icd_code'     => 'K83.1',
            ],
            [
                'name_ar'      => 'أورام البنكرياس والطرق الصفراوية',
                'name_en'      => 'Pancreatic and Biliary Tumors',
                'abbreviation' => 'PBT',
                'icd_code'     => 'C25',
            ],
        ];

        foreach ($diseases as $disease) {
            ChronicDisease::create($disease + ['is_active' => true]);
        }
    }
}
