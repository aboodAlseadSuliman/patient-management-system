<?php

namespace App\Filament\Imports;

use App\Models\Patient;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PatientImporter extends Importer
{
    protected static ?string $model = Patient::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name')
                ->label('الاسم الأول')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('father_name')
                ->label('اسم الأب')
                ->rules(['max:255']),
            ImportColumn::make('last_name')
                ->label('اسم العائلة')
                ->rules(['max:255']),
            ImportColumn::make('national_id')
                ->label('رقم الهوية الوطنية')
                ->rules(['max:50']),
            ImportColumn::make('gender')
                ->label('الجنس')
                ->requiredMapping()
                ->rules(['required', 'in:male,female'])
                ->castStateUsing(function (string $state): string {
                    return match (strtolower(trim($state))) {
                        'ذكر', 'male', 'm' => 'male',
                        'أنثى', 'انثى', 'female', 'f' => 'female',
                        default => $state,
                    };
                }),
            ImportColumn::make('date_of_birth')
                ->label('تاريخ الميلاد')
                ->rules(['date']),
            ImportColumn::make('birth_year')
                ->label('سنة الميلاد')
                ->numeric()
                ->rules(['integer', 'min:1900', 'max:' . date('Y')]),
            ImportColumn::make('phone')
                ->label('رقم الهاتف')
                ->rules(['max:20']),
            ImportColumn::make('country')
                ->label('البلد')
                ->rules(['max:255']),
            ImportColumn::make('province')
                ->label('المحافظة')
                ->rules(['max:255']),
            ImportColumn::make('neighborhood')
                ->label('الحي')
                ->rules(['max:255']),
            ImportColumn::make('occupation')
                ->label('المهنة')
                ->rules(['max:255']),
            ImportColumn::make('notes')
                ->label('ملاحظات'),
        ];
    }

    public function resolveRecord(): ?Patient
    {
        // البحث عن مريض موجود بنفس رقم الهوية أو إنشاء جديد
        if (!empty($this->data['national_id'])) {
            return Patient::firstOrNew([
                'national_id' => $this->data['national_id'],
            ]);
        }

        return new Patient();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'تم استيراد ' . number_format($import->successful_rows) . ' مريض بنجاح.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' فشل استيراد ' . number_format($failedRowsCount) . ' سجل.';
        }

        return $body;
    }
}
