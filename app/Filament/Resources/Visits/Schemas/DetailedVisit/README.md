# نظام الزيارة الطبية التفصيلي

## 📋 نظرة عامة

تم إنشاء نظام شامل لتسجيل الزيارات الطبية مع 4 واجهات رئيسية تحتوي على أكثر من 80 حقل طبي متخصص.

## 🗂️ البنية

### الجداول المُنشأة:
1. **visit_complaint_symptoms** - الشكاية والأعراض
2. **visit_timelines** - الخط الزمني والمحرضات وعوامل الخطورة
3. **visit_medical_attachments** - المرفقات الطبية
4. **visit_clinical_examinations** - الفحص السريري

### Models المُنشأة:
- `VisitComplaintSymptom`
- `VisitTimeline`
- `VisitMedicalAttachment`
- `VisitClinicalExamination`

## ✅ ما تم إنجازه

- ✅ إنشاء 4 migrations مع جميع الحقول المطلوبة
- ✅ إنشاء 4 Models مع العلاقات
- ✅ تحديث Visit Model بالعلاقات الجديدة
- ✅ تشغيل الـ migrations بنجاح
- ✅ إنشاء مثال كامل لتبويبة الشكاية والأعراض ([ComplaintSymptomTab.php](ComplaintSymptomTab.php))

## 📝 كيفية إكمال النظام

### الخطوة 1: إنشاء التبويبات الثلاثة المتبقية

استخدم [ComplaintSymptomTab.php](ComplaintSymptomTab.php) كنموذج وأنشئ:

#### 1. TimelineTab.php (الخط الزمني والمحرضات)
```php
<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;

class TimelineTab
{
    public static function make(): Tab
    {
        return Tab::make('الخط الزمني وعوامل الخطورة')
            ->icon('heroicon-o-clock')
            ->schema([
                Section::make('الخط الزمني')
                    ->schema([
                        Select::make('timeline.onset')
                            ->label('البدء')
                            ->options([
                                'acute' => 'حاد',
                                'chronic' => 'مزمن',
                                'sudden' => 'مفاجئ',
                            ]),
                        Select::make('timeline.frequency')
                            ->label('التكرار')
                            ->options([
                                'episodic' => 'نوبي',
                                'recurrent' => 'متكرر',
                                'continuous' => 'مستمر',
                            ]),
                        Select::make('timeline.evolution')
                            ->label('التطور')
                            ->options([
                                'worsening' => 'تفاقم',
                                'stable' => 'ثابت',
                                'improving' => 'تراجع',
                            ]),
                    ])
                    ->columns(3),

                Section::make('العوامل المحرضة')
                    ->schema([
                        Textarea::make('timeline.food_triggers')
                            ->label('محرضات غذائية'),
                        Textarea::make('timeline.psychological_triggers')
                            ->label('محرضات نفسية'),
                        Textarea::make('timeline.medication_triggers')
                            ->label('محرضات دوائية'),
                        Textarea::make('timeline.physical_triggers')
                            ->label('محرضات فيزيائية'),
                        Textarea::make('timeline.stimulant_triggers')
                            ->label('منبهات'),
                        Checkbox::make('timeline.smoking_trigger')
                            ->label('تدخين'),
                        Textarea::make('timeline.other_triggers')
                            ->label('محرضات أخرى'),
                    ])
                    ->columns(3),

                Section::make('عوامل الخطورة')
                    ->schema([
                        Checkbox::make('timeline.loss_of_appetite')
                            ->label('نقص شهية'),
                        TextInput::make('timeline.weight_loss_amount')
                            ->label('كمية نقص الوزن'),
                        Select::make('timeline.gi_bleeding')
                            ->label('نزف هضمي')
                            ->options([
                                'melena' => 'زفتي',
                                'bloody' => 'دموي',
                                'occult' => 'خفي',
                            ]),
                        Checkbox::make('timeline.night_symptoms')
                            ->label('أعراض ليلية'),
                        Checkbox::make('timeline.recent_symptoms')
                            ->label('أعراض حديثة'),
                        Checkbox::make('timeline.recurrent_ulcers')
                            ->label('قلاعات متكررة'),
                        Checkbox::make('timeline.dysphagia_risk')
                            ->label('عسر بلع'),
                        Checkbox::make('timeline.recurrent_vomiting')
                            ->label('إقياء متكرر'),
                        Checkbox::make('timeline.bowel_habit_change_risk')
                            ->label('تغير عادات معوية'),
                        Textarea::make('timeline.family_history')
                            ->label('قصة عائلية'),
                        Textarea::make('timeline.other_risk_factors')
                            ->label('عوامل خطورة أخرى'),
                    ])
                    ->columns(3),

                Section::make('التاريخ المرضي')
                    ->schema([
                        Textarea::make('timeline.medical_conditions')
                            ->label('الحالات المرضية')
                            ->rows(2),
                        Textarea::make('timeline.current_medications')
                            ->label('الأدوية المستخدمة')
                            ->rows(2),
                        Textarea::make('timeline.previous_surgeries')
                            ->label('الجراحات السابقة')
                            ->rows(2),
                    ])
                    ->columns(3),
            ]);
    }
}
```

