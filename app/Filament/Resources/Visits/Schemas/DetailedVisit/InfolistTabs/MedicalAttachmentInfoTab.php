<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات الطبية')
            ->icon('heroicon-o-document-text')
            ->badge(fn ($record) => $record->medicalAttachment ? '✓' : null)
            ->badgeColor('success')
            ->schema([

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
