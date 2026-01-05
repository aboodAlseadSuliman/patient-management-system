<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class ClinicalExaminationInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('الفحص السريري')
            ->icon('heroicon-o-heart')
            ->badge(fn ($record) => $record->clinicalExamination ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. العلامات الحيوية ====================
                Section::make('العلامات الحيوية (Vital Signs)')
                    ->icon('heroicon-o-heart')
                    ->description('القياسات الأساسية')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('clinicalExamination.blood_pressure')
                                    ->label('الضغط الشرياني')
                                    ->badge()
                                    ->color('info')
                                    ->suffix(' mmHg')
                                    ->placeholder('غير محدد'),

                                TextEntry::make('clinicalExamination.pulse')
                                    ->label('النبض')
                                    ->badge()
                                    ->color('info')
                                    ->suffix(' نبضة/دقيقة')
                                    ->placeholder('غير محدد'),

                                TextEntry::make('clinicalExamination.temperature')
                                    ->label('الحرارة')
                                    ->badge()
                                    ->color(fn ($state) => $state && $state > 37.5 ? 'danger' : 'info')
                                    ->suffix(' °C')
                                    ->placeholder('غير محدد'),

                                TextEntry::make('clinicalExamination.oxygen_saturation')
                                    ->label('الأكسجة')
                                    ->badge()
                                    ->color(fn ($state) => $state && $state < 95 ? 'danger' : 'success')
                                    ->suffix(' %')
                                    ->placeholder('غير محدد'),
                            ]),
                    ])
                    ->collapsible(),

                // ==================== 2. الفحص السريري ====================
                Section::make('الفحص السريري العام')
                    ->icon('heroicon-o-user')
                    ->description('الفحص الجسدي الشامل')
                    ->schema([
                        TextEntry::make('clinicalExamination.weight')
                            ->label('الوزن')
                            ->badge()
                            ->color('info')
                            ->suffix(' كغ')
                            ->placeholder('غير محدد')
                            ->columnSpan(2),

                        TextEntry::make('clinicalExamination.head_neck_exam')
                            ->label('الرأس والعنق')
                            ->markdown()
                            ->placeholder('لا توجد موجودات')
                            ->columnSpan(2),

                        TextEntry::make('clinicalExamination.heart_chest_exam')
                            ->label('القلب والصدر')
                            ->markdown()
                            ->placeholder('لا توجد موجودات')
                            ->columnSpan(2),

                        TextEntry::make('clinicalExamination.abdomen_pelvis_exam')
                            ->label('البطن والحوض')
                            ->markdown()
                            ->placeholder('لا توجد موجودات')
                            ->helperText('من أهم الفحوصات في العيادة الهضمية')
                            ->columnSpan(2),

                        TextEntry::make('clinicalExamination.extremities_exam')
                            ->label('الأطراف')
                            ->markdown()
                            ->placeholder('لا توجد موجودات')
                            ->columnSpan(2),

                        TextEntry::make('clinicalExamination.rectal_exam')
                            ->label('المس الشرجي')
                            ->markdown()
                            ->placeholder('لا توجد موجودات')
                            ->helperText('فحص مهم في أمراض الجهاز الهضمي')
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 3. إيكو البطن ====================
                Section::make('إيكو البطن (Abdominal Ultrasound)')
                    ->icon('heroicon-o-wifi')
                    ->description('نتائج فحص الإيكو')
                    ->schema([
                        TextEntry::make('clinicalExamination.liver_echo')
                            ->label('الكبد')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.gallbladder_echo')
                            ->label('المرارة')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.bile_ducts_echo')
                            ->label('الطرق الصفراوية')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.pancreas_echo')
                            ->label('البنكرياس')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.spleen_echo')
                            ->label('الطحال')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.stomach_echo')
                            ->label('المعدة')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.intestines_echo')
                            ->label('الأمعاء')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.abdominal_cavity_echo')
                            ->label('جوف البطن')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.kidneys_echo')
                            ->label('الكليتين')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.uterus_appendages_echo')
                            ->label('الرحم والملحقات')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->helperText('للإناث فقط')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.prostate_echo')
                            ->label('البروستات')
                            ->markdown()
                            ->placeholder('لم يتم الفحص')
                            ->helperText('للذكور فقط')
                            ->columnSpan(1),

                        TextEntry::make('clinicalExamination.other_echo')
                            ->label('موجودات أخرى')
                            ->markdown()
                            ->placeholder('لا توجد موجودات أخرى')
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
