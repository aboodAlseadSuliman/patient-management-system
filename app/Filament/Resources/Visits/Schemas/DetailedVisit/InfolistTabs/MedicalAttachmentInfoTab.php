<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات والتحاليل')
            ->icon('heroicon-o-document-text')
            ->badge(fn($record) => $record->attachmentFiles->count() + $record->labTestResults->count() > 0 ? $record->attachmentFiles->count() + $record->labTestResults->count() : null)
            ->badgeColor('success')
            ->schema([

                // ==================== الملفات المرفوعة ====================
                Section::make('الملفات المرفوعة')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->description('صور الأشعة والتقارير الطبية المرفوعة')
                    ->schema([
                        RepeatableEntry::make('attachmentFiles')
                            ->label('')
                            ->schema([
                                Grid::make(5)
                                    ->schema([
                                        TextEntry::make('attachment_type')
                                            ->label('نوع المرفق')
                                            ->formatStateUsing(fn($state) => match ($state) {
                                                'x-ray' => '📷 أشعة بسيطة (X-Ray)',
                                                'ultrasound' => '🔊 إيكو بطني (Ultrasound)',
                                                'ct-scan' => '💿 طبقي محوري (CT Scan)',
                                                'mri' => '🧲 رنين مغناطيسي (MRI)',
                                                'endoscopy' => '🔬 تنظير',
                                                'lab-report' => '📋 تقرير تحاليل',
                                                'document' => '📄 مستند طبي',
                                                'other' => '📎 أخرى',
                                                default => $state,
                                            })
                                            ->badge()
                                            ->color('info')
                                            ->columnSpan(1),

                                        TextEntry::make('file_path')
                                            ->label('الملف')
                                            ->formatStateUsing(
                                                fn($state, $record) =>
                                                '<a href="' . asset('medical-attachments/' . $state) . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                                    </svg>
                                                    تحميل - ' . $record->original_filename . ' (' . $record->formatted_file_size . ')
                                                </a>'
                                            )
                                            ->html()
                                            ->columnSpan(1),

                                        TextEntry::make('created_at')
                                            ->label('تاريخ الرفع')
                                            ->dateTime('d/m/Y H:i')
                                            ->badge()
                                            ->color('gray')
                                            ->columnSpan(1),

                                        TextEntry::make('notes')
                                            ->label('📝 النتيجة')
                                            ->markdown()
                                            ->placeholder('لا توجد ملاحظات')
                                            ->columnSpan(2),
                                    ]),


                            ])
                            ->columns(1)
                            ->contained(false),
                    ])
                    ->collapsed(false)
                    ->visible(fn($record) => $record->attachmentFiles->count() > 0)
                    ->collapsible(),

                // ==================== نتائج التحاليل المخبرية ====================
                Section::make('نتائج التحاليل المخبرية')
                    ->icon('heroicon-o-beaker')
                    ->description('نتائج التحاليل المخبرية المسجلة')
                    ->schema([
                        RepeatableEntry::make('labTestResults')
                            ->label('')
                            ->schema([
                                Grid::make(6)
                                    ->schema([
                                        TextEntry::make('labTest.name_ar')
                                            ->label('اسم التحليل')
                                            ->badge()
                                            ->color('primary')
                                            ->icon('heroicon-o-beaker')
                                            ->weight('bold')
                                            ->columnSpan(1),

                                        TextEntry::make('test_date')
                                            ->label('تاريخ التحليل')
                                            ->date('d/m/Y')
                                            ->badge()
                                            ->color('gray')
                                            ->icon('heroicon-o-calendar')
                                            ->columnSpan(1),

                                        TextEntry::make('result_value')
                                            ->label('النتيجة')
                                            ->formatStateUsing(fn($state, $record) => $state . ($record->unit ? ' ' . $record->unit : ''))
                                            ->badge()
                                            ->color('info')
                                            ->weight('bold')
                                            ->size('lg')
                                            ->columnSpan(1),

                                        TextEntry::make('reference_range')
                                            ->label('المجال الطبيعي')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),

                                        IconEntry::make('is_normal')
                                            ->label('الحالة')
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-exclamation-triangle')
                                            ->trueColor('success')
                                            ->falseColor('warning')
                                            ->columnSpan(1),

                                        TextEntry::make('attachmentFile.file_path')
                                            ->label('الصورة')
                                            ->formatStateUsing(
                                                fn($state, $record) => $state
                                                    ? '<a href="' . asset('medical-attachments/' . $state) . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        عرض الصورة
                                                    </a>'
                                                    : '<span class="text-gray-400">لا توجد صورة</span>'
                                            )
                                            ->html()
                                            ->columnSpan(1),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('previous_value')
                                            ->label('القيمة السابقة')
                                            ->formatStateUsing(fn($state, $record) => $state ? $state . ($record->unit ? ' ' . $record->unit : '') : 'لا توجد')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),

                                        TextEntry::make('previous_test_date')
                                            ->label('تاريخ التحليل السابق')
                                            ->date('d/m/Y')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),
                                    ]),

                                TextEntry::make('notes')
                                    ->label('📝 ملاحظات')
                                    ->markdown()
                                    ->placeholder('لا توجد ملاحظات')
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->contained(false),
                    ])
                    ->collapsed(false)
                    ->visible(fn($record) => $record->labTestResults->count() > 0)
                    ->collapsible(),

                // ==================== 1. الإحالة الطبية ====================
                Section::make('الإحالة الطبية')
                    ->icon('heroicon-o-paper-clip')
                    ->description('إحالة من طبيب آخر أو مشفى')
                    ->schema([
                        TextEntry::make('referringDoctor.first_name')
                            ->label('الطبيب المحول')
                            ->formatStateUsing(function ($record) {
                                if (!$record->referringDoctor) {
                                    return 'غير محدد';
                                }
                                $doctor = $record->referringDoctor;
                                return "{$doctor->first_name} {$doctor->last_name}" .
                                    ($doctor->specialty ? " - {$doctor->specialty}" : '');
                            })
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-user-circle')
                            ->columnSpan(2),

                        TextEntry::make('medicalAttachment.medical_referral')
                            ->label('تفاصيل الإحالة الطبية')
                            ->markdown()
                            ->placeholder('لا توجد تفاصيل إحالة')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ==================== 2. الأشعة ====================
                Section::make('الأشعة والتصوير الطبي')
                    ->icon('heroicon-o-camera')
                    ->description('نتائج الأشعة والفحوصات التصويرية')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                IconEntry::make('medicalAttachment.has_abdominal_ultrasound')
                                    ->label('إيكو بطن')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_xray')
                                    ->label('أشعة بسيطة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_ct_scan')
                                    ->label('طبقي محوري')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_mri')
                                    ->label('رنين مغناطيسي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),

                        TextEntry::make('medicalAttachment.radiology_notes')
                            ->label('ملاحظات ونتائج الأشعة')
                            ->markdown()
                            ->placeholder('لا توجد ملاحظات شعاعية')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 3. التنظير ====================
                Section::make('التنظير (Endoscopy)')
                    ->icon('heroicon-o-magnifying-glass-circle')
                    ->description('نتائج التنظير الهضمي')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                IconEntry::make('medicalAttachment.has_upper_endoscopy')
                                    ->label('تنظير علوي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_colonoscopy')
                                    ->label('تنظير سفلي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_eus')
                                    ->label('EUS')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_ercp')
                                    ->label('ERCP')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),

                        TextEntry::make('medicalAttachment.endoscopy_notes')
                            ->label('ملاحظات ونتائج التنظير')
                            ->markdown()
                            ->placeholder('لا توجد ملاحظات تنظيرية')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 4. التشريح المرضي ====================
                Section::make('التشريح المرضي (Pathology)')
                    ->icon('heroicon-o-beaker')
                    ->description('نتائج الخزعات والفحوصات النسيجية')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                IconEntry::make('medicalAttachment.has_esophagus_pathology')
                                    ->label('مريء')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_stomach_pathology')
                                    ->label('معدة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_duodenum_pathology')
                                    ->label('اثني عشري')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_ileum_pathology')
                                    ->label('دقاق')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_colon_pathology')
                                    ->label('كولون')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_liver_pathology')
                                    ->label('كبد')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('medicalAttachment.has_pancreas_pathology')
                                    ->label('بنكرياس')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),

                        TextEntry::make('medicalAttachment.pathology_notes')
                            ->label('ملاحظات ونتائج التشريح المرضي')
                            ->markdown()
                            ->placeholder('لا توجد نتائج مرضية')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 5. المخبر ====================
                Section::make('التحاليل المخبرية')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('ملاحظات إضافية للتحاليل')
                    ->schema([
                        TextEntry::make('medicalAttachment.lab_results')
                            ->label('ملاحظات نتائج المخبر')
                            ->markdown()
                            ->placeholder('لا توجد نتائج مخبرية')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
