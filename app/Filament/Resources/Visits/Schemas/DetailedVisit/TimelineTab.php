<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\Patient;
use App\Models\Medication;
use App\Models\ChronicDisease;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

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
                    ->description('السوابق الطبية والجراحية - يتم المزامنة مع ملف المريض تلقائياً')
                    ->schema([
                        // ⭐ الأمراض المزمنة
                        Select::make('chronic_diseases_sync')
                            ->label('🔄 الأمراض المزمنة للمريض')
                            ->multiple()
                            ->options(ChronicDisease::query()->where('is_active', true)->pluck('name_ar', 'id'))
                            ->searchable()
                            ->preload()
                            ->default(function (Get $get, $record) {
                                // عند التحرير: تحميل من ملف المريض
                                if ($record && $record->patient_id) {
                                    return Patient::find($record->patient_id)
                                        ?->chronicDiseases()
                                        ->where('patient_chronic_diseases.is_active', true)
                                        ->pluck('chronic_diseases.id')
                                        ->toArray() ?? [];
                                }

                                // عند الإنشاء: تحميل من patient_id المختار
                                $patientId = $get('patient_id');
                                if ($patientId) {
                                    return Patient::find($patientId)
                                        ?->chronicDiseases()
                                        ->where('patient_chronic_diseases.is_active', true)
                                        ->pluck('chronic_diseases.id')
                                        ->toArray() ?? [];
                                }

                                return [];
                            })
                            ->live()
                            ->createOptionForm([
                                Section::make('إضافة مرض مزمن جديد')
                                    ->icon('heroicon-o-plus-circle')
                                    ->schema([
                                        TextInput::make('name_ar')
                                            ->label('اسم المرض بالعربية')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('مثال: السكري النوع 2')
                                            ->columnSpan(2),

                                        TextInput::make('name_en')
                                            ->label('اسم المرض بالإنجليزية')
                                            ->maxLength(255)
                                            ->placeholder('مثال: Diabetes Type 2')
                                            ->columnSpan(2),

                                        TextInput::make('abbreviation')
                                            ->label('الاختصار')
                                            ->maxLength(50)
                                            ->placeholder('مثال: DM2')
                                            ->columnSpan(1),

                                        TextInput::make('icd_code')
                                            ->label('كود التصنيف الدولي (ICD)')
                                            ->maxLength(20)
                                            ->placeholder('مثال: E11')
                                            ->columnSpan(1),

                                        Textarea::make('description')
                                            ->label('الوصف')
                                            ->rows(2)
                                            ->placeholder('وصف المرض وأعراضه...')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4)
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $disease = ChronicDisease::create($data);

                                Notification::make()
                                    ->title('تم إضافة المرض المزمن بنجاح')
                                    ->body($disease->name_ar)
                                    ->success()
                                    ->icon('heroicon-o-check-circle')
                                    ->send();

                                return $disease->id;
                            })
                            ->createOptionModalHeading('إضافة مرض مزمن جديد للنظام')
                            ->helperText(function (Get $get, $record) {
                                // عرض القيم الحالية للطبيب
                                $patientId = $record?->patient_id ?? $get('patient_id');
                                if (!$patientId) {
                                    return '✓ يتم حفظ التعديلات في ملف المريض مباشرة | يمكنك الإضافة من زر (+)';
                                }

                                $patient = Patient::find($patientId);
                                if (!$patient) {
                                    return '✓ يتم حفظ التعديلات في ملف المريض مباشرة | يمكنك الإضافة من زر (+)';
                                }

                                $diseases = $patient->chronicDiseases()
                                    ->where('patient_chronic_diseases.is_active', true)
                                    ->get();

                                if ($diseases->isEmpty()) {
                                    return '📋 لا توجد أمراض مزمنة مسجلة حالياً في ملف المريض';
                                }

                                $diseasesList = $diseases->pluck('name_ar')->implode('، ');
                                return "📋 الأمراض المزمنة الحالية: {$diseasesList}";
                            })
                            ->columnSpanFull(),

                        // ⭐ الأدوية الدائمة
                        Select::make('permanent_medications_sync')
                            ->label('💊 الأدوية الدائمة للمريض')
                            ->multiple()
                            ->options(function () {
                                return Medication::query()
                                    ->where('is_active', true)
                                    ->get()
                                    ->mapWithKeys(function ($med) {
                                        $label = $med->name_ar;
                                        if ($med->strength) {
                                            $label .= " ({$med->strength})";
                                        }
                                        if ($med->generic_name) {
                                            $label .= " - {$med->generic_name}";
                                        }
                                        return [$med->id => $label];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->default(function (Get $get, $record) {
                                // عند التحرير: تحميل من ملف المريض
                                if ($record && $record->patient_id) {
                                    return Patient::find($record->patient_id)
                                        ?->permanentMedications()
                                        ->where('is_active', true)
                                        ->pluck('medication_id')
                                        ->toArray() ?? [];
                                }

                                // عند الإنشاء: تحميل من patient_id المختار
                                $patientId = $get('patient_id');
                                if ($patientId) {
                                    return Patient::find($patientId)
                                        ?->permanentMedications()
                                        ->where('is_active', true)
                                        ->pluck('medication_id')
                                        ->toArray() ?? [];
                                }

                                return [];
                            })
                            ->live()
                            ->createOptionForm([
                                Section::make('إضافة دواء جديد')
                                    ->icon('heroicon-o-plus-circle')
                                    ->schema([
                                        TextInput::make('name_ar')
                                            ->label('اسم الدواء بالعربية')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('مثال: ميتفورمين')
                                            ->columnSpan(2),

                                        TextInput::make('name_en')
                                            ->label('اسم الدواء بالإنجليزية')
                                            ->maxLength(255)
                                            ->placeholder('مثال: Metformin')
                                            ->columnSpan(2),

                                        TextInput::make('generic_name')
                                            ->label('الاسم العلمي')
                                            ->maxLength(255)
                                            ->placeholder('مثال: Metformin HCL')
                                            ->columnSpan(2),

                                        TextInput::make('brand_name')
                                            ->label('الاسم التجاري')
                                            ->maxLength(255)
                                            ->placeholder('مثال: Glucophage')
                                            ->columnSpan(2),

                                        Select::make('dosage_form')
                                            ->label('الشكل الدوائي')
                                            ->options([
                                                'tablet' => 'مضغوطة',
                                                'capsule' => 'كبسولة',
                                                'syrup' => 'شراب',
                                                'injection' => 'حقنة',
                                                'cream' => 'كريم',
                                                'ointment' => 'مرهم',
                                                'drops' => 'قطرة',
                                                'spray' => 'رذاذ',
                                                'inhaler' => 'بخاخ',
                                                'suppository' => 'تحميلة',
                                                'patch' => 'لصاقة',
                                                'other' => 'أخرى'
                                            ])
                                            ->required()
                                            ->native(false)
                                            ->columnSpan(2),

                                        TextInput::make('strength')
                                            ->label('التركيز')
                                            ->maxLength(50)
                                            ->placeholder('مثال: 500mg')
                                            ->columnSpan(2),

                                        TextInput::make('manufacturer')
                                            ->label('الشركة المصنعة')
                                            ->maxLength(255)
                                            ->placeholder('مثال: Sanofi')
                                            ->columnSpan(2),

                                        TextInput::make('common_dosage')
                                            ->label('الجرعة الشائعة')
                                            ->maxLength(255)
                                            ->placeholder('مثال: 500mg مرتين يومياً')
                                            ->columnSpan(2),

                                        Textarea::make('description')
                                            ->label('الوصف')
                                            ->rows(2)
                                            ->placeholder('وصف الدواء واستخداماته...')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4)
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $medication = Medication::create($data);

                                Notification::make()
                                    ->title('تم إضافة الدواء بنجاح')
                                    ->body($medication->name_ar)
                                    ->success()
                                    ->icon('heroicon-o-check-circle')
                                    ->send();

                                return $medication->id;
                            })
                            ->createOptionModalHeading('إضافة دواء جديد للنظام')
                            ->helperText(function (Get $get, $record) {
                                // عرض القيم الحالية للطبيب
                                $patientId = $record?->patient_id ?? $get('patient_id');
                                if (!$patientId) {
                                    return '✓ يتم حفظ التعديلات في ملف المريض مباشرة | يمكنك الإضافة من زر (+)';
                                }

                                $patient = Patient::find($patientId);
                                if (!$patient) {
                                    return '✓ يتم حفظ التعديلات في ملف المريض مباشرة | يمكنك الإضافة من زر (+)';
                                }

                                $medications = $patient->permanentMedications()
                                    ->where('patient_permanent_medications.is_active', true)
                                    ->get();

                                if ($medications->isEmpty()) {
                                    return '💊 لا توجد أدوية دائمة مسجلة حالياً في ملف المريض';
                                }

                                $medicationsList = $medications->map(function ($med) {
                                    $text = $med->name_ar;
                                    if ($med->strength) {
                                        $text .= ' (' . $med->strength . ')';
                                    }
                                    return $text;
                                })->implode('، ');

                                return "💊 الأدوية الدائمة الحالية: {$medicationsList}";
                            })
                            ->columnSpanFull(),

                        // ⭐ حالات طبية أخرى (نص حر)
                        Textarea::make('timeline.medical_conditions')
                            ->label('📝 حالات طبية أخرى (اختياري)')
                            ->rows(2)
                            ->placeholder('معلومات طبية إضافية لا تدخل ضمن الأمراض المزمنة...')
                            ->helperText('للمعلومات النصية الإضافية فقط')
                            ->columnSpanFull(),

                        // ⭐ الجراحات السابقة
                        Textarea::make('timeline.previous_surgeries')
                            ->label('🏥 الجراحات السابقة')
                            ->rows(3)
                            ->placeholder('العمليات الجراحية وتواريخها...')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