#### 2. MedicalAttachmentTab.php (المرفقات الطبية)
```php
<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات الطبية')
            ->icon('heroicon-o-document-text')
            ->schema([
                Section::make('الإحالة الطبية')
                    ->schema([
                        Textarea::make('medicalAttachment.medical_referral')
                            ->label('الإحالة الطبية')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('الأشعة')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_abdominal_ultrasound')
                            ->label('إيكو بطن'),
                        Checkbox::make('medicalAttachment.has_xray')
                            ->label('أشعة بسيطة'),
                        Checkbox::make('medicalAttachment.has_ct_scan')
                            ->label('طبقي محوري'),
                        Checkbox::make('medicalAttachment.has_mri')
                            ->label('رنين مغناطيسي'),
                        Textarea::make('medicalAttachment.radiology_notes')
                            ->label('ملاحظات الأشعة')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(4),

                Section::make('التنظير')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_upper_endoscopy')
                            ->label('تنظير علوي'),
                        Checkbox::make('medicalAttachment.has_colonoscopy')
                            ->label('تنظير سفلي'),
                        Checkbox::make('medicalAttachment.has_eus')
                            ->label('EUS'),
                        Checkbox::make('medicalAttachment.has_ercp')
                            ->label('ERCP'),
                        Textarea::make('medicalAttachment.endoscopy_notes')
                            ->label('ملاحظات التنظير')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(4),

                Section::make('التشريح المرضي')
                    ->schema([
                        Checkbox::make('medicalAttachment.has_esophagus_pathology')
                            ->label('مريء'),
                        Checkbox::make('medicalAttachment.has_stomach_pathology')
                            ->label('معدة'),
                        Checkbox::make('medicalAttachment.has_duodenum_pathology')
                            ->label('اثني عشري'),
                        Checkbox::make('medicalAttachment.has_ileum_pathology')
                            ->label('دقاق'),
                        Checkbox::make('medicalAttachment.has_colon_pathology')
                            ->label('كولون'),
                        Checkbox::make('medicalAttachment.has_liver_pathology')
                            ->label('كبد'),
                        Checkbox::make('medicalAttachment.has_pancreas_pathology')
                            ->label('بنكرياس'),
                        Textarea::make('medicalAttachment.pathology_notes')
                            ->label('ملاحظات التشريح المرضي')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(4),

                Section::make('المخبر')
                    ->description('يمكن إضافة التحاليل من التبويب الموجود')
                    ->schema([
                        Textarea::make('medicalAttachment.lab_results')
                            ->label('ملاحظات نتائج المخبر')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
```

