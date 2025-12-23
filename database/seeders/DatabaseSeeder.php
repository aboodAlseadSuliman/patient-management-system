<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,              // 1. أولاً
            UserSeeder::class,              // 2. ثانياً (يحتاج roles)
            ChronicDiseaseSeeder::class,    // 3. القواميس
            MedicationSeeder::class,        // 4. القواميس
            DiagnosisSeeder::class,         // 5. القواميس
            MedicalAbbreviationSeeder::class, // 6. القواميس
            PatientSeeder::class,           // 7. المرضى (يحتاج users + قواميس)
            VisitSeeder::class,             // 8. أخيراً (يحتاج patients)
            ImagingStudySeeder::class,
            LabTestSeeder::class,
        ]);

        $this->command->info('✅ تم إضافة جميع البيانات التجريبية بنجاح!');
    }
}
