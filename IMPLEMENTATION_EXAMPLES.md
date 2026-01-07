# أمثلة تفصيلية للتنفيذ
## Implementation Examples - Code Snippets

---

## 1️⃣ دمج الأدوية - Medications Integration

### الخطوة 1: تعديل VisitTreatmentPlan Model

```php
<?php
// app/Models/VisitTreatmentPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitTreatmentPlan extends Model
{
    protected $fillable = [
        'visit_id',
        // ... باقي الحقول الموجودة
        'gerd_instructions',
        'dyspepsia_instructions',
        // ... إلخ
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    // ⭐ العلاقة الجديدة مع الأدوية
    public function medications()
    {
        return $this->hasMany(VisitMedication::class, 'visit_id', 'visit_id');
    }
}
```

### الخطوة 2: تحديث TreatmentPlanTab

```php
<?php
// app/Filament/Resources/Visits/Schemas/DetailedVisit/TreatmentPlanTab.php

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use App\Models\Medication;

class TreatmentPlanTab
{
    public static function make(): Tab
    {
        return Tab::make('خطة العلاج')
            ->icon('heroicon-o-clipboard-document-check')
            ->schema([
                // ... التعليمات والحمية (موجودة)

                // ==================== الوصفة الدوائية المحدثة ====================
                Section::make('الوصفة الدوائية')
                    ->icon('heroicon-o-beaker')
                    ->description('اختر الأدوية من القائمة أو أضف دواء جديد')
                    ->schema([
                        Repeater::make('medications')
                            ->relationship('medications')
                            ->schema([
                                Select::make('medication_id')
                                    ->label('الدواء')
                                    ->relationship('medication', 'name_ar')
                                    ->searchable([
                                        'name_ar',
                                        'name_en',
                                        'generic_name',
                                        'brand_name'
                                    ])
                                    ->getOptionLabelFromRecordUsing(function ($record) {
                                        $label = $record->name_ar;
                                        if ($record->generic_name) {
                                            $label .= " ({$record->generic_name})";
                                        }
                                        if ($record->strength) {
                                            $label .= " - {$record->strength}";
                                        }
                                        return $label;
                                    })
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if (!$state) return;

                                        $medication = Medication::find($state);
                                        if (!$medication) return;

                                        // ملء البيانات تلقائياً
                                        if ($medication->strength) {
                                            $set('dosage', $medication->strength);
                                        }
                                        if ($medication->dosage_form) {
                                            $set('route', $medication->dosage_form);
                                        }
                                        if ($medication->common_dosage) {
                                            $set('frequency', $medication->common_dosage);
                                        }
                                    })
                                    ->createOptionForm([
                                        Section::make('معلومات الدواء')
                                            ->schema([
                                                TextInput::make('name_ar')
                                                    ->label('الاسم بالعربية')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('name_en')
                                                    ->label('الاسم بالإنجليزية')
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('generic_name')
                                                    ->label('الاسم العلمي')
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('brand_name')
                                                    ->label('الاسم التجاري')
                                                    ->maxLength(255)
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
                                                    ->placeholder('مثال: 500mg')
                                                    ->maxLength(50)
                                                    ->columnSpan(2),

                                                TextInput::make('manufacturer')
                                                    ->label('الشركة المصنعة')
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('common_dosage')
                                                    ->label('الجرعة الشائعة')
                                                    ->placeholder('مثال: 3 مرات يومياً')
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                Textarea::make('description')
                                                    ->label('الوصف')
                                                    ->rows(2)
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
                                            ->send();

                                        return $medication->id;
                                    })
                                    ->createOptionModalHeading('إضافة دواء جديد')
                                    ->columnSpan(3),

                                TextInput::make('dosage')
                                    ->label('الجرعة')
                                    ->placeholder('مثال: 500mg')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                TextInput::make('frequency')
                                    ->label('عدد المرات')
                                    ->placeholder('مثال: 3 مرات يومياً')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                TextInput::make('duration')
                                    ->label('المدة')
                                    ->placeholder('مثال: 7 أيام')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Select::make('route')
                                    ->label('طريقة الإعطاء')
                                    ->options([
                                        'oral' => 'فموي',
                                        'injection' => 'حقن',
                                        'topical' => 'موضعي',
                                        'inhalation' => 'استنشاق',
                                        'rectal' => 'شرجي',
                                        'sublingual' => 'تحت اللسان',
                                        'transdermal' => 'عبر الجلد',
                                        'other' => 'أخرى'
                                    ])
                                    ->default('oral')
                                    ->native(false)
                                    ->columnSpan(2),

                                Textarea::make('notes')
                                    ->label('ملاحظات وتعليمات')
                                    ->placeholder('قبل الطعام، بعد الطعام، مع الماء...')
                                    ->rows(2)
                                    ->columnSpan(4),
                            ])
                            ->columns(6)
                            ->defaultItems(0)
                            ->addActionLabel('➕ إضافة دواء')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                $state['medication_id']
                                    ? Medication::find($state['medication_id'])?->name_ar
                                    : 'دواء جديد'
                            ),
                    ])
                    ->collapsible(),

                // ... باقي الأقسام
            ]);
    }
}
```

