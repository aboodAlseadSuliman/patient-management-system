<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\Patient;
use App\Models\Medication;
use App\Models\ChronicDisease;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
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
                        Radio::make('timeline.onset')
                            ->label('1. البدء')
                            ->options([
                                'acute' => 'حاد',
                                'chronic' => 'مزمن',
                                'sudden' => 'مفاجئ',
                            ])
                            ->inline()
                            ->columnSpan(1),

                        Radio::make('timeline.frequency')
                            ->label('2. التكرار')
                            ->options([
                                'episodic' => 'نوبي',
                                'recurrent' => 'متكرر',
                                'continuous' => 'مستمر',
                            ])
                            ->inline()
                            ->columnSpan(1),

                        Radio::make('timeline.evolution')
                            ->label('3. التطور')
                            ->options([
                                'worsening' => 'تفاقم',
                                'stable' => 'ثابت',
                                'improving' => 'تراجع',
                            ])
                            ->inline()
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->collapsible(),

                // ==================== المربع الثالث: العوامل المحرضة ====================
                Section::make('العوامل المحرضة')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->description('ما يزيد أو يقلل الأعراض')
                    ->schema([
                        Checkbox::make('timeline.food_triggers')
                            ->label('1. محرضات غذائية')
                            ->inline(false),

                        Checkbox::make('timeline.psychological_triggers')
                            ->label('2. محرضات نفسية')
                            ->inline(false),

                        Checkbox::make('timeline.medication_triggers')
                            ->label('3. محرضات دوائية')
                            ->inline(false),

                        Checkbox::make('timeline.physical_triggers')
                            ->label('4. محرضات فيزيائية')
                            ->inline(false),

                        Checkbox::make('timeline.stimulant_triggers')
                            ->label('5. منبهات')
                            ->inline(false),

                        Checkbox::make('timeline.smoking_trigger')
                            ->label('6. التدخين')
                            ->inline(false),

                        Checkbox::make('timeline.other_triggers')
                            ->label('7. محرضات أخرى')
                            ->inline(false),

                        Textarea::make('timeline.triggers_notes')
                            ->label('📝 ملاحظات عامة عن العوامل المحرضة')
                            ->rows(3)
                            ->placeholder('أضف تفاصيل حول العوامل المحرضة المحددة أعلاه...')
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
                        Repeater::make('chronic_diseases_data')
                            ->label('🔄 الأمراض المزمنة للمريض')
                            ->schema([
                                Select::make('chronic_disease_id')
                                    ->label('المرض')
                                    ->required()
                                    ->options(ChronicDisease::query()->where('is_active', true)->pluck('name_ar', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
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
                                    ->columnSpan(1),

                                DatePicker::make('diagnosis_date')
                                    ->label('تاريخ التشخيص')
                                    ->placeholder('اختر التاريخ')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now())
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('الملاحظات')
                                    ->rows(2)
                                    ->placeholder('ملاحظات إضافية عن المرض...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                ChronicDisease::find($state['chronic_disease_id'] ?? null)?->name_ar ?? 'مرض جديد'
                            )
                            ->addActionLabel('+ إضافة مرض مزمن')
                            ->default(function (Get $get, $record) {
                                // عند التحرير: تحميل من ملف المريض
                                if ($record && $record->patient_id) {
                                    $patient = Patient::find($record->patient_id);
                                    if ($patient) {
                                        return $patient->chronicDiseases()
                                            ->where('patient_chronic_diseases.is_active', true)
                                            ->get()
                                            ->map(function ($disease) {
                                                return [
                                                    'chronic_disease_id' => $disease->id,
                                                    'diagnosis_date' => $disease->pivot->diagnosis_date,
                                                    'notes' => $disease->pivot->notes,
                                                ];
                                            })
                                            ->toArray();
                                    }
                                }

                                // عند الإنشاء: تحميل من patient_id المختار
                                $patientId = $get('patient_id');
                                if ($patientId) {
                                    $patient = Patient::find($patientId);
                                    if ($patient) {
                                        return $patient->chronicDiseases()
                                            ->where('patient_chronic_diseases.is_active', true)
                                            ->get()
                                            ->map(function ($disease) {
                                                return [
                                                    'chronic_disease_id' => $disease->id,
                                                    'diagnosis_date' => $disease->pivot->diagnosis_date,
                                                    'notes' => $disease->pivot->notes,
                                                ];
                                            })
                                            ->toArray();
                                    }
                                }

                                return [];
                            })
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->collapsed()
                            ->cloneable(),

                        // ⭐ الأدوية الدائمة
                        Repeater::make('permanent_medications_data')
                            ->label('💊 الأدوية الدائمة للمريض')
                            ->schema([
                                Select::make('medication_id')
                                    ->label('الدواء')
                                    ->required()
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
                                    ->createOptionForm([
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
                                    ->columnSpan(1),

                                TextInput::make('dosage')
                                    ->label('الجرعة')
                                    ->placeholder('مثال: 500mg')
                                    ->maxLength(100)
                                    ->columnSpan(1),

                                TextInput::make('frequency')
                                    ->label('التكرار')
                                    ->placeholder('مثال: مرتين يومياً')
                                    ->maxLength(100)
                                    ->columnSpan(1),

                                Select::make('route')
                                    ->label('طريقة التناول')
                                    ->options([
                                        'oral' => 'فموي',
                                        'injection' => 'حقن',
                                        'topical' => 'موضعي',
                                        'inhalation' => 'استنشاق',
                                        'rectal' => 'شرجي',
                                        'other' => 'أخرى'
                                    ])
                                    ->native(false)
                                    ->default('oral')
                                    ->columnSpan(1),

                                DatePicker::make('start_date')
                                    ->label('تاريخ البدء')
                                    ->placeholder('اختر التاريخ')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now())
                                    ->columnSpan(1),

                                DatePicker::make('end_date')
                                    ->label('تاريخ الإيقاف (اختياري)')
                                    ->placeholder('اختر التاريخ')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('الملاحظات')
                                    ->rows(2)
                                    ->placeholder('ملاحظات إضافية عن الدواء...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                Medication::find($state['medication_id'] ?? null)?->name_ar ?? 'دواء جديد'
                            )
                            ->addActionLabel('+ إضافة دواء دائم')
                            ->default(function (Get $get, $record) {
                                // عند التحرير: تحميل من ملف المريض
                                if ($record && $record->patient_id) {
                                    $patient = Patient::find($record->patient_id);
                                    if ($patient) {
                                        return $patient->permanentMedications()
                                            ->where('patient_permanent_medications.is_active', true)
                                            ->get()
                                            ->map(function ($medication) {
                                                return [
                                                    'medication_id' => $medication->id,
                                                    'dosage' => $medication->pivot->dosage,
                                                    'frequency' => $medication->pivot->frequency,
                                                    'route' => $medication->pivot->route ?? 'oral',
                                                    'start_date' => $medication->pivot->start_date,
                                                    'end_date' => $medication->pivot->end_date,
                                                    'notes' => $medication->pivot->notes,
                                                ];
                                            })
                                            ->toArray();
                                    }
                                }

                                // عند الإنشاء: تحميل من patient_id المختار
                                $patientId = $get('patient_id');
                                if ($patientId) {
                                    $patient = Patient::find($patientId);
                                    if ($patient) {
                                        return $patient->permanentMedications()
                                            ->where('patient_permanent_medications.is_active', true)
                                            ->get()
                                            ->map(function ($medication) {
                                                return [
                                                    'medication_id' => $medication->id,
                                                    'dosage' => $medication->pivot->dosage,
                                                    'frequency' => $medication->pivot->frequency,
                                                    'route' => $medication->pivot->route ?? 'oral',
                                                    'start_date' => $medication->pivot->start_date,
                                                    'end_date' => $medication->pivot->end_date,
                                                    'notes' => $medication->pivot->notes,
                                                ];
                                            })
                                            ->toArray();
                                    }
                                }

                                return [];
                            })
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->collapsed()
                            ->cloneable(),

                        // ⭐ حالات طبية أخرى (نص حر)
                        Textarea::make('timeline.medical_conditions')
                            ->label('📝 حالات طبية أخرى (اختياري)')
                            ->rows(2)
                            ->placeholder('معلومات طبية إضافية لا تدخل ضمن الأمراض المزمنة...')
                            ->helperText('للمعلومات النصية الإضافية فقط')
                            ->columnSpanFull(),

                        // ⭐ الجراحات السابقة
                        Repeater::make('timeline.previous_surgeries')
                            ->label('🏥 الجراحات السابقة')
                            ->schema([
                                TextInput::make('surgery_name')
                                    ->label('اسم الجراحة')
                                    ->required()
                                    ->placeholder('مثال: استئصال المرارة، تنظير المعدة...')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                DatePicker::make('surgery_date')
                                    ->label('تاريخ الجراحة')
                                    ->placeholder('اختر التاريخ')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now())
                                    ->columnSpan(1),

                                Textarea::make('details')
                                    ->label('التفاصيل')
                                    ->rows(2)
                                    ->placeholder('ملاحظات إضافية عن الجراحة...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                $state['surgery_name'] ?? 'جراحة جديدة'
                            )
                            ->addActionLabel('+ إضافة جراحة')
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->collapsed()
                            ->cloneable(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
