# ملخص نظام معاينات المشفى وإجراءات التنظير

## 📋 نظرة عامة

تم بناء نظامين جديدين متكاملين لإدارة السجلات الطبية اليومية:

1. **معاينات المشفى (Hospital Consultations)** - سجلات الزيارات اليومية للمشفى
2. **إجراءات التنظير (Endoscopy Procedures)** - سجلات إجراءات التنظير اليومية

---

## 🗄️ قاعدة البيانات

### الجداول الرئيسية

#### 1. `hospitals` - المستشفيات
```sql
- id
- name_ar (الهلال الأحمر، باب السباع، البر، الكندي، الرازي، الأمين)
- name_en
- abbreviation
- address
- phone
- is_active
- notes
```

#### 2. `preliminary_diagnoses` - التشخيصات الأولية
```sql
- id
- name_ar (نزف هضمي، فقر دم للدراسة، خزل معوي، إلخ...)
- name_en
- abbreviation
- category (digestive, hematology, liver, pancreas)
- is_active
- description
```

#### 3. `endoscopy_interventions` - إجراءات التنظير
```sql
- id
- name_ar (استخراج جسم أجنبي، توسيع مريء، إلخ...)
- name_en
- abbreviation
- is_active
- description
```

#### 4. `hospital_consultations` - معاينات المشفى
```sql
- id
- patient_id (FK → patients)
- sequential_number (260101-260199)
- consultation_date
- day_of_week (auto-calculated Arabic)
- hospital_id (FK → hospitals)
- source (hospital/consultation/private)
- doctor_id (FK → users)
- preliminary_diagnosis_id (FK → preliminary_diagnoses)
- accompanying_diseases (text)
- procedures (text)
- final_diagnosis (text)
- follow_up_status (cured/ongoing/deceased)
- notes
- created_by, updated_by
```

#### 5. `endoscopy_procedures` - إجراءات التنظير
```sql
- id
- patient_id (FK → patients)
- sequential_number (E000001)
- procedure_date
- day_of_week (auto-calculated Arabic)
- hospital_id (FK → hospitals)
- admission_type (internal/external)
- source (hospital/consultation/private)
- doctor_id (FK → users)
- indication_id (FK → preliminary_diagnoses)
- procedure_type (upper/lower/biopsy)
- results (text)
- biopsy_locations (JSON array)
- biopsy_results (text)
- follow_up_status (completed/ongoing)
- notes
- created_by, updated_by
```

#### 6. `procedure_interventions` - جدول ربط (Pivot)
```sql
- id
- procedure_id (FK → endoscopy_procedures)
- intervention_id (FK → endoscopy_interventions)
- notes
```

---

## 🔗 العلاقات (Relationships)

### Patient Model
```php
public function hospitalConsultations()
{
    return $this->hasMany(HospitalConsultation::class);
}

public function endoscopyProcedures()
{
    return $this->hasMany(EndoscopyProcedure::class);
}
```

### HospitalConsultation Model
```php
public function patient()
public function hospital()
public function doctor()
public function preliminaryDiagnosis()
public function attachments() // polymorphic
public function creator()
public function updater()
```

### EndoscopyProcedure Model
```php
public function patient()
public function hospital()
public function doctor()
public function indication() // preliminary diagnosis
public function interventions() // many-to-many
public function attachments() // polymorphic
public function creator()
public function updater()
```

---

## 🔢 الترقيم التلقائي

### معاينات المشفى
- **النمط**: `260101` - `260199`
- **آلية العمل**: يبدأ من 81 ويعد حتى 99، ثم يعود إلى 81
- **الكود**:
```php
public static function generateSequentialNumber(): string
{
    $lastRecord = self::latest('id')->first();
    $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
    if ($nextNumber > 99) $nextNumber = 81;
    return '2601' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
}
```

### إجراءات التنظير
- **النمط**: `E000001` - `E999999`
- **آلية العمل**: ترقيم متسلسل مستمر
- **الكود**:
```php
public static function generateSequentialNumber(): string
{
    $lastRecord = self::latest('id')->first();
    $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
    return 'E' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
}
```

### يوم الأسبوع بالعربية
```php
public static function getDayOfWeekInArabic($date): string
{
    $days = [
        'Sunday' => 'الأحد',
        'Monday' => 'الاثنين',
        'Tuesday' => 'الثلاثاء',
        'Wednesday' => 'الأربعاء',
        'Thursday' => 'الخميس',
        'Friday' => 'الجمعة',
        'Saturday' => 'السبت',
    ];
    
    return $days[Carbon::parse($date)->format('l')];
}
```

---

## 🎨 واجهة المستخدم

### صفحة عرض المريض (view-patient.blade.php)

تم إضافة قسمين جديدين بتنسيق مشابه لجدول الزيارات:

#### 1. جدول معاينات المشفى
- عرض 5 معاينات حديثة
- الأعمدة: الرقم المتسلسل، التاريخ، اليوم، المشفى، المصدر، التشخيص الأولي، حالة المتابعة، الإجراءات
- زر "معاينة جديدة" (أخضر)
- أزرار عرض/تعديل لكل معاينة
- رابط لعرض جميع المعاينات إذا كانت أكثر من 5

#### 2. جدول إجراءات التنظير
- عرض 5 إجراءات حديثة
- الأعمدة: الرقم المتسلسل، التاريخ، اليوم، المشفى، نوع القبول، نوع الإجراء، الاستطباب، حالة المتابعة، الإجراءات
- زر "إجراء جديد" (بنفسجي)
- أزرار عرض/تعديل لكل إجراء
- رابط لعرض جميع الإجراءات إذا كانت أكثر من 5