### الخطوة 3: تحديث CreateVisit و EditVisit

```php
// في CreateVisit.php - لا حاجة لتعديل!
// Repeater مع relationship يحفظ تلقائياً ✅

// في EditVisit.php - لا حاجة لتعديل!
// Repeater مع relationship يحمّل تلقائياً ✅
```

---

## 2️⃣ التحميل التلقائي للبيانات - Auto-Loading

### تحديث TimelineTab

```php
<?php
// app/Filament/Resources/Visits/Schemas/DetailedVisit/TimelineTab.php

use Filament\Forms\Get;
use App\Models\Patient;

class TimelineTab
{
    public static function make(): Tab
    {
        return Tab::make('الخط الزمني وعوامل الخطورة')
            ->schema([
                // ... الأقسام الأخرى

                Section::make('التاريخ المرضي')
                    ->icon('heroicon-o-document-text')
                    ->description('يتم تحميل البيانات تلقائياً من ملف المريض')
                    ->schema([
                        Textarea::make('timeline.medical_conditions')
                            ->label('1. الحالات المرضية')
                            ->rows(3)
                            ->placeholder('سيتم تحميل الأمراض المزمنة تلقائياً...')
                            ->default(function (Get $get) {
                                return self::loadChronicDiseases($get);
                            })
                            ->dehydrated(true)
                            ->helperText('✅ تم التحميل من: ملف المريض > الأمراض المزمنة')
                            ->columnSpanFull(),

                        Textarea::make('timeline.current_medications')
                            ->label('2. الأدوية المستخدمة')
                            ->rows(3)
                            ->placeholder('سيتم تحميل الأدوية الدائمة تلقائياً...')
                            ->default(function (Get $get) {
                                return self::loadPermanentMedications($get);
                            })
                            ->dehydrated(true)
                            ->helperText('✅ تم التحميل من: ملف المريض > الأدوية الدائمة')
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

    /**
     * تحميل الأمراض المزمنة من ملف المريض
     */
    protected static function loadChronicDiseases(Get $get): ?string
    {
        $patientId = $get('patient_id');
        if (!$patientId) {
            return null;
        }

        $patient = Patient::with(['chronicDiseases' => function($query) {
            $query->where('patient_chronic_diseases.is_active', true)
                  ->orderBy('patient_chronic_diseases.diagnosis_date', 'desc');
        }])->find($patientId);

        if (!$patient || $patient->chronicDiseases->isEmpty()) {
            return '✓ لا توجد أمراض مزمنة مسجلة';
        }

        $diseases = $patient->chronicDiseases->map(function($disease) {
            $text = "• {$disease->name_ar}";

            // إضافة تاريخ التشخيص إن وجد
            if ($disease->pivot->diagnosis_date) {
                $date = date('Y-m-d', strtotime($disease->pivot->diagnosis_date));
                $text .= " (منذ {$date})";
            }

            // إضافة الملاحظات إن وجدت
            if ($disease->pivot->notes) {
                $text .= "\n  - {$disease->pivot->notes}";
            }

            return $text;
        })->implode("\n\n");

        return $diseases;
    }

    /**
     * تحميل الأدوية الدائمة من ملف المريض
     */
    protected static function loadPermanentMedications(Get $get): ?string
    {
        $patientId = $get('patient_id');
        if (!$patientId) {
            return null;
        }

        $patient = Patient::with(['permanentMedications' => function($query) {
            $query->where('is_active', true)
                  ->with('medication');
        }])->find($patientId);

        if (!$patient || $patient->permanentMedications->isEmpty()) {
            return '✓ لا توجد أدوية دائمة مسجلة';
        }

        $medications = $patient->permanentMedications->map(function($pm) {
            $med = $pm->medication;
            $text = "• {$med->name_ar}";

            // إضافة التركيز
            if ($med->strength) {
                $text .= " ({$med->strength})";
            }

            // إضافة الجرعة والتكرار
            $details = [];
            if ($pm->dosage) {
                $details[] = $pm->dosage;
            }
            if ($pm->frequency) {
                $details[] = $pm->frequency;
            }
            if (!empty($details)) {
                $text .= " - " . implode(', ', $details);
            }

            // إضافة الملاحظات
            if ($pm->notes) {
                $text .= "\n  - {$pm->notes}";
            }

            return $text;
        })->implode("\n\n");

        return $medications;
    }
}
```

