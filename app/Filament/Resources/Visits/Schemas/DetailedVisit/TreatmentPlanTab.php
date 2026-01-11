<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
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
            ->badge(fn ($get) => $get('treatmentPlan.medication_name') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. التعليمات والحمية ====================
                Section::make('التعليمات والحمية')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('تعليمات غذائية ونصائح حسب التشخيص')
                    ->schema([
                        Textarea::make('treatmentPlan.gerd_instructions')
                            ->label('1. القلس المريئي (GERD)')
                            ->rows(2)
                            ->placeholder('تعليمات القلس المريئي...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.dyspepsia_instructions')
                            ->label('2. عسر الهضم')
                            ->rows(2)
                            ->placeholder('تعليمات عسر الهضم...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.ibs_instructions')
                            ->label('3. تشنج الكولون (IBS)')
                            ->rows(2)
                            ->placeholder('تعليمات تشنج الكولون...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.constipation_instructions')
                            ->label('4. الإمساك')
                            ->rows(2)
                            ->placeholder('تعليمات الإمساك...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.gastroenteritis_instructions')
                            ->label('5. التهاب الأمعاء')
                            ->rows(2)
                            ->placeholder('تعليمات التهاب الأمعاء...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.celiac_instructions')
                            ->label('6. الداء الزلاقي (Celiac)')
                            ->rows(2)
                            ->placeholder('تعليمات الداء الزلاقي...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.ibd_instructions')
                            ->label('7. الداء المعوي الالتهابي (IBD)')
                            ->rows(2)
                            ->placeholder('تعليمات الداء المعوي الالتهابي...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.hemorrhoids_fissure_instructions')
                            ->label('8. البواسير والشق الشرجي')
                            ->rows(2)
                            ->placeholder('تعليمات البواسير والشق الشرجي...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.hepatitis_a_instructions')
                            ->label('9. التهاب الكبد A')
                            ->rows(2)
                            ->placeholder('تعليمات التهاب الكبد A...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.hepatitis_b_instructions')
                            ->label('10. التهاب الكبد B')
                            ->rows(2)
                            ->placeholder('تعليمات التهاب الكبد B...')
                            ->columnSpan(2),

                        Textarea::make('treatmentPlan.cirrhosis_instructions')
                            ->label('11. تشمع الكبد')
                            ->rows(2)
                            ->placeholder('تعليمات تشمع الكبد...')
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== 2. الوصفة الدوائية ====================
                Section::make('الوصفة الدوائية')
                    ->icon('heroicon-o-beaker')
                    ->description('الأدوية الموصوفة')
                    ->schema([
                        Textarea::make('treatmentPlan.medication_name')
                            ->label('1. الدواء المطلوب')
                            ->rows(3)
                            ->placeholder('اسم الدواء، الجرعة...')
                            ->columnSpan(2),

                        Select::make('treatmentPlan.medication_form')
                            ->label('2. الشكل الدوائي')
                            ->options([
                                'tablets' => 'مضغوطات',
                                'capsules' => 'كبسولات',
                                'syrup' => 'شراب',
                                'suppositories' => 'تحاميل',
                                'solution' => 'محلول',
                            ])
                            ->placeholder('اختر الشكل الدوائي')
                            ->columnSpan(1),

                        TextInput::make('treatmentPlan.duration')
                            ->label('4. المدة الزمنية')
                            ->placeholder('مثال: 7 أيام، أسبوعين، شهر...')
                            ->columnSpan(1),

                        Textarea::make('treatmentPlan.usage_instructions')
                            ->label('3. طريقة الاستخدام')
                            ->rows(2)
                            ->placeholder('كيفية تناول الدواء، قبل أو بعد الطعام...')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
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
                            ->itemLabel(fn (array $state): ?string =>
                                \App\Models\LabTest::find($state['lab_test_id'])?->name_ar ?? 'تحليل جديد'
                            )
                            ->addActionLabel('إضافة تحليل')
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('lab_tests_input_method') === 'detailed')
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
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('lab_tests_input_method') === 'simple')
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
                            ->visible(fn ($get) => $get('lab_tests_input_method') === 'simple'),
                    ])
                    ->collapsible(),

                // ==================== 4. الأدوية الموصوفة ====================
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
                            ->itemLabel(fn (array $state): ?string =>
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

                // ==================== 5. الأشعة المطلوبة ====================
                Section::make('الأشعة المطلوبة')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        Textarea::make('treatmentPlan.requested_imaging')
                            ->label('الأشعة المطلوبة')
                            ->rows(3)
                            ->placeholder('أشعة بطن، CT، MRI، إيكو...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 6. التنظير ====================
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
