<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class TimelineInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('الخط الزمني وعوامل الخطورة')
            ->icon('heroicon-o-clock')
            ->badge(fn($record) => $record->timeline ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== المربع الأول: الخط الزمني ====================
                Section::make('الخط الزمني')
                    ->icon('heroicon-o-calendar')
                    ->description('توقيت وتطور الأعراض')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('timeline.onset')
                                    ->label('البدء')
                                    ->badge()
                                    ->color(fn(string $state = null): string => match ($state) {
                                        'acute' => 'danger',
                                        'chronic' => 'warning',
                                        'sudden' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state = null): string => match ($state) {
                                        'acute' => 'حاد',
                                        'chronic' => 'مزمن',
                                        'sudden' => 'مفاجئ',
                                        default => 'غير محدد',
                                    })
                                    ->placeholder('غير محدد'),

                                TextEntry::make('timeline.frequency')
                                    ->label('التكرار')
                                    ->badge()
                                    ->color(fn(string $state = null): string => match ($state) {
                                        'episodic' => 'info',
                                        'recurrent' => 'warning',
                                        'continuous' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state = null): string => match ($state) {
                                        'episodic' => 'نوبي',
                                        'recurrent' => 'متكرر',
                                        'continuous' => 'مستمر',
                                        default => 'غير محدد',
                                    })
                                    ->placeholder('غير محدد'),

                                TextEntry::make('timeline.evolution')
                                    ->label('التطور')
                                    ->badge()
                                    ->color(fn(string $state = null): string => match ($state) {
                                        'worsening' => 'danger',
                                        'stable' => 'warning',
                                        'improving' => 'success',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state = null): string => match ($state) {
                                        'worsening' => 'تفاقم',
                                        'stable' => 'ثابت',
                                        'improving' => 'تراجع',
                                        default => 'غير محدد',
                                    })
                                    ->placeholder('غير محدد'),
                            ]),
                    ])
                    ->collapsible(),

                // ==================== المربع الثاني: العوامل المحرضة ====================
                Section::make('العوامل المحرضة')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->description('ما يزيد أو يقلل الأعراض')
                    ->schema([
                        Grid::make(4)
                            ->schema([

                                TextEntry::make('timeline.food_triggers')
                                    ->label('محرضات غذائية')
                                    ->markdown()
                                    ->placeholder('لا توجد محرضات غذائية')
                                    ->columnSpan(2),

                                TextEntry::make('timeline.psychological_triggers')
                                    ->label('محرضات نفسية')
                                    ->markdown()
                                    ->placeholder('لا توجد محرضات نفسية')
                                    ->columnSpan(2),

                                TextEntry::make('timeline.medication_triggers')
                                    ->label('محرضات دوائية')
                                    ->markdown()
                                    ->placeholder('لا توجد محرضات دوائية')
                                    ->columnSpan(2),

                                TextEntry::make('timeline.physical_triggers')
                                    ->label('محرضات فيزيائية')
                                    ->markdown()
                                    ->placeholder('لا توجد محرضات فيزيائية')
                                    ->columnSpan(2),

                                TextEntry::make('timeline.stimulant_triggers')
                                    ->label('منبهات')
                                    ->markdown()
                                    ->placeholder('لا توجد منبهات')
                                    ->columnSpan(2),

                                IconEntry::make('timeline.smoking_trigger')
                                    ->label('التدخين')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                TextEntry::make('timeline.other_triggers')
                                    ->label('محرضات أخرى')
                                    ->markdown()
                                    ->placeholder('لا توجد محرضات أخرى')
                                    ->columnSpan(2),
                            ]),
                    ])
                    ->collapsible(),

                // ==================== المربع الثالث: عوامل الخطورة ====================
                Section::make('عوامل الخطورة (Red Flags)')
                    ->icon('heroicon-o-shield-exclamation')
                    ->description('علامات تنذر بخطورة الحالة')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('timeline.weight_loss_amount')
                                    ->label('كمية نقص الوزن')
                                    ->badge()
                                    ->color('danger')
                                    ->placeholder('لا يوجد'),

                                TextEntry::make('timeline.gi_bleeding')
                                    ->label('نزف هضمي')
                                    ->badge()
                                    ->color('danger')
                                    ->formatStateUsing(fn(string $state = null): string => match ($state) {
                                        'melena' => 'زفتي (Melena)',
                                        'bloody' => 'دموي (Hematochezia)',
                                        'occult' => 'خفي (Occult)',
                                        default => 'لا يوجد',
                                    })
                                    ->placeholder('لا يوجد'),

                                IconEntry::make('timeline.loss_of_appetite')
                                    ->label('نقص شهية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),


                                IconEntry::make('timeline.night_symptoms')
                                    ->label('أعراض ليلية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('timeline.recent_symptoms')
                                    ->label('أعراض حديثة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('timeline.recurrent_ulcers')
                                    ->label('قلاعات متكررة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('timeline.dysphagia_risk')
                                    ->label('عسر بلع')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('timeline.recurrent_vomiting')
                                    ->label('إقياء متكرر')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('timeline.bowel_habit_change_risk')
                                    ->label('تغير عادات معوية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray')
                                    ->columnSpanFull(),

                                TextEntry::make('timeline.family_history')
                                    ->label('قصة عائلية')
                                    ->markdown()
                                    ->placeholder('لا توجد قصة عائلية')
                                    ->columnSpan(2),

                                TextEntry::make('timeline.other_risk_factors')
                                    ->label('عوامل خطورة أخرى')
                                    ->markdown()
                                    ->placeholder('لا توجد عوامل خطورة أخرى')
                                    ->columnSpan(2),
                            ]),


                    ])
                    ->collapsible(),

                // ==================== المربع الرابع: التاريخ المرضي ====================
                Section::make('التاريخ المرضي')
                    ->icon('heroicon-o-document-text')
                    ->description('السوابق الطبية والجراحية من ملف المريض')
                    ->schema([
                        // ⭐ الأمراض المزمنة
                        TextEntry::make('chronic_diseases_list')
                            ->label('🔄 الأمراض المزمنة')
                            ->state(function ($record) {
                                if (!$record || !$record->patient) {
                                    return 'لا توجد أمراض مزمنة';
                                }

                                $diseases = $record->patient->chronicDiseases()
                                    ->where('patient_chronic_diseases.is_active', true)
                                    ->get();

                                if ($diseases->isEmpty()) {
                                    return 'لا توجد أمراض مزمنة';
                                }

                                return $diseases->map(function ($disease) {
                                    $text = $disease->name_ar;
                                    if ($disease->pivot->diagnosis_date) {
                                        $text .= ' (منذ ' . $disease->pivot->diagnosis_date . ')';
                                    }
                                    return $text;
                                })->implode(' • ');
                            })
                            ->color('warning')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->columnSpanFull(),

                        // ⭐ الأدوية الدائمة
                        TextEntry::make('permanent_medications_list')
                            ->label('💊 الأدوية الدائمة')
                            ->state(function ($record) {
                                if (!$record || !$record->patient) {
                                    return 'لا توجد أدوية دائمة';
                                }

                                $medications = $record->patient->permanentMedications()
                                    ->where('patient_permanent_medications.is_active', true)
                                    ->get();

                                if ($medications->isEmpty()) {
                                    return 'لا توجد أدوية دائمة';
                                }

                                return $medications->map(function ($medication) {
                                    $text = $medication->name_ar;
                                    if ($medication->strength) {
                                        $text .= ' (' . $medication->strength . ')';
                                    }
                                    if ($medication->pivot->dosage || $medication->pivot->frequency) {
                                        $details = [];
                                        if ($medication->pivot->dosage) $details[] = $medication->pivot->dosage;
                                        if ($medication->pivot->frequency) $details[] = $medication->pivot->frequency;
                                        $text .= ' - ' . implode(', ', $details);
                                    }
                                    return $text;
                                })->implode(' • ');
                            })
                            ->color('info')
                            ->icon('heroicon-o-beaker')
                            ->columnSpanFull(),

                        // ⭐ حالات طبية أخرى (نص حر)
                        TextEntry::make('timeline.medical_conditions')
                            ->label('📝 حالات طبية أخرى')
                            ->markdown()
                            ->placeholder('لا توجد معلومات إضافية')
                            ->visible(fn ($record) => $record?->timeline?->medical_conditions)
                            ->columnSpanFull(),

                        // ⭐ الجراحات السابقة
                        TextEntry::make('timeline.previous_surgeries')
                            ->label('🏥 الجراحات السابقة')
                            ->markdown()
                            ->placeholder('لا توجد جراحات سابقة')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
