<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\Patient;
use App\Models\ReferringDoctor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Tabs\Tab;

class PatientVisitInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('المريض والزيارة')
            ->icon('heroicon-o-user-circle')
            ->badge(fn($get) => $get('patient_id') ? '✓' : null)
            ->badgeColor('success')
            ->columns(4)
            ->schema([
                // المريض
                Select::make('patient_id')
                    ->label('المريض')
                    ->relationship('patient', 'full_name')
                    ->searchable(['full_name', 'file_number', 'phone'])
                    ->getSearchResultsUsing(function (string $search) {
                        return Patient::where('full_name', 'like', "%{$search}%")
                            ->orWhere('file_number', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function ($patient) {
                                return [
                                    $patient->id => sprintf(
                                        '%s - ملف: %s - هاتف: %s',
                                        $patient->full_name,
                                        $patient->file_number,
                                        $patient->phone ?? 'غير محدد'
                                    )
                                ];
                            })
                            ->toArray();
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $patient = Patient::find($value);
                        if (!$patient) return $value;

                        return sprintf(
                            '%s - ملف: %s',
                            $patient->full_name,
                            $patient->file_number
                        );
                    })
                    ->preload()
                    ->required()
                    ->live()
                    ->createOptionForm([
                        // البيانات الشخصية
                        Section::make('البيانات الشخصية')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('الاسم الأول')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('أحمد')
                                    ->columnSpan(1),

                                TextInput::make('father_name')
                                    ->label('اسم الأب (اختياري)')
                                    ->maxLength(255)
                                    ->placeholder('محمد')
                                    ->columnSpan(1),

                                TextInput::make('last_name')
                                    ->label('اسم العائلة')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('الأحمد')
                                    ->columnSpan(1),

                                Select::make('gender')
                                    ->label('الجنس')
                                    ->options([
                                        'male' => 'ذكر',
                                        'female' => 'أنثى',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(1),

                                Select::make('birth_year')
                                    ->label('سنة الميلاد')
                                    ->options(function () {
                                        $currentYear = date('Y');
                                        $years = [];
                                        for ($year = $currentYear; $year >= 1900; $year--) {
                                            $years[$year] = (string) $year;
                                        }
                                        return $years;
                                    })
                                    ->searchable()
                                    ->columnSpan(1),

                                DatePicker::make('date_of_birth')
                                    ->label('تاريخ الميلاد (اختياري)')
                                    ->displayFormat('Y-m-d')
                                    ->columnSpan(1),
                            ])
                            ->columns(3),

                        // معلومات الاتصال
                        Section::make('معلومات الاتصال')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                TextInput::make('phone')
                                    ->label('رقم الهاتف')
                                    ->tel()
                                    ->required()
                                    ->placeholder('0912345678')
                                    ->maxLength(20),
                            ]),

                        // الإقامة
                        Section::make('الإقامة')
                            ->icon('heroicon-o-map-pin')
                            ->description('اختياري - حدد بيانات الإقامة')
                            ->schema([
                                TextInput::make('country')
                                    ->label('البلد (للمغترب)')
                                    ->maxLength(100)
                                    ->placeholder('سوريا')
                                    ->columnSpan(1),

                                TextInput::make('province')
                                    ->label('المحافظة')
                                    ->maxLength(100)
                                    ->placeholder('دمشق')
                                    ->columnSpan(1),

                                TextInput::make('neighborhood')
                                    ->label('الحي / القرية')
                                    ->maxLength(100)
                                    ->placeholder('المزة')
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->collapsible()
                            ->collapsed(),

                        // معلومات إضافية
                        Section::make('معلومات إضافية')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('national_id')
                                    ->label('رقم الهوية الوطنية (اختياري)')
                                    ->maxLength(50)
                                    ->columnSpan(2),

                                TextInput::make('occupation')
                                    ->label('المهنة (اختياري)')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->collapsible()
                            ->collapsed(),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        // بناء الاسم الكامل من الحقول المنفصلة
                        $fullNameParts = array_filter([
                            $data['first_name'] ?? null,
                            $data['father_name'] ?? null,
                            $data['last_name'] ?? null,
                        ]);
                        $fullName = implode(' ', $fullNameParts);

                        // إنشاء المريض الجديد
                        $patient = Patient::create([
                            'first_name' => $data['first_name'],
                            'father_name' => $data['father_name'] ?? null,
                            'last_name' => $data['last_name'],
                            'full_name' => $fullName,
                            'phone' => $data['phone'],
                            'gender' => $data['gender'],
                            'birth_year' => $data['birth_year'] ?? null,
                            'date_of_birth' => $data['date_of_birth'] ?? null,
                            'national_id' => $data['national_id'] ?? null,
                            'country' => $data['country'] ?? null,
                            'province' => $data['province'] ?? null,
                            'neighborhood' => $data['neighborhood'] ?? null,
                            'occupation' => $data['occupation'] ?? null,
                            'file_number' => Patient::generateFileNumber(),
                            'is_active' => true,
                        ]);

                        // إشعار بالنجاح
                        Notification::make()
                            ->title('تم إضافة المريض بنجاح')
                            ->body("تم إنشاء ملف رقم: {$patient->file_number} - {$fullName}")
                            ->success()
                            ->icon('heroicon-o-check-circle')
                            ->iconColor('success')
                            ->duration(5000)
                            ->send();

                        return $patient->id;
                    })
                    ->createOptionModalHeading('إضافة مريض جديد')
                    ->suffixIcon('heroicon-o-plus-circle')
                    ->helperText('ابحث عن المريض بالاسم، رقم الملف، أو رقم الهاتف. إذا لم يكن موجوداً، يمكنك إضافته مباشرة.')
                    ->columnSpan(2),

                // تاريخ الزيارة
                DatePicker::make('visit_date')
                    ->label('تاريخ الزيارة')
                    ->required()
                    ->default(now())
                    ->displayFormat('Y-m-d')
                    ->native(false)
                    ->suffixIcon('heroicon-o-calendar')
                    ->helperText('تاريخ اليوم مختار افتراضياً')
                    ->columnSpan(1),

                // نوع الزيارة
                Select::make('visit_type')
                    ->label('نوع الزيارة')
                    ->options([
                        'first_visit' => '🆕 زيارة أولى',
                        'follow_up' => '🔄 متابعة',
                        'emergency' => '🚨 طوارئ',
                    ])
                    ->default('follow_up')
                    ->required()
                    ->native(false)
                    ->suffixIcon('heroicon-o-clipboard-document-check')
                    ->helperText('اختر نوع الزيارة المناسب')
                    ->columnSpan(1),


                Select::make('referring_doctor_id')
                    ->label('الطبيب المحول')
                    ->relationship('referringDoctor', 'first_name')
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name}" .
                            ($record->specialty ? " - {$record->specialty}" : '');
                    })
                    ->searchable(['first_name', 'last_name', 'specialty'])
                    ->preload()
                    ->createOptionForm([
                        Section::make('معلومات الطبيب المحول')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('الاسم الأول')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('أحمد')
                                    ->columnSpan(1),

                                TextInput::make('last_name')
                                    ->label('الكنية')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('محمد')
                                    ->columnSpan(1),

                                TextInput::make('specialty')
                                    ->label('التخصص')
                                    ->maxLength(255)
                                    ->placeholder('باطنة، جراحة، أطفال...')
                                    ->columnSpan(2),

                                TextInput::make('mobile_phone')
                                    ->label('رقم الجوال')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('0912345678')
                                    ->columnSpan(2),

                                TextInput::make('clinic_address')
                                    ->label('عنوان العيادة')
                                    ->maxLength(255)
                                    ->placeholder('دمشق، المزة...')
                                    ->columnSpan(2),
                            ])
                            ->columns(4),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        $doctor = ReferringDoctor::create($data);

                        Notification::make()
                            ->title('تم إضافة الطبيب بنجاح')
                            ->body("د. {$doctor->first_name} {$doctor->last_name}")
                            ->success()
                            ->icon('heroicon-o-check-circle')
                            ->duration(3000)
                            ->send();

                        return $doctor->id;
                    })
                    ->createOptionModalHeading('إضافة طبيب محول جديد')
                    ->suffixIcon('heroicon-o-plus-circle')
                    ->helperText('اختر الطبيب المحول أو أضف طبيباً جديداً')
                    ->columnSpan(2),

                // تفاصيل الإحالة
                Textarea::make('medicalAttachment.medical_referral')
                    ->label('تفاصيل الإحالة الطبية')
                    ->rows(3)
                    ->placeholder('تفاصيل الإحالة، المشفى، التشخيص المبدئي، الإجراءات المطلوبة...')
                    ->helperText('معلومات إضافية عن الإحالة الطبية')
                    ->columnSpanFull(),
            ]);
    }
}
