<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class ClinicalExaminationTab
{
    public static function make(): Tab
    {
        return Tab::make('الفحص السريري')
            ->icon('heroicon-o-heart')
            ->badge(fn($get) => $get('clinicalExamination.blood_pressure') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. العلامات الحيوية ====================
                Section::make('العلامات الحيوية (Vital Signs)')
                    ->icon('heroicon-o-heart')
                    ->description('القياسات الأساسية')
                    ->schema([
                        TextInput::make('clinicalExamination.blood_pressure')
                            ->label('1. الضغط الشرياني (BP)')
                            ->placeholder('120/80')
                            ->helperText('مثال: 120/80 mmHg'),

                        TextInput::make('clinicalExamination.pulse')
                            ->label('2. النبض (Pulse)')
                            ->numeric()
                            ->suffix('نبضة/دقيقة')
                            ->placeholder('75')
                            ->helperText('المعدل الطبيعي: 60-100'),

                        TextInput::make('clinicalExamination.temperature')
                            ->label('3. الحرارة (Temp)')
                            ->numeric()
                            ->step(0.1)
                            ->suffix('°C')
                            ->placeholder('37.0')
                            ->helperText('المعدل الطبيعي: 36.5-37.5'),

                        TextInput::make('clinicalExamination.oxygen_saturation')
                            ->label('4. الأكسجة (O₂ Sat)')
                            ->numeric()
                            ->suffix('%')
                            ->placeholder('98')
                            ->helperText('المعدل الطبيعي: >95%'),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 2. الفحص السريري ====================
                Section::make('الفحص السريري العام')
                    ->icon('heroicon-o-user')
                    ->description('الفحص الجسدي الشامل')
                    ->schema([
                        TextInput::make('clinicalExamination.weight')
                            ->label('1. الوزن')
                            ->numeric()
                            ->step(0.1)
                            ->suffix('كغ')
                            ->placeholder('70.5')
                            ->columnSpan(2),

                        Textarea::make('clinicalExamination.head_neck_exam')
                            ->label('2. الرأس والعنق')
                            ->rows(3)
                            ->placeholder('عيون، أذنين، أنف، فم، بلعوم، غدد لمفاوية، درقية...')
                            ->columnSpan(2),

                        Textarea::make('clinicalExamination.heart_chest_exam')
                            ->label('3. القلب والصدر')
                            ->rows(3)
                            ->placeholder('أصوات القلب، النفخات، أصوات التنفس، حشرجات...')
                            ->columnSpan(2),

                        Textarea::make('clinicalExamination.abdomen_pelvis_exam')
                            ->label('4. البطن والحوض')
                            ->rows(3)
                            ->placeholder('شكل البطن، أصوات الأمعاء، الجس، الإيلام، الكتل، الأعضاء...')
                            ->helperText('هذا من أهم الفحوصات في العيادة الهضمية')
                            ->columnSpan(2),

                        Textarea::make('clinicalExamination.extremities_exam')
                            ->label('5. الأطراف')
                            ->rows(3)
                            ->placeholder('وذمات، تشوهات، حركة، دوران...')
                            ->columnSpan(2),

                        Textarea::make('clinicalExamination.rectal_exam')
                            ->label('6. المس الشرجي (Digital Rectal Exam)')
                            ->rows(3)
                            ->placeholder('توتر العضلة، كتل، دم، بواسير...')
                            ->helperText('فحص مهم في أمراض الجهاز الهضمي')
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 3. إيكو البطن ====================
                Section::make('إيكو البطن (Abdominal Ultrasound)')
                    ->icon('heroicon-o-wifi')
                    ->description('نتائج فحص الإيكو إن تم إجراؤه')
                    ->schema([
                        Textarea::make('clinicalExamination.liver_echo')
                            ->label('1. الكبد (Liver)')
                            ->rows(2)
                            ->placeholder('الحجم، الصدى، البنية، الكتل، SOL...'),

                        Textarea::make('clinicalExamination.gallbladder_echo')
                            ->label('2. المرارة (Gallbladder)')
                            ->rows(2)
                            ->placeholder('الحجم، الجدار، الحصيات، الطين...'),

                        Textarea::make('clinicalExamination.bile_ducts_echo')
                            ->label('3. الطرق الصفراوية (Bile Ducts)')
                            ->rows(2)
                            ->placeholder('CBD، القطر، التوسع، الحصيات...'),

                        Textarea::make('clinicalExamination.pancreas_echo')
                            ->label('4. البنكرياس (Pancreas)')
                            ->rows(2)
                            ->placeholder('الحجم، البنية، القناة، الكتل...'),

                        Textarea::make('clinicalExamination.spleen_echo')
                            ->label('5. الطحال (Spleen)')
                            ->rows(2)
                            ->placeholder('الحجم، التضخم، البنية...'),

                        Textarea::make('clinicalExamination.stomach_echo')
                            ->label('6. المعدة (Stomach)')
                            ->rows(2)
                            ->placeholder('الجدار، السائل...'),

                        Textarea::make('clinicalExamination.intestines_echo')
                            ->label('7. الأمعاء (Intestines)')
                            ->rows(2)
                            ->placeholder('سماكة الجدار، الانسداد، الالتهاب...'),

                        Textarea::make('clinicalExamination.abdominal_cavity_echo')
                            ->label('8. جوف البطن (Peritoneal Cavity)')
                            ->rows(2)
                            ->placeholder('السوائل، الحبن، الكتل...'),

                        Textarea::make('clinicalExamination.kidneys_echo')
                            ->label('9. الكليتين (Kidneys)')
                            ->rows(2)
                            ->placeholder('الحجم، الحصيات، التوسع الكأسي...'),

                        Textarea::make('clinicalExamination.uterus_appendages_echo')
                            ->label('10. الرحم والملحقات (للإناث)')
                            ->rows(2)
                            ->placeholder('الرحم، المبيضين، الكيسات...')
                            ->helperText('للمريضات الإناث فقط'),

                        Textarea::make('clinicalExamination.prostate_echo')
                            ->label('11. البروستات (للذكور)')
                            ->rows(2)
                            ->placeholder('الحجم، التضخم، البنية...')
                            ->helperText('للمرضى الذكور فقط'),

                        Textarea::make('clinicalExamination.other_echo')
                            ->label('12. موجودات أخرى')
                            ->rows(2)
                            ->placeholder('أي موجودات إضافية أو ملاحظات...'),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
