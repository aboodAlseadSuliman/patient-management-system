<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\LabTest;
use App\Models\LabTestResult;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات والتحاليل')
            ->icon('heroicon-o-document-text')
            ->badge(fn($get) => (count($get('attachment_files_data') ?? []) + count($get('lab_test_results_data') ?? [])) ?: null)
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

                // ==================== نتائج التحاليل المخبرية ====================
                Section::make('نتائج التحاليل المخبرية')
                    ->icon('heroicon-o-beaker')
                    ->description('سجل نتائج التحاليل مع إمكانية رفع صورة التحليل (اختياري)')
                    ->schema([
                        Repeater::make('lab_test_results_data')
                            ->label('التحاليل')
                            ->schema([
                                Select::make('lab_test_id')
                                    ->label('اسم التحليل')
                                    ->required()
                                    ->options(LabTest::query()->pluck('name_ar', 'id'))
                                    ->searchable()
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get, $record) {
                                        if (!$state) {
                                            return;
                                        }

                                        $patientId = null;
                                        if ($record && $record->patient_id) {
                                            $patientId = $record->patient_id;
                                        }
                                        if (!$patientId) {
                                            $patientId = $get('../../patient_id');
                                        }
                                        if (!$patientId) {
                                            return;
                                        }

                                        $query = LabTestResult::whereHas('visit', function ($query) use ($patientId) {
                                            $query->where('patient_id', $patientId);
                                        })
                                        ->where('lab_test_id', $state)
                                        ->latest('test_date');

                                        if ($record) {
                                            $query->whereHas('visit', function ($query) use ($record) {
                                                $query->where('id', '!=', $record->id);
                                            });
                                        }

                                        $previousResult = $query->first();
                                        if ($previousResult) {
                                            $set('previous_value', $previousResult->result_value);
                                            $set('previous_test_date', $previousResult->test_date);
                                        }
                                    })
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('اسم التحليل بالعربية')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('name_en')
                                            ->label('اسم التحليل بالإنجليزية')
                                            ->maxLength(255),
                                        TextInput::make('abbreviation')
                                            ->label('الاختصار')
                                            ->placeholder('FBS, CBC, etc.')
                                            ->maxLength(50),
                                        Textarea::make('description')
                                            ->label('وصف التحليل')
                                            ->rows(2),
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        return LabTest::create($data)->id;
                                    })
                                    ->columnSpan(2),

                                DatePicker::make('test_date')
                                    ->label('تاريخ التحليل')
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->closeOnDateSelection()
                                    ->columnSpan(1),

                                FileUpload::make('lab_image_path')
                                    ->label('صورة التحليل (اختياري)')
                                    ->directory(function ($get, $record) {
                                        if ($record && $record->patient_id) {
                                            return $record->patient_id . '/' . $record->id;
                                        }
                                        $patientId = $get('../../patient_id');
                                        if ($patientId) {
                                            return $patientId . '/temp';
                                        }
                                        return 'temp';
                                    })
                                    ->disk('medical_attachments')
                                    ->visibility('public')
                                    ->image()
                                    ->imagePreviewHeight('150')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                                    ->maxSize(10240)
                                    ->downloadable()
                                    ->openable()
                                    ->previewable(true)
                                    ->helperText('يمكنك رفع صورة للتحليل لسهولة الرجوع إليها')
                                    ->columnSpan(1),

                                TextInput::make('result_value')
                                    ->label('النتيجة')
                                    ->required()
                                    ->placeholder('مثال: 13.5')
                                    ->columnSpan(1),

                                TextInput::make('unit')
                                    ->label('الوحدة')
                                    ->placeholder('g/dL, mg/dL, mmol/L')
                                    ->columnSpan(1),

                                TextInput::make('reference_range')
                                    ->label('المجال الطبيعي')
                                    ->placeholder('مثال: 12-16')
                                    ->helperText('المجال الطبيعي للقيمة')
                                    ->columnSpan(1),

                                Toggle::make('is_normal')
                                    ->label('النتيجة طبيعية؟')
                                    ->inline(false)
                                    ->default(true)
                                    ->columnSpan(1),

                                TextInput::make('previous_value')
                                    ->label('القيمة السابقة')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->placeholder('سيتم جلبها تلقائياً')
                                    ->helperText('القيمة من الزيارة السابقة')
                                    ->columnSpan(1),

                                DatePicker::make('previous_test_date')
                                    ->label('تاريخ التحليل السابق')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات')
                                    ->rows(2)
                                    ->placeholder('أي ملاحظات إضافية عن النتيجة...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->addActionLabel('+ إضافة نتيجة تحليل')
                            ->collapsible()
                            ->itemLabel(function (array $state): ?string {
                                if (!isset($state['lab_test_id'])) {
                                    return 'نتيجة تحليل';
                                }
                                $labTest = LabTest::find($state['lab_test_id']);
                                $result = $state['result_value'] ?? '';
                                $unit = $state['unit'] ?? '';
                                $status = isset($state['is_normal']) ? ($state['is_normal'] ? '✅' : '⚠️') : '';

                                return $labTest?->name_ar . ' ' . $status . ($result ? " - {$result} {$unit}" : '');
                            })
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
