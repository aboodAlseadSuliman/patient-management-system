<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class TimelineTab
{
    public static function make(): Tab
    {
        return Tab::make('الخط الزمني وعوامل الخطورة')
            ->icon('heroicon-o-clock')
            ->badge(fn($get) => $get('timeline.onset') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== المربع الثاني: الخط الزمني ====================
                Section::make('الخط الزمني')
                    ->icon('heroicon-o-calendar')
                    ->description('توقيت وتطور الأعراض')
                    ->schema([
                        Select::make('timeline.onset')
                            ->label('1. البدء')
                            ->options([
                                'acute' => 'حاد',
                                'chronic' => 'مزمن',
                                'sudden' => 'مفاجئ',
                            ])
                            ->placeholder('اختر نوع البدء'),

                        Select::make('timeline.frequency')
                            ->label('2. التكرار')
                            ->options([
                                'episodic' => 'نوبي',
                                'recurrent' => 'متكرر',
                                'continuous' => 'مستمر',
                            ])
                            ->placeholder('اختر التكرار'),

                        Select::make('timeline.evolution')
                            ->label('3. التطور')
                            ->options([
                                'worsening' => 'تفاقم',
                                'stable' => 'ثابت',
                                'improving' => 'تراجع',
                            ])
                            ->placeholder('اختر التطور'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                // ==================== المربع الثالث: العوامل المحرضة ====================
                Section::make('العوامل المحرضة')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->description('ما يزيد أو يقلل الأعراض')
                    ->schema([
                        Textarea::make('timeline.food_triggers')
                            ->label('1. محرضات غذائية')
                            ->rows(2)
                            ->placeholder('الأطعمة التي تزيد الأعراض...')
                            ->columnSpan(2),

                        Textarea::make('timeline.psychological_triggers')
                            ->label('2. محرضات نفسية')
                            ->rows(2)
                            ->placeholder('الضغوط النفسية، القلق...')
                            ->columnSpan(2),

                        Textarea::make('timeline.medication_triggers')
                            ->label('3. محرضات دوائية')
                            ->rows(2)
                            ->placeholder('أدوية تزيد الأعراض...')
                            ->columnSpan(2),

                        Textarea::make('timeline.physical_triggers')
                            ->label('4. محرضات فيزيائية')
                            ->rows(2)
                            ->placeholder('الجهد، الحركة، الوضعية...')
                            ->columnSpan(2),

                        Textarea::make('timeline.stimulant_triggers')
                            ->label('5. منبهات')
                            ->rows(2)
                            ->placeholder('قهوة، شاي، كحول...')
                            ->columnSpan(2),

                        Checkbox::make('timeline.smoking_trigger')
                            ->label('6. التدخين')
                            ->inline(false),

                        Textarea::make('timeline.other_triggers')
                            ->label('7. محرضات أخرى')
                            ->rows(2)
                            ->placeholder('أي محرضات أخرى...')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== المربع الرابع: عوامل الخطورة ====================
                Section::make('عوامل الخطورة (Red Flags)')
                    ->icon('heroicon-o-shield-exclamation')
                    ->description('علامات تنذر بخطورة الحالة')
                    ->schema([



                        Checkbox::make('timeline.loss_of_appetite')
                            ->label('1. نقص شهية')
                            ->inline(false),
                        Checkbox::make('timeline.night_symptoms')
                            ->label('2. أعراض ليلية')
                            ->inline(false),

                        Checkbox::make('timeline.recent_symptoms')
                            ->label('3. أعراض حديثة')
                            ->inline(false),

                        Checkbox::make('timeline.recurrent_ulcers')
                            ->label('4. قلاعات متكررة')
                            ->inline(false),

                        Checkbox::make('timeline.dysphagia_risk')
                            ->label('5. عسر بلع')
                            ->inline(false),

                        Checkbox::make('timeline.recurrent_vomiting')
                            ->label('6. إقياء متكرر')
                            ->inline(false),

                        Checkbox::make('timeline.bowel_habit_change_risk')
                            ->label('7. تغير عادات معوية')
                            ->inline(false),

                        TextInput::make('timeline.weight_loss_amount')
                            ->label('8. كمية نقص الوزن')
                            ->placeholder('مثال: 5 كغ خلال شهرين')
                            ->columnSpan(2),

                        Select::make('timeline.gi_bleeding')
                            ->label('9. نزف هضمي')
                            ->options([
                                'melena' => 'زفتي (Melena)',
                                'bloody' => 'دموي (Hematochezia)',
                                'occult' => 'خفي (Occult)',
                            ])
                            ->placeholder(placeholder: 'اختر النوع')
                            ->columnSpan(2),


                        Textarea::make('timeline.family_history')
                            ->label('10. قصة عائلية')
                            ->rows(2)
                            ->placeholder('أمراض وراثية، سرطانات عائلية...')
                            ->columnSpan(2),

                        Textarea::make('timeline.other_risk_factors')
                            ->label('11. عوامل خطورة أخرى')
                            ->rows(2)
                            ->placeholder('أي عوامل خطورة إضافية...')
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== المربع الخامس: التاريخ المرضي ====================
                Section::make('التاريخ المرضي')
                    ->icon('heroicon-o-document-text')
                    ->description('السوابق الطبية والجراحية')
                    ->schema([
                        Textarea::make('timeline.medical_conditions')
                            ->label('1. الحالات المرضية')
                            ->rows(3)
                            ->placeholder('الأمراض المزمنة، الحالات الطبية السابقة...')
                            ->helperText('سيتم تحميل الأمراض المزمنة تلقائياً من ملف المريض')
                            ->columnSpanFull(),

                        Textarea::make('timeline.current_medications')
                            ->label('2. الأدوية المستخدمة')
                            ->rows(3)
                            ->placeholder('الأدوية الحالية والجرعات...')
                            ->helperText('سيتم تحميل الأدوية الدائمة تلقائياً من ملف المريض')
                            ->columnSpanFull(),

                        Textarea::make('timeline.previous_surgeries')
                            ->label('3. الجراحات السابقة')
                            ->rows(3)
                            ->placeholder('العمليات الجراحية وتواريخها...')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