---

## 3️⃣ دمج التحاليل المخبرية - Lab Tests Integration

### إنشاء LabTestsTab جديد

```php
<?php
// app/Filament/Resources/Visits/Schemas/DetailedVisit/LabTestsTab.php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use App\Models\LabTest;

class LabTestsTab
{
    public static function make(): Tab
    {
        return Tab::make('التحاليل المخبرية')
            ->icon('heroicon-o-beaker')
            ->badge(fn ($get) => count($get('labTests') ?? []) > 0 ? '✓' : null)
            ->badgeColor('success')
            ->schema([
                Section::make('التحاليل المطلوبة/المنجزة')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('أضف التحاليل من القائمة أو سجّل تحليل جديد')
                    ->schema([
                        Repeater::make('labTests')
                            ->relationship('labTests')
                            ->schema([
                                Select::make('lab_test_id')
                                    ->label('التحليل')
                                    ->relationship('labTest', 'name_ar')
                                    ->searchable([
                                        'name_ar',
                                        'name_en',
                                        'abbreviation',
                                        'category'
                                    ])
                                    ->getOptionLabelFromRecordUsing(function ($record) {
                                        $label = $record->name_ar;
                                        if ($record->abbreviation) {
                                            $label .= " ({$record->abbreviation})";
                                        }
                                        if ($record->category) {
                                            $label .= " - [{$record->category}]";
                                        }
                                        return $label;
                                    })
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if (!$state) return;

                                        $test = LabTest::find($state);
                                        if (!$test) return;

                                        // ملء المجال الطبيعي تلقائياً
                                        if ($test->normal_range) {
                                            $set('normal_range_display', $test->normal_range);
                                        }
                                        if ($test->unit) {
                                            $set('unit_display', $test->unit);
                                        }
                                    })
                                    ->createOptionForm([
                                        Section::make('معلومات التحليل')
                                            ->schema([
                                                TextInput::make('name_ar')
                                                    ->label('اسم التحليل بالعربية')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('name_en')
                                                    ->label('اسم التحليل بالإنجليزية')
                                                    ->maxLength(255)
                                                    ->columnSpan(2),

                                                TextInput::make('abbreviation')
                                                    ->label('الاختصار')
                                                    ->placeholder('مثال: CBC, FBS')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),

                                                Select::make('category')
                                                    ->label('التصنيف')
                                                    ->options([
                                                        'blood' => 'دم',
                                                        'urine' => 'بول',
                                                        'stool' => 'براز',
                                                        'chemistry' => 'كيمياء',
                                                        'hormones' => 'هرمونات',
                                                        'immunity' => 'مناعة',
                                                        'microbiology' => 'أحياء دقيقة',
                                                        'other' => 'أخرى'
                                                    ])
                                                    ->native(false)
                                                    ->columnSpan(1),

                                                TextInput::make('normal_range')
                                                    ->label('المجال الطبيعي')
                                                    ->placeholder('مثال: 70-110')
                                                    ->maxLength(255)
                                                    ->columnSpan(1),

                                                TextInput::make('unit')
                                                    ->label('الوحدة')
                                                    ->placeholder('مثال: mg/dl')
                                                    ->maxLength(50)
                                                    ->columnSpan(1),

                                                Textarea::make('description')
                                                    ->label('الوصف')
                                                    ->rows(2)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(4)
                                    ])
                                    ->createOptionUsing(function (array $data): int {
                                        return LabTest::create($data)->id;
                                    })
                                    ->createOptionModalHeading('إضافة تحليل جديد')
                                    ->columnSpan(3),

                                TextInput::make('result')
                                    ->label('النتيجة')
                                    ->placeholder('أدخل النتيجة')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                TextInput::make('normal_range_display')
                                    ->label('المجال الطبيعي')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpan(1),

                                TextInput::make('unit_display')
                                    ->label('الوحدة')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpan(1),

                                Toggle::make('is_normal')
                                    ->label('طبيعي؟')
                                    ->inline(false)
                                    ->default(true)
                                    ->columnSpan(1),

                                DatePicker::make('test_date')
                                    ->label('تاريخ التحليل')
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('Y-m-d')
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات')
                                    ->placeholder('ملاحظات إضافية على النتيجة...')
                                    ->rows(2)
                                    ->columnSpan(4),
                            ])
                            ->columns(6)
                            ->defaultItems(0)
                            ->addActionLabel('➕ إضافة تحليل')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                $state['lab_test_id']
                                    ? LabTest::find($state['lab_test_id'])?->name_ar
                                    : 'تحليل جديد'
                            ),
                    ])
                    ->collapsible(),
            ]);
    }
}
```

