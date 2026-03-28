<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * يقرأ جميع أوراق Excel ويستورد المرضى.
 * يمنع التكرار عبر جميع الأوراق باستخدام مصفوفة مشتركة.
 */
class PatientsOldRecordsImport implements WithMultipleSheets
{
    public int $importedCount = 0;
    public int $skippedCount  = 0;

    private array $seenFileNumbers = [];

    public function __construct(private int $sheetCount = 1) {}

    public function sheets(): array
    {
        $importers = [];

        for ($i = 0; $i < $this->sheetCount; $i++) {
            $importers[$i] = new PatientSheetImport(
                $this->importedCount,
                $this->skippedCount,
                $this->seenFileNumbers
            );
        }

        return $importers;
    }
}