#### 3. ClinicalExaminationTab.php (الفحص السريري)
```php
<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;

class ClinicalExaminationTab
{
    public static function make(): Tab
    {
        return Tab::make('الفحص السريري')
            ->icon('heroicon-o-heart')
            ->schema([
                Section::make('العلامات الحيوية')
                    ->schema([
                        TextInput::make('clinicalExamination.blood_pressure')
                            ->label('الضغط الشرياني')
                            ->placeholder('120/80'),
                        TextInput::make('clinicalExamination.pulse')
                            ->label('النبض')
                            ->numeric()
                            ->suffix('نبضة/دقيقة'),
                        TextInput::make('clinicalExamination.temperature')
                            ->label('الحرارة')
                            ->numeric()
                            ->suffix('°C'),
                        TextInput::make('clinicalExamination.oxygen_saturation')
                            ->label('الأكسجة')
                            ->numeric()
                            ->suffix('%'),
                    ])
                    ->columns(4),

                Section::make('الفحص السريري')
                    ->schema([
                        TextInput::make('clinicalExamination.weight')
                            ->label('الوزن')
                            ->numeric()
                            ->suffix('كغ'),
                        Textarea::make('clinicalExamination.head_neck_exam')
                            ->label('الرأس والعنق')
                            ->rows(2),
                        Textarea::make('clinicalExamination.heart_chest_exam')
                            ->label('القلب والصدر')
                            ->rows(2),
                        Textarea::make('clinicalExamination.abdomen_pelvis_exam')
                            ->label('البطن والحوض')
                            ->rows(2),
                        Textarea::make('clinicalExamination.extremities_exam')
                            ->label('الأطراف')
                            ->rows(2),
                        Textarea::make('clinicalExamination.rectal_exam')
                            ->label('المس الشرجي')
                            ->rows(2),
                    ])
                    ->columns(3),

                Section::make('إيكو البطن')
                    ->schema([
                        Textarea::make('clinicalExamination.liver_echo')
                            ->label('الكبد')->rows(2),
                        Textarea::make('clinicalExamination.gallbladder_echo')
                            ->label('المرارة')->rows(2),
                        Textarea::make('clinicalExamination.bile_ducts_echo')
                            ->label('الطرق الصفراوية')->rows(2),
                        Textarea::make('clinicalExamination.pancreas_echo')
                            ->label('البنكرياس')->rows(2),
                        Textarea::make('clinicalExamination.spleen_echo')
                            ->label('الطحال')->rows(2),
                        Textarea::make('clinicalExamination.stomach_echo')
                            ->label('المعدة')->rows(2),
                        Textarea::make('clinicalExamination.intestines_echo')
                            ->label('الأمعاء')->rows(2),
                        Textarea::make('clinicalExamination.abdominal_cavity_echo')
                            ->label('جوف البطن')->rows(2),
                        Textarea::make('clinicalExamination.kidneys_echo')
                            ->label('الكليتين')->rows(2),
                        Textarea::make('clinicalExamination.uterus_appendages_echo')
                            ->label('الرحم والملحقات')->rows(2),
                        Textarea::make('clinicalExamination.prostate_echo')
                            ->label('البروستات')->rows(2),
                        Textarea::make('clinicalExamination.other_echo')
                            ->label('أخرى')->rows(2),
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }
}
```

### الخطوة 2: دمج التبويبات في VisitForm

افتح [VisitForm.php](../../VisitForm.php) وأضف التبويبات الجديدة:

```php
use App\Filament\Resources\Visits\Schemas\DetailedVisit\ComplaintSymptomTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\TimelineTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\MedicalAttachmentTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\ClinicalExaminationTab;

public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            Tabs::make('visit_tabs')
                ->tabs([
                    // ... التبويبات الموجودة ...

                    // التبويبات الجديدة
                    ComplaintSymptomTab::make(),
                    TimelineTab::make(),
                    MedicalAttachmentTab::make(),
                    ClinicalExaminationTab::make(),
                ])
                ->persistTabInQueryString('tab')
                ->contained(false)
                ->columnSpanFull(),
        ]);
}
```

### الخطوة 3: حفظ البيانات

في VisitResource، تأكد من معالجة البيانات بشكل صحيح:

```php
protected function mutateFormDataBeforeCreate(array $data): array
{
    // سيتم حفظ البيانات تلقائياً في الجداول المرتبطة
    // بفضل العلاقات hasOne في Visit Model
    return $data;
}
```

## 🎯 الاستخدام

عند إنشاء زيارة جديدة، سيكون لديك:
- **Tab 1**: المريض والزيارة (موجود حالياً)
- **Tab 2**: الشكوى والفحص (موجود حالياً)
- **Tab 3**: التشخيص والفحوصات (موجود حالياً)
- **Tab 4**: العلاج والمتابعة (موجود حالياً)
- **Tab 5**: الشكاية والأعراض (جديد - 46 حقل)
- **Tab 6**: الخط الزمني وعوامل الخطورة (جديد)
- **Tab 7**: المرفقات الطبية (جديد)
- **Tab 8**: الفحص السريري (جديد)

## 📊 البيانات

البيانات يتم حفظها في جداول منفصلة مرتبطة بـ visit_id:
- كل زيارة يمكن أن يكون لها سجل واحد في كل جدول (hasOne relationship)
- البيانات محمية بـ foreign key مع cascade delete
- يمكن الوصول للبيانات عبر: `$visit->complaintSymptom`, `$visit->timeline`, etc.

## 🔧 التخصيص

يمكنك تخصيص:
- إضافة/إزالة حقول
- تغيير ترتيب الحقول
- إضافة validations
- تخصيص العرض في InfoList
- إضافة conditional logic بين الحقول

## 💡 نصائح

1. **الأداء**: نظراً لكثرة الحقول، فكر في استخدام lazy loading للـ tabs
2. **التحقق**: أضف validation rules حسب الحاجة
3. **العرض**: أنشئ InfoList schemas منفصلة لعرض البيانات
4. **التصدير**: يمكنك إضافة تصدير البيانات إلى PDF/Excel

## 📞 الدعم

للمزيد من المساعدة، راجع:
- [Filament Forms Documentation](https://filamentphp.com/docs/forms)
- [Laravel Relationships](https://laravel.com/docs/eloquent-relationships)
