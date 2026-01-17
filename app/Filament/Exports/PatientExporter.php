<?php

namespace App\Filament\Exports;

use App\Models\Patient;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PatientExporter extends Exporter
{
    protected static ?string $model = Patient::class;

    public static function getJobConnection(): ?string
    {
        return 'database';
    }

    public function getFileDisk(): string
    {
        return 'public';
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('file_number')
                ->label('رقم الملف'),
            ExportColumn::make('national_id')
                ->label('رقم الهوية الوطنية'),
            ExportColumn::make('full_name')
                ->label('الاسم الكامل'),
            ExportColumn::make('first_name')
                ->label('الاسم الأول'),
            ExportColumn::make('father_name')
                ->label('اسم الأب'),
            ExportColumn::make('last_name')
                ->label('اسم العائلة'),
            ExportColumn::make('gender')
                ->label('الجنس')
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'male' => 'ذكر',
                    'female' => 'أنثى',
                    default => $state ?? '',
                }),
            ExportColumn::make('date_of_birth')
                ->label('تاريخ الميلاد'),
            ExportColumn::make('birth_year')
                ->label('سنة الميلاد'),
            ExportColumn::make('phone')
                ->label('رقم الهاتف'),
            ExportColumn::make('country')
                ->label('البلد'),
            ExportColumn::make('province')
                ->label('المحافظة'),
            ExportColumn::make('neighborhood')
                ->label('الحي'),
            ExportColumn::make('occupation')
                ->label('المهنة'),
            ExportColumn::make('referringDoctor.name')
                ->label('الطبيب المحول'),
            ExportColumn::make('is_active')
                ->label('نشط')
                ->formatStateUsing(fn (bool $state): string => $state ? 'نعم' : 'لا'),
            ExportColumn::make('notes')
                ->label('ملاحظات'),
            ExportColumn::make('created_at')
                ->label('تاريخ الإنشاء'),
            ExportColumn::make('updated_at')
                ->label('تاريخ التحديث'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'تم تصدير ' . number_format($export->successful_rows) . ' مريض بنجاح.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' فشل تصدير ' . number_format($failedRowsCount) . ' سجل.';
        }

        return $body;
    }
}
