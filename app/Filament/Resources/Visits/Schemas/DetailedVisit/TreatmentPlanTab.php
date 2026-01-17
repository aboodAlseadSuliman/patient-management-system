<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class TreatmentPlanTab
{
    public static function make(): Tab
    {
        return Tab::make('خطة العلاج')
            ->icon('heroicon-o-clipboard-document-check')
            ->badge(fn($get) => $get('treatmentPlan.medication_name') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. التعليمات والحمية ====================
                Section::make('التعليمات والحمية')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('تعليمات غذائية ونصائح حسب التشخيص')
                    ->schema([
                        Checkbox::make('treatmentPlan.gerd_instructions')
                            ->label('1. القلس المريئي (GERD)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.dyspepsia_instructions')
                            ->label('2. عسر الهضم')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.ibs_instructions')
                            ->label('3. تشنج الكولون (IBS)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.constipation_instructions')
                            ->label('4. الإمساك')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.gastroenteritis_instructions')
                            ->label('5. التهاب الأمعاء')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.celiac_instructions')
                            ->label('6. الداء الزلاقي (Celiac)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.ibd_instructions')
                            ->label('7. الداء المعوي الالتهابي (IBD)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.hemorrhoids_fissure_instructions')
                            ->label('8. البواسير والشق الشرجي')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.hepatitis_a_instructions')
                            ->label('9. التهاب الكبد A')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.hepatitis_b_instructions')
                            ->label('10. التهاب الكبد B')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.cirrhosis_instructions')
                            ->label('11. تشمع الكبد')
                            ->inline(false),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== 2. الأدوية الموصوفة ====================
                Section::make('الأدوية الموصوفة')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Repeater::make('medicationsData')
                            ->label('الأدوية')
                            ->schema([
                                Select::make('medication_id')
                                    ->label('اسم الدواء')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->options(function () {
                                        return \App\Models\Medication::where('is_active', true)
                                            ->orderBy('name_ar')
                                            ->get()
                                            ->mapWithKeys(function ($medication) {
                                                $label = $medication->name_ar;
                                                if ($medication->strength) {
                                                    $label .= " ({$medication->strength})";
                                                }
                                                if ($medication->dosage_form) {
                                                    $forms = [
                                                        'tablet' => 'حبوب',
                                                        'capsule' => 'كبسولات',
                                                        'syrup' => 'شراب',
                                                        'injection' => 'حقن',
                                                        'cream' => 'كريم',
                                                        'ointment' => 'مرهم',
                                                        'drops' => 'قطرة',
                                                        'spray' => 'رذاذ',
                                                        'inhaler' => 'بخاخ',
                                                        'suppository' => 'تحاميل',
                                                        'patch' => 'لصقة',
                                                        'other' => 'أخرى',
                                                    ];
                                                    $label .= ' - ' . ($forms[$medication->dosage_form] ?? $medication->dosage_form);
                                                }
                                                return [$medication->id => $label];
                                            });
                                    })
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('الاسم بالعربية')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('name_en')
                                            ->label('الاسم بالإنجليزية')
                                            ->maxLength(255),

                                        Select::make('dosage_form')
                                            ->label('الشكل الدوائي')
                                            ->options([
                                                'tablet' => 'حبوب',
                                                'capsule' => 'كبسولات',
                                                'syrup' => 'شراب',
                                                'injection' => 'حقن',
                                                'cream' => 'كريم',
                                                'ointment' => 'مرهم',
                                                'drops' => 'قطرة',
                                                'spray' => 'رذاذ',
                                                'inhaler' => 'بخاخ',
                                                'suppository' => 'تحاميل',
                                                'patch' => 'لصقة',
                                                'other' => 'أخرى',
                                            ])
                                            ->required(),

                                        TextInput::make('strength')
                                            ->label('التركيز')
                                            ->placeholder('مثال: 500mg, 10ml, 5%')
                                            ->maxLength(100),

                                        TextInput::make('generic_name')
                                            ->label('الاسم العلمي')
                                            ->maxLength(255),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $data['is_active'] = true;
                                        return \App\Models\Medication::create($data)->id;
                                    })
                                    ->columnSpan(2),

                                TextInput::make('dosage')
                                    ->label('الجرعة')
                                    ->placeholder('مثال: حبة واحدة، ملعقة صغيرة، 5ml')
                                    ->columnSpan(1),

                                TextInput::make('frequency')
                                    ->label('عدد المرات')
                                    ->placeholder('مثال: 3 مرات يومياً، كل 8 ساعات')
                                    ->columnSpan(1),

                                TextInput::make('duration')
                                    ->label('المدة')
                                    ->placeholder('مثال: 7 أيام، أسبوعين، شهر')
                                    ->columnSpan(1),

                                TextInput::make('instructions')
                                    ->label('تعليمات الاستخدام')
                                    ->placeholder('مثال: قبل الأكل، بعد الأكل، مع الماء')
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات إضافية')
                                    ->placeholder('أي ملاحظات خاصة بهذا الدواء...')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                \App\Models\Medication::find($state['medication_id'])?->name_ar ?? 'دواء جديد'
                            )
                            ->addActionLabel('إضافة دواء')
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record) {
                                    $record->load('medications');

                                    if ($record->medications->count() > 0) {
                                        $data = $record->medications->map(function ($medication) {
                                            return [
                                                'medication_id' => $medication->id,
                                                'dosage' => $medication->pivot->dosage,
                                                'frequency' => $medication->pivot->frequency,
                                                'duration' => $medication->pivot->duration,
                                                'notes' => $medication->pivot->notes,
                                            ];
                                        })->toArray();

                                        $component->state($data);
                                    }
                                }
                            }),
                    ])
                    ->collapsible(),


                // ==================== 3. التحاليل المطلوبة ====================
                Section::make('التحاليل المطلوبة')
                    ->icon('heroicon-o-beaker')
                    ->description('اختر طريقة إدخال التحاليل المناسبة لك')
                    ->schema([
                        Radio::make('lab_tests_input_method')
                            ->label('طريقة إدخال التحاليل')
                            ->options([
                                'detailed' => 'تفصيلية - ملاحظات لكل تحليل على حدة',
                                'simple' => 'بسيطة - اختيار متعدد مع ملاحظات عامة',
                            ])
                            ->default('detailed')
                            ->inline()
                            ->live()
                            ->columnSpanFull(),

                        // الطريقة الأولى: Repeater (تفصيلية)
                        Repeater::make('labTestsData')
                            ->label('التحاليل المطلوبة (الطريقة التفصيلية)')
                            ->schema([
                                Select::make('lab_test_id')
                                    ->label('اسم التحليل')
                                    ->options(function () {
                                        return \App\Models\LabTest::where('is_active', true)
                                            ->orderBy('category')
                                            ->orderBy('name_ar')
                                            ->get()
                                            ->mapWithKeys(function ($labTest) {
                                                $label = $labTest->name_ar;
                                                if ($labTest->abbreviation) {
                                                    $label .= " ({$labTest->abbreviation})";
                                                }
                                                if ($labTest->name_en) {
                                                    $label .= " - {$labTest->name_en}";
                                                }
                                                return [$labTest->id => $label];
                                            });
                                    })
                                    ->searchable()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live()
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('الاسم بالعربية')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('name_en')
                                            ->label('الاسم بالإنجليزية')
                                            ->maxLength(255),

                                        TextInput::make('abbreviation')
                                            ->label('الاختصار')
                                            ->maxLength(50),

                                        Select::make('category')
                                            ->label('الفئة')
                                            ->options([
                                                'blood' => 'تحاليل الدم',
                                                'urine' => 'تحاليل البول',
                                                'stool' => 'تحاليل البراز',
                                                'biochemistry' => 'كيمياء حيوية',
                                                'immunology' => 'مناعة',
                                                'microbiology' => 'ميكروبيولوجي',
                                                'hormones' => 'هرمونات',
                                                'tumor_markers' => 'علامات الأورام',
                                                'other' => 'أخرى',
                                            ])
                                            ->required(),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $data['is_active'] = true;
                                        $data['usage_count'] = 0;
                                        return \App\Models\LabTest::create($data)->id;
                                    })
                                    ->columnSpan(2),

                                Textarea::make('notes')
                                    ->label('التعليمات والملاحظات')
                                    ->placeholder('مثال: يجب أن يكون على ريق 8 ساعات، قبل العشاء، إلخ...')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                \App\Models\LabTest::find($state['lab_test_id'])?->name_ar ?? 'تحليل جديد'
                            )
                            ->addActionLabel('إضافة تحليل')
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->visible(fn($get) => $get('lab_tests_input_method') === 'detailed')
                            ->afterStateHydrated(function ($component, $state, $record) {
                                \Log::info('TreatmentPlanTab - afterStateHydrated called', [
                                    'has_record' => $record !== null,
                                    'record_id' => $record?->id,
                                ]);

                                if ($record) {
                                    // تحميل العلاقة بشكل صريح
                                    $record->load('labTests');

                                    \Log::info('TreatmentPlanTab - Lab tests count', [
                                        'count' => $record->labTests->count(),
                                    ]);

                                    if ($record->labTests->count() > 0) {
                                        $data = $record->labTests->map(function ($labTest) {
                                            return [
                                                'lab_test_id' => $labTest->id,
                                                'notes' => $labTest->pivot->notes,
                                            ];
                                        })->toArray();

                                        \Log::info('TreatmentPlanTab - Setting state', ['data' => $data]);
                                        $component->state($data);
                                    }
                                }
                            }),

                        // الطريقة الثانية: Select متعدد (بسيطة)
                        Select::make('labTestsSimple')
                            ->label('التحاليل المطلوبة (الطريقة البسيطة)')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return \App\Models\LabTest::where('is_active', true)
                                    ->orderBy('category')
                                    ->orderBy('name_ar')
                                    ->get()
                                    ->mapWithKeys(function ($labTest) {
                                        $label = $labTest->name_ar;
                                        if ($labTest->abbreviation) {
                                            $label .= " ({$labTest->abbreviation})";
                                        }
                                        if ($labTest->name_en) {
                                            $label .= " - {$labTest->name_en}";
                                        }
                                        return [$labTest->id => $label];
                                    });
                            })
                            ->placeholder('اختر التحاليل المطلوبة...')
                            ->helperText('يمكنك اختيار عدة تحاليل مرة واحدة')
                            ->createOptionForm([
                                TextInput::make('name_ar')
                                    ->label('الاسم بالعربية')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('name_en')
                                    ->label('الاسم بالإنجليزية')
                                    ->maxLength(255),

                                TextInput::make('abbreviation')
                                    ->label('الاختصار')
                                    ->maxLength(50),

                                Select::make('category')
                                    ->label('الفئة')
                                    ->options([
                                        'blood' => 'تحاليل الدم',
                                        'urine' => 'تحاليل البول',
                                        'stool' => 'تحاليل البراز',
                                        'biochemistry' => 'كيمياء حيوية',
                                        'immunology' => 'مناعة',
                                        'microbiology' => 'ميكروبيولوجي',
                                        'hormones' => 'هرمونات',
                                        'tumor_markers' => 'علامات الأورام',
                                        'other' => 'أخرى',
                                    ])
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $data['is_active'] = true;
                                $data['usage_count'] = 0;
                                return \App\Models\LabTest::create($data)->id;
                            })
                            ->columnSpanFull()
                            ->visible(fn($get) => $get('lab_tests_input_method') === 'simple')
                            ->afterStateHydrated(function ($component, $state, $record, $get) {
                                if ($record) {
                                    $record->load('labTests');
                                    if ($record->labTests->count() > 0) {
                                        $testIds = $record->labTests->pluck('id')->toArray();
                                        $component->state($testIds);
                                    }
                                }
                            }),

                        Textarea::make('labTestsSimpleNotes')
                            ->label('الملاحظات والتعليمات العامة')
                            ->placeholder('مثال: جميع التحاليل على الريق، تجنب الأدوية قبل التحليل...')
                            ->rows(3)
                            ->columnSpanFull()
                            ->visible(fn($get) => $get('lab_tests_input_method') === 'simple'),
                    ])
                    ->collapsible(),



                // ==================== 4. الأشعة المطلوبة ====================
                Section::make('الأشعة المطلوبة')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        Repeater::make('imagingStudiesData')
                            ->label('الأشعة')
                            ->schema([
                                Select::make('attachment_type_id')
                                    ->label('نوع الأشعة')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->options(function () {
                                        return \App\Models\AttachmentType::where('is_active', true)
                                            ->where('category', 'imaging')
                                            ->ordered()
                                            ->get()
                                            ->mapWithKeys(function ($type) {
                                                return [$type->id => $type->full_name];
                                            });
                                    })
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('الاسم بالعربية')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('name_en')
                                            ->label('الاسم بالإنجليزية')
                                            ->maxLength(255),

                                        TextInput::make('icon')
                                            ->label('الأيقونة')
                                            ->default('📷')
                                            ->required()
                                            ->maxLength(10),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $maxOrder = \App\Models\AttachmentType::max('display_order') ?? 0;
                                        $data['category'] = 'imaging';
                                        $data['display_order'] = $maxOrder + 1;
                                        $data['is_active'] = true;
                                        return \App\Models\AttachmentType::create($data)->id;
                                    })
                                    ->columnSpan(2),

                                Textarea::make('notes')
                                    ->label('ملاحظات وتعليمات')
                                    ->placeholder('مثال: على الريق، مع الصبغة، بدون صبغة، مع تباين...')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                \App\Models\AttachmentType::find($state['attachment_type_id'])?->full_name ?? 'أشعة جديدة'
                            )
                            ->addActionLabel('إضافة أشعة')
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record) {
                                    // تحميل طلبات الأشعة من visit_imaging_studies
                                    $imagingRequests = \DB::table('visit_imaging_studies')
                                        ->where('visit_id', $record->id)
                                        ->get();

                                    if ($imagingRequests->count() > 0) {
                                        $data = $imagingRequests->map(function ($request) {
                                            return [
                                                'attachment_type_id' => $request->attachment_type_id,
                                                'notes' => $request->notes,
                                            ];
                                        })->toArray();

                                        $component->state($data);
                                    }
                                }
                            }),
                    ])
                    ->collapsible(),

                // ==================== 5. التنظير ====================
                Section::make('التنظير المطلوب')
                    ->icon('heroicon-o-magnifying-glass-circle')
                    ->schema([
                        Checkbox::make('treatmentPlan.needs_upper_endoscopy')
                            ->label('تنظير علوي (Upper Endoscopy)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.needs_colonoscopy')
                            ->label('تنظير سفلي (Colonoscopy)')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.needs_ercp')
                            ->label('ERCP')
                            ->inline(false),

                        Checkbox::make('treatmentPlan.needs_guided_biopsy')
                            ->label('خزعة موجهة (Guided Biopsy)')
                            ->inline(false),

                        Textarea::make('treatmentPlan.endoscopy_notes')
                            ->label('ملاحظات التنظير')
                            ->rows(2)
                            ->placeholder('تفاصيل إضافية عن التنظير المطلوب...')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 6. طلبات التشريح المرضي ====================
                Section::make('طلبات التشريح المرضي')
                    ->icon('heroicon-o-beaker')
                    ->description('إضافة طلبات التشريح المرضي مع تحديد التاريخ المتوقع للنتيجة')
                    ->schema([
                        Repeater::make('pathologyRequestsData')
                            ->label('طلبات التشريح المرضي')
                            ->schema([
                                Select::make('pathology_type')
                                    ->label('نوع التشريح')
                                    ->options([
                                        'esophagus' => 'تشريح مرضي - مريء',
                                        'stomach' => 'تشريح مرضي - معدة',
                                        'duodenum' => 'تشريح مرضي - اثني عشري',
                                        'ileum' => 'تشريح مرضي - دقاق',
                                        'colon' => 'تشريح مرضي - كولون',
                                        'liver' => 'تشريح مرضي - كبد',
                                        'pancreas' => 'تشريح مرضي - بنكرياس',
                                        'other' => 'أخرى',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(2),

                                DatePicker::make('request_date')
                                    ->label('تاريخ الطلب')
                                    ->required()
                                    ->default(now())
                                    ->native(false)
                                    ->columnSpan(1),

                                DatePicker::make('expected_result_date')
                                    ->label('التاريخ المتوقع للنتيجة')
                                    ->helperText('تاريخ تذكير لصدور النتيجة')
                                    ->native(false)
                                    ->columnSpan(1),

                                Textarea::make('description')
                                    ->label('وصف الطلب')
                                    ->rows(2)
                                    ->placeholder('تفاصيل الطلب...')
                                    ->columnSpan(2),

                                Textarea::make('clinical_notes')
                                    ->label('ملاحظات سريرية')
                                    ->rows(2)
                                    ->placeholder('معلومات سريرية مهمة...')
                                    ->columnSpan(2),

                                Select::make('status')
                                    ->label('الحالة')
                                    ->options([
                                        'pending' => 'قيد الانتظار',
                                        'in_progress' => 'قيد المعالجة',
                                        'completed' => 'مكتمل',
                                        'cancelled' => 'ملغي',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(2),

                                DatePicker::make('actual_result_date')
                                    ->label('تاريخ صدور النتيجة الفعلي')
                                    ->native(false)
                                    ->visible(fn($get) => $get('status') === 'completed')
                                    ->columnSpan(2),

                                Textarea::make('result')
                                    ->label('النتيجة')
                                    ->rows(3)
                                    ->placeholder('نتيجة التشريح المرضي...')
                                    ->visible(fn($get) => $get('status') === 'completed')
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->addActionLabel('+ إضافة طلب تشريح مرضي')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string =>
                                isset($state['pathology_type'])
                                    ? match($state['pathology_type']) {
                                        'esophagus' => '🧪 مريء',
                                        'stomach' => '🧪 معدة',
                                        'duodenum' => '🧪 اثني عشري',
                                        'ileum' => '🧪 دقاق',
                                        'colon' => '🧪 كولون',
                                        'liver' => '🧪 كبد',
                                        'pancreas' => '🧪 بنكرياس',
                                        'other' => '🧪 أخرى',
                                        default => 'طلب تشريح مرضي',
                                    }
                                    : 'طلب تشريح مرضي'
                            )
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== 7. الإحالة والاستشارات ====================
                Section::make('الإحالة والاستشارات')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Textarea::make('treatmentPlan.referrals_consultations')
                            ->label('الإحالة والاستشارات')
                            ->rows(3)
                            ->placeholder('إحالة لأخصائي، استشارة جراحية...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
