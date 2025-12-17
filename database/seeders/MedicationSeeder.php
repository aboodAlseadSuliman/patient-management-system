<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medications = [
            // أدوية السكري
            ['name_ar' => 'جلوكوفاج', 'name_en' => 'Glucophage', 'generic_name' => 'Metformin', 'dosage_form' => 'tablet', 'strength' => '500mg'],
            ['name_ar' => 'جلوكوفاج', 'name_en' => 'Glucophage', 'generic_name' => 'Metformin', 'dosage_form' => 'tablet', 'strength' => '850mg'],
            ['name_ar' => 'أماريل', 'name_en' => 'Amaryl', 'generic_name' => 'Glimepiride', 'dosage_form' => 'tablet', 'strength' => '2mg'],
            ['name_ar' => 'جانوفيا', 'name_en' => 'Januvia', 'generic_name' => 'Sitagliptin', 'dosage_form' => 'tablet', 'strength' => '100mg'],
            ['name_ar' => 'إنسولين', 'name_en' => 'Insulin', 'generic_name' => 'Insulin', 'dosage_form' => 'injection', 'strength' => '100 IU/ml'],

            // أدوية الضغط
            ['name_ar' => 'كونكور', 'name_en' => 'Concor', 'generic_name' => 'Bisoprolol', 'dosage_form' => 'tablet', 'strength' => '5mg'],
            ['name_ar' => 'نورفاسك', 'name_en' => 'Norvasc', 'generic_name' => 'Amlodipine', 'dosage_form' => 'tablet', 'strength' => '5mg'],
            ['name_ar' => 'كوفرسيل', 'name_en' => 'Coversyl', 'generic_name' => 'Perindopril', 'dosage_form' => 'tablet', 'strength' => '5mg'],
            ['name_ar' => 'ديوفان', 'name_en' => 'Diovan', 'generic_name' => 'Valsartan', 'dosage_form' => 'tablet', 'strength' => '80mg'],

            // مسكنات
            ['name_ar' => 'بانادول', 'name_en' => 'Panadol', 'generic_name' => 'Paracetamol', 'dosage_form' => 'tablet', 'strength' => '500mg'],
            ['name_ar' => 'بروفين', 'name_en' => 'Brufen', 'generic_name' => 'Ibuprofen', 'dosage_form' => 'tablet', 'strength' => '400mg'],
            ['name_ar' => 'فولتارين', 'name_en' => 'Voltaren', 'generic_name' => 'Diclofenac', 'dosage_form' => 'tablet', 'strength' => '50mg'],

            // مضادات حيوية
            ['name_ar' => 'أوجمنتين', 'name_en' => 'Augmentin', 'generic_name' => 'Amoxicillin/Clavulanate', 'dosage_form' => 'tablet', 'strength' => '625mg'],
            ['name_ar' => 'أوجمنتين', 'name_en' => 'Augmentin', 'generic_name' => 'Amoxicillin/Clavulanate', 'dosage_form' => 'tablet', 'strength' => '1g'],
            ['name_ar' => 'زيثروماكس', 'name_en' => 'Zithromax', 'generic_name' => 'Azithromycin', 'dosage_form' => 'tablet', 'strength' => '500mg'],
            ['name_ar' => 'فلوموكس', 'name_en' => 'Flumox', 'generic_name' => 'Amoxicillin', 'dosage_form' => 'capsule', 'strength' => '500mg'],

            // أدوية المعدة
            ['name_ar' => 'نكسيوم', 'name_en' => 'Nexium', 'generic_name' => 'Esomeprazole', 'dosage_form' => 'capsule', 'strength' => '40mg'],
            ['name_ar' => 'كونترولوك', 'name_en' => 'Controloc', 'generic_name' => 'Pantoprazole', 'dosage_form' => 'tablet', 'strength' => '40mg'],
            ['name_ar' => 'موتيليوم', 'name_en' => 'Motilium', 'generic_name' => 'Domperidone', 'dosage_form' => 'tablet', 'strength' => '10mg'],
            ['name_ar' => 'فلاجيل', 'name_en' => 'Flagyl', 'generic_name' => 'Metronidazole', 'dosage_form' => 'tablet', 'strength' => '500mg'],

            // أدوية الحساسية
            ['name_ar' => 'تلفاست', 'name_en' => 'Telfast', 'generic_name' => 'Fexofenadine', 'dosage_form' => 'tablet', 'strength' => '120mg'],
            ['name_ar' => 'كلاريتين', 'name_en' => 'Claritin', 'generic_name' => 'Loratadine', 'dosage_form' => 'tablet', 'strength' => '10mg'],
            ['name_ar' => 'زيرتك', 'name_en' => 'Zyrtec', 'generic_name' => 'Cetirizine', 'dosage_form' => 'tablet', 'strength' => '10mg'],

            // أدوية الكولسترول
            ['name_ar' => 'ليبيتور', 'name_en' => 'Lipitor', 'generic_name' => 'Atorvastatin', 'dosage_form' => 'tablet', 'strength' => '20mg'],
            ['name_ar' => 'كريستور', 'name_en' => 'Crestor', 'generic_name' => 'Rosuvastatin', 'dosage_form' => 'tablet', 'strength' => '10mg'],

            // أدوية الربو
            ['name_ar' => 'فينتولين', 'name_en' => 'Ventolin', 'generic_name' => 'Salbutamol', 'dosage_form' => 'inhaler', 'strength' => '100mcg'],
            ['name_ar' => 'سيريتايد', 'name_en' => 'Seretide', 'generic_name' => 'Salmeterol/Fluticasone', 'dosage_form' => 'inhaler', 'strength' => '25/250mcg'],

            // فيتامينات
            ['name_ar' => 'فيتامين د', 'name_en' => 'Vitamin D', 'generic_name' => 'Cholecalciferol', 'dosage_form' => 'capsule', 'strength' => '50000 IU'],
            ['name_ar' => 'فيتامين ب12', 'name_en' => 'Vitamin B12', 'generic_name' => 'Cyanocobalamin', 'dosage_form' => 'tablet', 'strength' => '1000mcg'],
            ['name_ar' => 'كالسيوم', 'name_en' => 'Calcium', 'generic_name' => 'Calcium Carbonate', 'dosage_form' => 'tablet', 'strength' => '500mg'],

            // أدوية أخرى شائعة
            ['name_ar' => 'أسبرين', 'name_en' => 'Aspirin', 'generic_name' => 'Acetylsalicylic Acid', 'dosage_form' => 'tablet', 'strength' => '100mg'],
            ['name_ar' => 'بريدنيزولون', 'name_en' => 'Prednisolone', 'generic_name' => 'Prednisolone', 'dosage_form' => 'tablet', 'strength' => '5mg'],
            ['name_ar' => 'مضاد تخثر', 'name_en' => 'Xarelto', 'generic_name' => 'Rivaroxaban', 'dosage_form' => 'tablet', 'strength' => '20mg'],
            ['name_ar' => 'أومفورمين', 'name_en' => 'Omformin', 'generic_name' => 'Metformin', 'dosage_form' => 'tablet', 'strength' => '1000mg'],
        ];

        foreach ($medications as $medication) {
            Medication::create($medication + [
                'is_active' => true,
                'common_dosage' => 'حسب إرشادات الطبيب',
            ]);
        }
    }
}
