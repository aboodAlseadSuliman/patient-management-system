<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,               // 1. الصلاحيات
            UserSeeder::class,               // 2. المستخدمون
            ChronicDiseaseSeeder::class,     // 3. الأمراض المزمنة
            MedicationSeeder::class,         // 4. الأدوية
            DiagnosisSeeder::class,          // 5. التشخيصات
            MedicalAbbreviationSeeder::class,// 6. الاختصارات الطبية
            AppointmentTypeSeeder::class,    // 7. أنواع المواعيد
            LabTestSeeder::class,            // 8. التحاليل المخبرية
            EndoscopyProcedureSeeder::class, // 9. إجراءات المنظار
        ]);

        $this->command->info('✅ تم تجهيز البيانات الأساسية بنجاح!');
    }
}
