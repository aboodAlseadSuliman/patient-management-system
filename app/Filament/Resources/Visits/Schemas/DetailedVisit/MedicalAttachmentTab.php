<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات الطبية')
            ->icon('heroicon-o-document-text')
            ->badge(fn($get) => $get('medicalAttachment.medical_referral') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== رفع المرفقات الطبية ====================
                Section::make('رفع المرفقات الطبية')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->description('رفع صور الأشعة والتقارير الطبية')
                    ->schema([
                        Repeater::make('attachment_files_data')
                            ->label('المرفقات')
                            ->schema([
                                Select::make('attachment_type')
                                    ->label('نوع المرفق')
                                    ->required()
                                    ->options([
                                        'x-ray' => 'أشعة بسيطة (X-Ray)',
                                        'ultrasound' => 'إيكو بطني (Ultrasound)',
                                        'ct-scan' => 'طبقي محوري (CT Scan)',
                                        'mri' => 'رنين مغناطيسي (MRI)',
                                        'endoscopy' => 'تنظير',
                                        'lab-report' => 'تقرير تحاليل',
                                        'document' => 'مستند طبي',
                                        'other' => 'أخرى',
                                    ])
                                    ->searchable()
                                    ->native(false)
                                    ->columnSpan(1),

                                FileUpload::make('file_path')
                                    ->label('الملف')
                                    ->required()
                                    ->directory(function ($get, $record) {
                                        // استخدام السجل الحالي (للتعديل) أو حساب من patient_id
                                        if ($record && $record->patient_id) {
                                            return $record->patient_id . '/' . $record->id;
                                        }
                                        // للزيارات الجديدة، نضع في temp ثم ننقلها بعد الحفظ
                                        $patientId = $get('../../patient_id');
                                        if ($patientId) {
                                            return $patientId . '/temp';
                                        }
                                        return 'temp';
                                    })
                                    ->disk('medical_attachments')
                                    ->visibility('public')
                                    ->preserveFilenames()
                                    ->image()
                                    ->imagePreviewHeight('250')
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/jpg',
                                        'application/pdf',
                                        'application/dicom',
                                        'video/mp4',
                                        'video/mpeg',
                                        'video/quicktime',
                                        'video/x-msvideo',
                                        'video/x-matroska',
                                    ])
                                    ->maxSize(10240) // 10MB
                                    ->downloadable()
                                    ->openable()
                                    ->previewable(true)
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات ونتائج')
                                    ->rows(6)
                                    ->placeholder('النتائج، الموجودات، الانطباع التشخيصي، القيم المخبرية...' . "\n\n" . 'يمكنك استخدام التنسيق التالي:' . "\n" . '**عنوان**: قيمة' . "\n" . '- نقطة 1' . "\n" . '- نقطة 2')
                                    ->helperText('سجل تفاصيل الفحص والنتائج والموجودات المرضية. يمكنك استخدام تنسيق نصي منظم.')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('+ إضافة مرفق طبي')
                            ->collapsible()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                isset($state['attachment_type'])
                                    ? match ($state['attachment_type']) {
                                        'x-ray' => 'أشعة بسيطة (X-Ray)',
                                        'ultrasound' => 'إيكو بطني (Ultrasound)',
                                        'ct-scan' => 'طبقي محوري (CT Scan)',
                                        'mri' => 'رنين مغناطيسي (MRI)',
                                        'endoscopy' => 'تنظير',
                                        'lab-report' => 'تقرير تحاليل',
                                        'document' => 'مستند طبي',
                                        'other' => 'أخرى',
                                        default => 'مرفق طبي'
                                    }
                                    : 'مرفق طبي'
                            )
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
