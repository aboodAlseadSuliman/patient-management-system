<?php

namespace App\Filament\Resources\Visits\Schemas;

use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\Medication;
use App\Models\ImagingStudy;
use Filament\Schemas\Schema;
use App\Models\ChronicDisease;
use App\Models\MedicalAbbreviation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Tabs\Tab;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('visit_tabs')
                    ->tabs([
                        // ==================== التبويب 1: المريض والزيارة ====================
                        Tab::make('المريض والزيارة')
                            ->icon('heroicon-o-user-circle')
                            ->badge(fn ($get) => $get('patient_id') ? '✓' : null)
                            ->badgeColor('success')
                            ->columns(4)
                            ->schema([
                                // المريض
                                Select::make('patient_id')
                                    ->label('المريض')
                                    ->relationship('patient', 'full_name')
                                    ->searchable(['full_name', 'file_number', 'phone'])
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->getOptionLabelFromRecordUsing(fn(Patient $record) => "{$record->full_name} - ملف: {$record->file_number}")
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $patient = Patient::with(['activePermanentMedications', 'activeChronicDiseases'])->find($state);
                                            $permanentMeds = $patient?->activePermanentMedications->map(function ($med) {
                                                return $med->name_ar . " - " . ($med->pivot->dosage ?? '') . " " . ($med->pivot->frequency ?? '');
                                            })->join("\n");
                                            $set('current_medications', $permanentMeds);
                                        }
                                    })
                                    ->columnSpan(2),

                                // تاريخ الزيارة
                                DatePicker::make('visit_date')
                                    ->label('تاريخ الزيارة')
                                    ->required()
                                    ->default(now())
                                    ->columnSpan(1),

                                // نوع الزيارة
                                Select::make('visit_type')
                                    ->label('نوع الزيارة')
                                    ->options([
                                        'first' => '🆕 زيارة أولى',
                                        'followup' => '🔄 متابعة',
                                        'emergency' => '🚨 طوارئ',
                                    ])
                                    ->default('followup')
                                    ->required()
                                    ->columnSpan(1),
                            ]),

                        // ==================== التبويب 2: الشكوى والفحص ====================
                        Tab::make('الشكوى والفحص')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->badge(fn ($get) => $get('chief_complaint') ? '✓' : null)
                            ->badgeColor('success')
                            ->columns(4)
                            ->schema([
                                // الشكوى الرئيسية
                                Textarea::make('chief_complaint')
                                    ->label('الشكوى الرئيسية')
                                    ->rows(2)
                                    ->placeholder('مثال: صداع، حمى، غثيان... (استخدم الاختصارات)')
                                    ->hint('الاختصارات المتاحة: ' . MedicalAbbreviation::active()->limit(5)->pluck('abbreviation')->join('، '))
                                    ->hintIcon('heroicon-o-light-bulb')
                                    ->columnSpan(2),

                                // الأعراض المصاحبة
                                Textarea::make('associated_symptoms')
                                    ->label('الأعراض المصاحبة')
                                    ->rows(2)
                                    ->placeholder('الأعراض الأخرى...')
                                    ->columnSpan(2),

                                // شدة الأعراض
                                Select::make('severity')
                                    ->label('شدة الأعراض')
                                    ->options([
                                        'mild' => '🟢 خفيف',
                                        'moderate' => '🟡 متوسط',
                                        'severe' => '🔴 شديد',
                                    ])
                                    ->default('moderate')
                                    ->columnSpan(1),

                                // المدة
                                TextInput::make('duration')
                                    ->label('مدة الأعراض')
                                    ->placeholder('مثال: 3 أيام، أسبوع...')
                                    ->columnSpan(1),

                                // العلامات الحيوية
                                Textarea::make('vital_signs')
                                    ->label('العلامات الحيوية')
                                    ->rows(2)
                                    ->placeholder('BP: 120/80, HR: 75, Temp: 37°C, RR: 18, O2: 98%')
                                    ->helperText('الضغط، النبض، الحرارة، التنفس، الأكسجين')
                                    ->columnSpan(2),

                                // الفحص السريري
                                Textarea::make('physical_examination')
                                    ->label('الفحص السريري')
                                    ->rows(3)
                                    ->placeholder('نتائج الفحص السريري...')
                                    ->columnSpan(4),
                            ]),

                        // ==================== التبويب 3: التاريخ المرضي ====================
                        Tab::make('التاريخ المرضي')
                            ->icon('heroicon-o-clock')
                            ->columns(4)
                            ->schema([
                                // الأمراض المزمنة
                                Select::make('chronic_diseases')
                                    ->label('🩺 الأمراض المزمنة')
                                    ->multiple()
                                    ->relationship('patient.chronicDiseases', 'name_ar')
                                    ->options(ChronicDisease::active()->pluck('name_ar', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->createOptionUsing(function (string $value): int {
                                        $disease = ChronicDisease::create([
                                            'name_ar' => $value,
                                            'name_en' => null,
                                            'is_active' => true,
                                        ]);
                                        return $disease->id;
                                    })
                                    ->hint('يمكنك إضافة مرض جديد مباشرة')
                                    ->hintIcon('heroicon-o-plus-circle')
                                    ->columnSpan(2),

                                // الأدوية الحالية (الدائمة)
                                Textarea::make('current_medications')
                                    ->label('💊 الأدوية الحالية (الدائمة)')
                                    ->rows(3)
                                    ->disabled()
                                    ->dehydrated()
                                    ->hint('تم تحميلها تلقائياً من بيانات المريض')
                                    ->columnSpan(2),

                                // العمليات السابقة
                                Textarea::make('previous_surgeries')
                                    ->label('🔪 العمليات الجراحية السابقة')
                                    ->rows(2)
                                    ->placeholder('العمليات السابقة إن وجدت...')
                                    ->columnSpan(2),

                                // تطور الحالة
                                Textarea::make('evolution')
                                    ->label('تطور الحالة')
                                    ->rows(2)
                                    ->placeholder('كيف تطورت الأعراض...')
                                    ->columnSpan(2),

                                // المحفزات
                                Textarea::make('triggers')
                                    ->label('المحفزات والعوامل المؤثرة')
                                    ->rows(2)
                                    ->placeholder('ما الذي يزيد أو يقلل الأعراض...')
                                    ->columnSpan(4),
                            ]),

                        // ==================== التبويب 4: التشخيص والفحوصات ====================
                        Tab::make('التشخيص والفحوصات')
                            ->icon('heroicon-o-beaker')
                            ->badge(fn ($get) => $get('diagnosis') ? '✓' : null)
                            ->badgeColor('success')
                            ->columns(4)
                            ->schema([
                                // التشخيص
                                Select::make('diagnosis')
                                    ->label('🔍 التشخيص')
                                    ->options(function () {
                                        return Diagnosis::active()
                                            ->orderBy('usage_count', 'desc')
                                            ->pluck('name_ar', 'name_ar')
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->createOptionUsing(function (string $value): string {
                                        Diagnosis::create([
                                            'name_ar' => $value,
                                            'name_en' => null,
                                            'is_active' => true,
                                            'usage_count' => 0,
                                        ]);
                                        return $value;
                                    })
                                    ->afterStateUpdated(function ($state) {
                                        if ($state) {
                                            $diagnosis = Diagnosis::where('name_ar', $state)->first();
                                            $diagnosis?->incrementUsage();
                                        }
                                    })
                                    ->hint('الأكثر استخداماً أولاً')
                                    ->hintIcon('heroicon-o-plus-circle')
                                    ->columnSpan(2),

                                // الحالة العامة
                                Select::make('general_condition')
                                    ->label('⚕️ الحالة العامة')
                                    ->options([
                                        'excellent' => '⭐ ممتازة',
                                        'good' => '✅ جيدة',
                                        'fair' => '⚠️ متوسطة',
                                        'poor' => '❌ سيئة',
                                    ])
                                    ->default('good')
                                    ->columnSpan(2),

                                // التحاليل المطلوبة
                                Select::make('lab_tests')
                                    ->label('🧪 التحاليل المطلوبة')
                                    ->multiple()
                                    ->relationship('labTests', 'name_ar')
                                    ->options(function () {
                                        return LabTest::active()
                                            ->orderBy('usage_count', 'desc')
                                            ->get()
                                            ->mapWithKeys(function ($test) {
                                                $label = $test->name_ar;
                                                if ($test->abbreviation) {
                                                    $label .= " ({$test->abbreviation})";
                                                }
                                                return [$test->id => $label];
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->createOptionUsing(function (string $value): int {
                                        $test = LabTest::create([
                                            'name_ar' => $value,
                                            'name_en' => null,
                                            'category' => 'blood',
                                            'is_active' => true,
                                        ]);
                                        return $test->id;
                                    })
                                    ->afterStateUpdated(function ($state) {
                                        if ($state && is_array($state)) {
                                            foreach ($state as $testId) {
                                                LabTest::find($testId)?->incrementUsage();
                                            }
                                        }
                                    })
                                    ->hint('الأكثر طلباً أولاً')
                                    ->hintIcon('heroicon-o-plus-circle')
                                    ->columnSpan(2),

                                // الأشعة والتصوير المطلوب
                                Select::make('imaging_studies')
                                    ->label('📸 الأشعة والتصوير')
                                    ->multiple()
                                    ->relationship('imagingStudies', 'name_ar')
                                    ->options(function () {
                                        return ImagingStudy::active()
                                            ->orderBy('usage_count', 'desc')
                                            ->get()
                                            ->mapWithKeys(function ($study) {
                                                $label = $study->name_ar;
                                                if ($study->body_part) {
                                                    $label .= " - {$study->body_part}";
                                                }
                                                return [$study->id => $label];
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->createOptionUsing(function (string $value): int {
                                        $study = ImagingStudy::create([
                                            'name_ar' => $value,
                                            'name_en' => null,
                                            'type' => 'x-ray',
                                            'is_active' => true,
                                        ]);
                                        return $study->id;
                                    })
                                    ->afterStateUpdated(function ($state) {
                                        if ($state && is_array($state)) {
                                            foreach ($state as $studyId) {
                                                ImagingStudy::find($studyId)?->incrementUsage();
                                            }
                                        }
                                    })
                                    ->hint('الأكثر طلباً أولاً')
                                    ->hintIcon('heroicon-o-plus-circle')
                                    ->columnSpan(2),

                                // تفاصيل إضافية للفحوصات
                                Textarea::make('requested_investigations')
                                    ->label('📋 تفاصيل إضافية للفحوصات')
                                    ->rows(2)
                                    ->placeholder('أي تفاصيل أو ملاحظات إضافية...')
                                    ->columnSpan(2),

                                // نتائج الأشعة
                                Textarea::make('radiology_findings')
                                    ->label('نتائج الأشعة')
                                    ->rows(2)
                                    ->placeholder('نتائج الأشعة التي تم إجراؤها...')
                                    ->columnSpan(2),

                                // نتائج المناظير
                                Textarea::make('endoscopy_findings')
                                    ->label('نتائج المناظير')
                                    ->rows(2)
                                    ->placeholder('نتائج المناظير إن وجدت...')
                                    ->columnSpan(4),
                            ]),

                        // ==================== التبويب 5: العلاج والمتابعة ====================
                        Tab::make('العلاج والمتابعة')
                            ->icon('heroicon-o-heart')
                            ->badge(fn ($get) => $get('prescription') ? '✓' : null)
                            ->badgeColor('success')
                            ->columns(4)
                            ->schema([
                                // الأدوية الموصوفة
                                Select::make('prescribed_medications')
                                    ->label('💊 الأدوية الموصوفة')
                                    ->multiple()
                                    ->options(function () {
                                        return Medication::active()
                                            ->get()
                                            ->mapWithKeys(function ($med) {
                                                $label = $med->name_ar;
                                                if ($med->strength) {
                                                    $label .= " ({$med->strength})";
                                                }
                                                return [$med->id => $label];
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->hint('اختر الأدوية من القائمة')
                                    ->helperText('سيتم ملء الوصفة تلقائياً')
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $medications = Medication::whereIn('id', $state)->get();
                                            $prescription = $medications->map(function ($med) {
                                                return $med->name_ar .
                                                    ($med->strength ? " {$med->strength}" : '') .
                                                    ($med->common_dosage ? " - {$med->common_dosage}" : '');
                                            })->join("\n");
                                            $set('prescription', $prescription);
                                        }
                                    })
                                    ->columnSpan(2),

                                // الوصفة الطبية النهائية
                                Textarea::make('prescription')
                                    ->label('📝 الوصفة الطبية')
                                    ->rows(4)
                                    ->placeholder('يتم ملؤها تلقائياً أو اكتب يدوياً...')
                                    ->helperText('كل دواء في سطر: اسم الدواء - الجرعة - التكرار')
                                    ->columnSpan(2),

                                // خطة العلاج
                                Textarea::make('proposed_treatment')
                                    ->label('📋 خطة العلاج والتعليمات')
                                    ->rows(3)
                                    ->placeholder('تعليمات، نصائح، متابعة، راحة، حمية...')
                                    ->columnSpan(4),

                                // تاريخ المراجعة
                                DatePicker::make('next_visit_date')
                                    ->label('📅 موعد المراجعة القادمة')
                                    ->hint('إذا كانت هناك حاجة لمتابعة')
                                    ->columnSpan(2),

                                // حالة الزيارة
                                Toggle::make('is_completed')
                                    ->label('✅ الزيارة مكتملة')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(2),

                                // ملاحظات خاصة
                                Textarea::make('doctor_notes')
                                    ->label('📝 ملاحظات الطبيب الخاصة')
                                    ->rows(2)
                                    ->placeholder('أي ملاحظات إضافية...')
                                    ->columnSpan(4),
                            ]),
                    ])
                    ->persistTabInQueryString('tab')
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }
}