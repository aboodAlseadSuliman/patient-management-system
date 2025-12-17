<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Medication;
use App\Models\ChronicDisease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maleNames = [
            'أحمد محمد',
            'محمد علي',
            'عبدالله أحمد',
            'خالد محمد',
            'عمر علي',
            'يوسف أحمد',
            'حسن محمد',
            'علي أحمد',
            'سعيد محمد',
            'فهد علي',
            'عبدالرحمن أحمد',
            'ماجد محمد',
            'سلطان علي',
            'فيصل أحمد',
            'عادل محمد',
            'ناصر علي',
            'سامي أحمد',
            'طارق محمد',
            'وليد علي',
            'رامي أحمد',
        ];

        $femaleNames = [
            'فاطمة محمد',
            'عائشة أحمد',
            'مريم علي',
            'خديجة محمد',
            'سارة أحمد',
            'نورة علي',
            'هند محمد',
            'ريم أحمد',
            'ليلى علي',
            'منى محمد',
            'نوف أحمد',
            'رهف علي',
            'شهد محمد',
            'جنى أحمد',
            'لمى علي',
            'غادة محمد',
            'نادية أحمد',
            'سميرة علي',
            'أمل محمد',
            'هيفاء أحمد',
        ];

        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الطائف', 'أبها'];

        // إنشاء 50 مريض
        for ($i = 1; $i <= 50; $i++) {
            $gender = $i % 2 == 0 ? 'male' : 'female';
            $names = $gender == 'male' ? $maleNames : $femaleNames;
            $name = $names[array_rand($names)];

            $age = rand(15, 80);
            $dob = Carbon::now()->subYears($age)->subDays(rand(0, 364));

            $patient = Patient::create([
                'file_number' => 'P' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'national_id' => '1' . str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                'full_name' => $name,
                'gender' => $gender,
                'date_of_birth' => $dob,
                'phone' => '05' . rand(10000000, 99999999),
                'alternative_phone' => rand(0, 1) ? '05' . rand(10000000, 99999999) : null,
                'address' => 'حي ' . ['النزهة', 'الملك فهد', 'العليا', 'الروضة'][rand(0, 3)],
                'city' => $cities[array_rand($cities)],
                'area' => 'منطقة ' . rand(1, 10),
                'is_active' => true,
                'notes' => rand(0, 1) ? 'ملاحظات عامة عن المريض' : null,
                'created_by' => rand(2, 3), // doctor
            ]);

            // إضافة أمراض مزمنة لبعض المرضى (40%)
            if ($age > 40 && rand(0, 100) < 40) {
                $diseases = ChronicDisease::inRandomOrder()->limit(rand(1, 3))->get();
                foreach ($diseases as $disease) {
                    $patient->chronicDiseases()->attach($disease->id, [
                        'diagnosis_date' => Carbon::now()->subMonths(rand(6, 60)),
                        'notes' => 'تحت السيطرة',
                        'is_active' => true,
                    ]);
                }
            }

            // إضافة أدوية دائمة للمرضى الذين لديهم أمراض مزمنة
            if ($patient->chronicDiseases()->count() > 0) {
                $medications = Medication::inRandomOrder()->limit(rand(1, 4))->get();
                foreach ($medications as $medication) {
                    $patient->permanentMedications()->attach($medication->id, [
                        'dosage' => ['حبة واحدة', 'حبتين', 'نصف حبة'][rand(0, 2)],
                        'frequency' => ['مرة يومياً', 'مرتين يومياً', 'ثلاث مرات'][rand(0, 2)],
                        'route' => 'oral',
                        'start_date' => Carbon::now()->subMonths(rand(1, 24)),
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