### تحديث Visit Model

```php
<?php
// app/Models/Visit.php

public function labTests()
{
    return $this->belongsToMany(LabTest::class, 'visit_lab_tests')
        ->withPivot([
            'result',
            'notes',
            'test_date',
            'is_normal'
        ])
        ->withTimestamps();
}
```

### إضافة التاب في VisitForm

```php
<?php
// app/Filament/Resources/Visits/Schemas/VisitForm.php

use App\Filament\Resources\Visits\Schemas\DetailedVisit\LabTestsTab;

return $schema->components([
    Tabs::make('visit_tabs')
        ->tabs([
            PatientVisitInfoTab::make(),
            ComplaintSymptomTab::make(),
            TimelineTab::make(),
            MedicalAttachmentTab::make(),
            ClinicalExaminationTab::make(),
            LabTestsTab::make(), // ⭐ التاب الجديد
            TreatmentPlanTab::make(),
            FollowupTab::make(),
        ])
        // ...
]);
```

---

## 4️⃣ Quick Win: تحسينات صغيرة سريعة

### أ) إضافة زر "تحميل من ملف المريض"

```php
// في أي تاب تريد إضافة زر تحميل
Actions::make([
    Action::make('loadFromPatient')
        ->label('تحميل من ملف المريض')
        ->icon('heroicon-o-arrow-down-tray')
        ->color('info')
        ->action(function (Get $get, Set $set) {
            $patientId = $get('patient_id');
            // ... تحميل البيانات
            $set('timeline.medical_conditions', $diseases);
            $set('timeline.current_medications', $medications);

            Notification::make()
                ->title('تم التحميل بنجاح')
                ->success()
                ->send();
        })
])
```

### ب) عرض عداد الأدوية المضافة

```php
Section::make('الوصفة الدوائية')
    ->description(function (Get $get) {
        $count = count($get('medications') ?? []);
        return $count > 0
            ? "✓ {$count} دواء مضاف"
            : 'لم يتم إضافة أدوية بعد';
    })
```

### ج) تحذيرات ذكية

```php
Select::make('medication_id')
    ->hint(function ($state, Get $get) {
        if (!$state) return null;

        $medication = Medication::find($state);
        $patientId = $get('patient_id');

        if (!$medication || !$patientId) return null;

        $patient = Patient::with('permanentMedications')->find($patientId);

        // تحذير إذا كان المريض يأخذ هذا الدواء أصلاً
        if ($patient->permanentMedications->contains('medication_id', $state)) {
            return '⚠️ المريض يأخذ هذا الدواء بشكل دائم';
        }

        return null;
    })
    ->hintColor('warning')
```

---

## 📊 ملاحظات التنفيذ

### ✅ الأشياء الجاهزة (لا تحتاج تعديل):
1. جميع الجداول موجودة
2. جميع الـ Models موجودة
3. Relations في Visit Model جاهزة
4. Migrations جاهزة

### 🔨 ما نحتاج تعديله:
1. التابات في `DetailedVisit/`
2. إضافة functions مساعدة للتحميل التلقائي
3. تحديث CreateVisit/EditVisit (بسيط)

### ⏱️ الوقت المتوقع لكل مرحلة:
- دمج الأدوية: 2-3 ساعات
- التحميل التلقائي: 1 ساعة
- دمج التحاليل: 2 ساعة
- الاختبار: 1-2 ساعة

**إجمالي: يوم عمل واحد تقريباً** ✨
