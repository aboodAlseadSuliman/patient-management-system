<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

/**
 * مستورد ورقة واحدة — يُستخدم من PatientsOldRecordsImport
 *
 * تنسيق الأعمدة:
 *   A: التسلسل | B: الأسبوع | C: التاريخ | D: الاسم
 *   E: التولد  | F: الملف   | G: السكن   | H: الهاتف
 */
class PatientSheetImport implements ToModel, WithStartRow, SkipsOnError
{
    use SkipsErrors;

    public function __construct(
        private int   &$importedCount,
        private int   &$skippedCount,
        private array &$seenFileNumbers
    ) {}

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row): ?Patient
    {
        // تخطي صفوف الرأس المكررة (العمود A نص وليس رقماً)
        $colA = trim((string)($row[0] ?? ''));
        if (!empty($colA) && !is_numeric($colA)) {
            $this->skippedCount++;
            return null;
        }

        $name    = trim((string)($row[3] ?? ''));
        $fileRaw = trim((string)($row[5] ?? ''));

        // تخطي الصفوف التي بلا اسم أو بلا رقم ملف
        if (empty($name) || empty($fileRaw) || !is_numeric($fileRaw)) {
            $this->skippedCount++;
            return null;
        }

        // تحويل رقم الملف (Excel يحفظه أحياناً كـ 250101.0)
        $fileNumber = (string)(int)((float)$fileRaw);

        // منع التكرار داخل الاستيراد (عبر جميع الأوراق)
        if (isset($this->seenFileNumbers[$fileNumber])) {
            $this->skippedCount++;
            return null;
        }

        // منع التكرار مع قاعدة البيانات
        if (Patient::where('file_number', $fileNumber)->exists()) {
            $this->skippedCount++;
            return null;
        }

        $this->seenFileNumbers[$fileNumber] = true;

        // سنة الميلاد
        $birthYear = null;
        $rawYear   = trim((string)($row[4] ?? ''));
        if (is_numeric($rawYear)) {
            $yr = (int)$rawYear;
            if ($yr >= 1900 && $yr <= (int)date('Y')) {
                $birthYear = $yr;
            }
        }

        // الهاتف
        $phone = trim((string)($row[7] ?? ''));
        if (is_numeric($phone)) {
            $phone = (string)(int)((float)$phone);
        }
        $phone = preg_replace('/[^0-9+]/', '', $phone) ?: null;

        // السكن
        $neighborhood = trim((string)($row[6] ?? '')) ?: null;

        $this->importedCount++;

        return new Patient([
            'file_number'   => $fileNumber,
            'full_name'     => $name,
            'first_name'    => $name,
            'father_name'   => null,
            'last_name'     => null,
            'gender'        => null,
            'birth_year'    => $birthYear,
            'date_of_birth' => null,
            'phone'         => $phone,
            'neighborhood'  => $neighborhood,
            'is_active'     => true,
        ]);
    }
}
