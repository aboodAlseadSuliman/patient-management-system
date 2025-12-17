<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Medication;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        $complaints = [
            'غثيان وقيء منذ يومين',
            'صداع شديد مع دوار',
            'ألم في البطن',
            'سعال وحمى',
            'ألم أسفل الظهر',
            'التهاب الحلق',
            'حساسية جلدية',
            'إسهال حاد',
            'إمساك مزمن',
            'ضيق في التنفس',
        ];

        $diagnoses = [
            'التهاب المعدة الحاد',
            'نزلة برد',
            'التهاب الحلق',
            'صداع نصفي',
            'ألم عضلي',
            'حساسية موسمية',
            'عسر الهضم',
            'التهاب الجيوب الأنفية',
            'ارتجاع المريء',
            'إسهال حاد',
        ];

        $treatments = [
            'راحة تامة مع تناول السوائل',
            'مسكنات للألم حسب الحاجة',
            'مضاد حيوي لمدة أسبوع',
            'مضاد التهاب لمدة 5 أيام',
            'نصائح غذائية وتجنب المهيجات',
        ];

        foreach ($patients as $patient) {
            // إنشاء 2-4 زيارات لكل مريض
            $visitsCount = rand(2, 4);

            for ($v = 1; $v <= $visitsCount; $v++) {
                $visitDate = Carbon::now()->subDays(rand(1, 180));

                $visit = Visit::create([
                    'patient_id' => $patient->id,
                    'visit_number' => $v,
                    'visit_date' => $visitDate,
                    'visit_type' => $v == 1 ? 'first_visit' : 'follow_up',
                    'chief_complaint' => $complaints[array_rand($complaints)],
                    'associated_symptoms' => rand(0, 1) ? 'حمى، تعب عام' : null,
                    'evolution' => 'بدأت الأعراض منذ ' . rand(1, 7) . ' أيام',
                    'triggers' => rand(0, 1) ? 'بعد تناول طعام دسم' : null,
                    'severity' => ['خفيفة', 'متوسطة', 'شديدة'][rand(0, 2)],
                    'vital_signs' => json_encode([
                        'blood_pressure' => rand(110, 140) . '/' . rand(70, 90),
                        'pulse' => rand(60, 100),
                        'temperature' => rand(36, 39) . '.' . rand(0, 9),
                        'respiratory_rate' => rand(12, 20),
                        'oxygen_saturation' => rand(95, 100) . '%',
                        'weight' => rand(50, 120),
                    ]),
                    'physical_examination' => 'فحص عام طبيعي، لا يوجد علامات غير طبيعية',
                    'current_medications' => $patient->permanentMedications->count() > 0
                        ? $patient->permanentMedications->pluck('name_ar')->join(', ')
                        : 'لا يوجد',
                    'previous_surgeries' => rand(0, 1) ? 'لا يوجد' : 'استئصال الزائدة',
                    'diagnosis' => $diagnoses[array_rand($diagnoses)],
                    'general_condition' => ['مستقرة', 'جيدة', 'متحسنة'][rand(0, 2)],
                    'proposed_treatment' => $treatments[array_rand($treatments)],
                    'requested_investigations' => rand(0, 1) ? 'تحليل دم شامل، سكر صائم' : null,
                    'prescription' => 'حسب العلاج المقترح أعلاه',
                    'next_visit_date' => $visitDate->copy()->addWeeks(rand(1, 4)),
                    'doctor_notes' => 'حالة عامة جيدة، ينصح بالمتابعة',
                    'is_completed' => true,
                    'created_by' => rand(2, 3), // doctor
                ]);

                // إضافة أدوية للزيارة
                $visitMeds = Medication::inRandomOrder()->limit(rand(2, 4))->get();
                foreach ($visitMeds as $med) {
                    $visit->medications()->create([
                        'medication_id' => $med->id,
                        'dosage' => ['حبة واحدة', 'حبتين', 'ملعقة'][rand(0, 2)],
                        'frequency' => ['مرة يومياً', 'مرتين يومياً', 'ثلاث مرات'][rand(0, 2)],
                        'duration' => rand(3, 14) . ' أيام',
                        'route' => 'oral',
                        'notes' => 'بعد الأكل',
                    ]);
                }
            }
        }
    }
}
