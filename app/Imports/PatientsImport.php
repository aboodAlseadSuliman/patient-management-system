<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class PatientsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    private static $fileNumberCounter = null;

    public function model(array $row)
    {
        // تحويل الجنس من العربية إلى الإنجليزية
        $genderValue = $row['algns'] ?? '';
        $gender = match (strtolower(trim($genderValue))) {
            'ذكر', 'male', 'm' => 'male',
            'أنثى', 'انثى', 'female', 'f' => 'female',
            default => 'male',
        };

        // تحويل "نعم/لا" إلى boolean
        $activeValue = $row['nsht'] ?? 'نعم';
        $isActive = match (strtolower(trim($activeValue))) {
            'نعم', 'yes', '1', 'true' => true,
            'لا', 'no', '0', 'false' => false,
            default => true,
        };

        // معالجة تاريخ الميلاد
        $dateOfBirth = null;
        $dateValue = $row['tarykh_almylad'] ?? null;
        if (!empty($dateValue)) {
            try {
                $dateOfBirth = \Carbon\Carbon::parse($dateValue);
            } catch (\Exception $e) {
                $dateOfBirth = null;
            }
        }

        // إذا لم يكن هناك تاريخ ميلاد، استخدم سنة الميلاد أو تاريخ افتراضي
        if (!$dateOfBirth) {
            $birthYear = $row['sn_almylad'] ?? null;
            if ($birthYear) {
                $dateOfBirth = \Carbon\Carbon::create($birthYear, 1, 1);
            } else {
                // تاريخ افتراضي (1 يناير 2000)
                $dateOfBirth = \Carbon\Carbon::create(2000, 1, 1);
            }
        }

        // بناء بيانات المريض - استخدام المفاتيح الصحيحة من Excel
        // رقم الملف يتم توليده تلقائياً دائماً (لا نستخدم الرقم من Excel)
        $patientData = [
            'file_number' => $this->generateFileNumber(),
            'first_name' => $row['alasm_alaol'] ?? null,
            'father_name' => $row['asm_alab'] ?? null,
            'last_name' => $row['asm_alaaayl'] ?? null,
            'national_id' => $row['rkm_alhoy_alotny'] ?? null,
            'gender' => $gender,
            'date_of_birth' => $dateOfBirth,
            'birth_year' => $row['sn_almylad'] ?? null,
            'phone' => $row['rkm_alhatf'] ?? null,
            'country' => $row['albld'] ?? null,
            'province' => $row['almhafth'] ?? null,
            'neighborhood' => $row['alhy'] ?? null,
            'occupation' => $row['almhn'] ?? null,
            'is_active' => $isActive,
            'notes' => $row['mlahthat'] ?? null,
        ];

        // تخطي الصفوف الفارغة
        if (empty($patientData['first_name']) && empty($patientData['national_id'])) {
            return null;
        }

        // التحقق من أن الحقول المطلوبة موجودة
        if (empty($patientData['first_name']) || empty($patientData['gender'])) {
            return null;
        }

        // التحقق من تكرار رقم الهوية
        if (!empty($patientData['national_id'])) {
            $existingPatient = Patient::where('national_id', $patientData['national_id'])->first();
            if ($existingPatient) {
                return null; // تخطي هذا السجل - رقم هوية مكرر
            }
        }

        return Patient::create($patientData);
    }

    private function generateFileNumber(): string
    {
        // إذا لم يتم تهيئة العداد بعد، ابحث عن آخر رقم في قاعدة البيانات
        if (self::$fileNumberCounter === null) {
            $year = date('y'); // آخر خانتين من السنة
            $week = date('W'); // رقم الأسبوع في السنة
            $prefix = $year . str_pad($week, 2, '0', STR_PAD_LEFT);

            $lastPatient = Patient::where('file_number', 'LIKE', $prefix . '%')
                ->orderBy('file_number', 'desc')
                ->first();

            if ($lastPatient) {
                $lastNumber = (int) substr($lastPatient->file_number, -2);
                self::$fileNumberCounter = $lastNumber;
            } else {
                self::$fileNumberCounter = 0;
            }
        }

        // زيادة العداد
        self::$fileNumberCounter++;

        $year = date('y');
        $week = date('W');
        $prefix = $year . str_pad($week, 2, '0', STR_PAD_LEFT);

        return $prefix . str_pad(self::$fileNumberCounter, 2, '0', STR_PAD_LEFT);
    }
}