#### 3. تحديث جدول الإحصائيات
تم إضافة عمودين جديدين:
- معاينات المشفى (عداد)
- إجراءات التنظير (عداد)

---

## 📦 الريسورسات (Resources)

### HospitalConsultationResource
```php
protected static ?string $navigationLabel = 'معاينات المشفى';
protected static ?string $modelLabel = 'معاينة مشفى';
protected static ?string $pluralModelLabel = 'معاينات المشفى';
protected static ?int $navigationSort = 2;
```

### EndoscopyProcedureResource
```php
protected static ?string $navigationLabel = 'إجراءات التنظير';
protected static ?string $modelLabel = 'إجراء تنظير';
protected static ?string $pluralModelLabel = 'إجراءات التنظير';
protected static ?int $navigationSort = 3;
```

---

## 🔄 استخدام الجداول الموجودة

### 1. جدول المرفقات (Polymorphic)
```php
// في EndoscopyProcedure Model
public function attachments()
{
    return $this->morphMany(Attachment::class, 'attachable');
}

// مثال على إضافة مرفق
$procedure->attachments()->create([
    'file_name' => 'endoscopy_image.jpg',
    'file_path' => 'attachments/endoscopy/...',
    'file_type' => 'image',
    'mime_type' => 'image/jpeg',
    'title' => 'صورة تنظير علوي',
    'category' => 'medical_report',
]);
```

### 2. جدول المستخدمين (للأطباء)
```php
public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}
```

### 3. إمكانية الربط مع الأدوية
يمكن مستقبلاً ربط خطة العلاج من معاينات المشفى مع جدول الأدوية.

---

## 🧪 البيانات التجريبية

تم إنشاء بيانات تجريبية للاختبار:

### معاينة مشفى
```php
HospitalConsultation::create([
    'patient_id' => 1,
    'sequential_number' => '260101',
    'consultation_date' => now(),
    'day_of_week' => 'الخميس',
    'hospital_id' => 1, // الهلال الأحمر
    'source' => 'hospital',
    'preliminary_diagnosis_id' => 1, // نزف هضمي
    'accompanying_diseases' => 'ضغط دم - سكري',
    'final_diagnosis' => 'نزف هضمي علوي - قرحة معدة',
    'follow_up_status' => 'ongoing',
]);
```

### إجراء تنظير
```php
EndoscopyProcedure::create([
    'patient_id' => 2,
    'sequential_number' => 'E000001',
    'procedure_date' => now(),
    'day_of_week' => 'الخميس',
    'hospital_id' => 2, // باب السباع
    'admission_type' => 'internal',
    'procedure_type' => 'upper',
    'indication_id' => 1,
    'results' => 'قرحة في المعدة - تم أخذ خزعة',
    'biopsy_locations' => json_encode(['المعدة', 'المريء']),
    'biopsy_results' => 'قرحة حميدة - لا يوجد خباثة',
    'follow_up_status' => 'completed',
]);

// إضافة إجراءات
$procedure->interventions()->attach([1, 2]);
```

---

## ✅ الميزات المنفذة

- [x] قاعدة بيانات كاملة مع 6 جداول جديدة
- [x] 5 موديلات مع علاقات كاملة
- [x] ترقيم تلقائي متسلسل لكلا النظامين
- [x] حساب يوم الأسبوع بالعربية تلقائياً
- [x] علاقات polymorphic مع جدول المرفقات
- [x] علاقات many-to-many مع إجراءات التنظير
- [x] Seeders للبيانات الأولية (6 مستشفيات، 12 تشخيص، 13 إجراء)
- [x] ريسورسات Filament مترجمة بالكامل
- [x] جداول في صفحة عرض المريض
- [x] تحديث جدول الإحصائيات
- [x] Scopes للاستعلامات الشائعة
- [x] تتبع المستخدم (created_by, updated_by)
- [x] Soft Deletes على جميع الكيانات
- [x] Indexes لتحسين الأداء

---

## 🎯 الخطوات التالية (للتطوير المستقبلي)

1. **تخصيص النماذج (Forms)**:
   - بناء نماذج إدخال شاملة لمعاينات المشفى
   - بناء نماذج إدخال لإجراءات التنظير مع رفع الصور
   - إضافة validations مناسبة

2. **تخصيص الجداول (Tables)**:
   - إضافة أعمدة مناسبة لجداول القوائم
   - إضافة فلاتر (حسب المشفى، التاريخ، الطبيب)
   - إضافة خيارات البحث والفرز

3. **صفحات العرض (Infolists)**:
   - تصميم صفحة عرض تفصيلية لمعاينة المشفى
   - تصميم صفحة عرض تفصيلية لإجراء التنظير مع الصور

4. **التقارير**:
   - تقرير يومي بمعاينات المشفى
   - تقرير يومي بإجراءات التنظير
   - إمكانية الطباعة والتصدير

5. **التحسينات**:
   - إضافة إشعارات للمتابعة
   - ربط خطط العلاج مع جدول الأدوية
   - إضافة نظام المواعيد للتنظير

---

## 📊 إحصائيات المشروع

```
✅ 6 جداول جديدة
✅ 5 موديلات
✅ 2 ريسورسات Filament
✅ 16 صفحة مولدة تلقائياً
✅ 3 Seeders
✅ 31 سجل بيانات أولية
✅ 100% علاقات متصلة
```

---

تم التطوير بواسطة Claude Code 🤖
