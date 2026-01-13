<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\ReferringDoctor;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات الطبية')
            ->icon('heroicon-o-document-text')
            ->badge(fn ($get) => $get('medicalAttachment.medical_referral') ? '✓' : null)
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
                                    ])
                                    ->maxSize(10240) // 10MB
                                    ->downloadable()
                                    ->openable()
                                    ->previewable(true)
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات')
                                    ->rows(2)
                                    ->placeholder('أي ملاحظات أو تفاصيل عن المرفق...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('+ إضافة مرفق طبي')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                isset($state['attachment_type'])
                                    ? match($state['attachment_type']) {
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

                // ==================== 1. الأشعة ====================
                Section::make('الأشعة والتصوير الطبي')
                    ->icon('heroicon-o-camera')
                    ->description('نتائج الأشعة والفحوصات التصويرية')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_abdominal_ultrasound')
                            ->label('إيكو بطن (Abdominal Ultrasound)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_xray')
                            ->label('أشعة بسيطة (X-Ray)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_ct_scan')
                            ->label('طبقي محوري (CT Scan)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_mri')
                            ->label('رنين مغناطيسي (MRI)')
                            ->inline(false),

                        Textarea::make('medicalAttachment.radiology_notes')
                            ->label('ملاحظات ونتائج الأشعة')
                            ->rows(4)
                            ->placeholder('ملخص نتائج الأشعة، الموجودات، الانطباع التشخيصي...')
                            ->helperText('اكتب ملخص التقارير الشعاعية هنا')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 2. التنظير ====================
                Section::make('التنظير (Endoscopy)')
                    ->icon('heroicon-o-magnifying-glass-circle')
                    ->description('نتائج التنظير الهضمي')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_upper_endoscopy')
                            ->label('تنظير علوي (Upper GI Endoscopy)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_colonoscopy')
                            ->label('تنظير سفلي (Colonoscopy)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_eus')
                            ->label('EUS (Endoscopic Ultrasound)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_ercp')
                            ->label('ERCP (Endoscopic Retrograde Cholangiopancreatography)')
                            ->inline(false),

                        Textarea::make('medicalAttachment.endoscopy_notes')
                            ->label('ملاحظات ونتائج التنظير')
                            ->rows(4)
                            ->placeholder('الموجودات المنظارية، الخزعات المأخوذة، الإجراءات العلاجية...')
                            ->helperText('سجل تفاصيل التنظير والموجودات المرضية')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 3. التشريح المرضي ====================
                Section::make('التشريح المرضي (Pathology)')
                    ->icon('heroicon-o-beaker')
                    ->description('نتائج الخزعات والفحوصات النسيجية')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_esophagus_pathology')
                            ->label('مريء (Esophagus)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_stomach_pathology')
                            ->label('معدة (Stomach)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_duodenum_pathology')
                            ->label('اثني عشري (Duodenum)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_ileum_pathology')
                            ->label('دقاق (Ileum)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_colon_pathology')
                            ->label('كولون (Colon)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_liver_pathology')
                            ->label('كبد (Liver)')
                            ->inline(false),

                        Checkbox::make('medicalAttachment.has_pancreas_pathology')
                            ->label('بنكرياس (Pancreas)')
                            ->inline(false),

                        Textarea::make('medicalAttachment.pathology_notes')
                            ->label('ملاحظات ونتائج التشريح المرضي')
                            ->rows(4)
                            ->placeholder('التشخيص النسيجي، درجة الورم، علامات مناعية...')
                            ->helperText('سجل نتائج التقارير المرضية والتشخيص النسيجي')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 4. المخبر ====================
                Section::make('التحاليل المخبرية')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('ملاحظات إضافية للتحاليل (التحاليل التفصيلية في تبويب منفصل)')
                    ->schema([
                        Textarea::make('medicalAttachment.lab_results')
                            ->label('ملاحظات نتائج المخبر')
                            ->rows(4)
                            ->placeholder('ملخص أهم النتائج المخبرية...')
                            ->helperText('يمكنك إضافة التحاليل التفصيلية من تبويب "التشخيص والفحوصات"')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
