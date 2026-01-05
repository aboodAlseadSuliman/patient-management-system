<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ==================== معلومات أساسية ====================
                Section::make('معلومات الزيارة')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // معلومات المريض
                                Section::make('بيانات المريض')
                                    ->schema([
                                        TextEntry::make('patient.full_name')
                                            ->label('اسم المريض')
                                            ->icon('heroicon-o-user')
                                            ->weight('bold')
                                            ->size('lg')
                                            ->color('primary'),

                                        TextEntry::make('patient.file_number')
                                            ->label('رقم الملف')
                                            ->icon('heroicon-o-document-text')
                                            ->badge()
                                            ->color('gray'),

                                        TextEntry::make('patient.phone')
                                            ->label('رقم الهاتف')
                                            ->icon('heroicon-o-phone')
                                            ->copyable(),
                                    ])
                                    ->columnSpan(1),

                                // معلومات الزيارة
                                Section::make('بيانات الزيارة')
                                    ->schema([
                                        TextEntry::make('visit_number')
                                            ->label('رقم الزيارة')
                                            ->badge()
                                            ->color('success')
                                            ->size('lg'),

                                        TextEntry::make('visit_date')
                                            ->label('تاريخ الزيارة')
                                            ->icon('heroicon-o-calendar')
                                            ->date('Y-m-d')
                                            ->badge()
                                            ->color('info'),

                                        TextEntry::make('visit_type')
                                            ->label('نوع الزيارة')
                                            ->badge()
                                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                                'first_visit' => 'زيارة أولى',
                                                'follow_up' => 'متابعة',
                                                'emergency' => 'طوارئ',
                                                default => $state ?? '-',
                                            })
                                            ->color(fn (?string $state): string => match ($state) {
                                                'first_visit' => 'success',
                                                'follow_up' => 'info',
                                                'emergency' => 'danger',
                                                default => 'gray',
                                            })
                                            ->icon(fn (?string $state): string => match ($state) {
                                                'first_visit' => 'heroicon-o-sparkles',
                                                'follow_up' => 'heroicon-o-arrow-path',
                                                'emergency' => 'heroicon-o-exclamation-triangle',
                                                default => 'heroicon-o-clipboard-document',
                                            }),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible(),

                // ==================== الشكاية والأعراض ====================
                Section::make('الشكاية والأعراض')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        TextEntry::make('complaintSymptom.chief_complaint')
                            ->label('الشكوى الرئيسية')
                            ->icon('heroicon-o-exclamation-circle')
                            ->placeholder('لا توجد شكوى مسجلة')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('complaintSymptom.complaint_characteristics')
                            ->label('مواصفات الشكاية')
                            ->placeholder('لا توجد مواصفات')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('complaintSymptom.associated_symptoms')
                            ->label('الأعراض المصاحبة')
                            ->placeholder('لا توجد أعراض مصاحبة')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== الخط الزمني ====================
                Section::make('الخط الزمني وعوامل الخطورة')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('timeline.onset')
                                    ->label('البدء')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'acute' => 'حاد',
                                        'chronic' => 'مزمن',
                                        'sudden' => 'مفاجئ',
                                        default => $state ?? '-',
                                    })
                                    ->color('info'),

                                TextEntry::make('timeline.frequency')
                                    ->label('التكرار')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'episodic' => 'نوبي',
                                        'recurrent' => 'متكرر',
                                        'continuous' => 'مستمر',
                                        default => $state ?? '-',
                                    })
                                    ->color('warning'),

                                TextEntry::make('timeline.evolution')
                                    ->label('التطور')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'worsening' => 'تفاقم',
                                        'stable' => 'ثابت',
                                        'improving' => 'تراجع',
                                        default => $state ?? '-',
                                    })
                                    ->color(fn (?string $state): string => match ($state) {
                                        'worsening' => 'danger',
                                        'stable' => 'warning',
                                        'improving' => 'success',
                                        default => 'gray',
                                    }),
                            ]),

                        TextEntry::make('timeline.food_triggers')
                            ->label('محرضات غذائية')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('timeline.medical_conditions')
                            ->label('الحالات المرضية')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('timeline.current_medications')
                            ->label('الأدوية المستخدمة')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('timeline.previous_surgeries')
                            ->label('الجراحات السابقة')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== الإحالة الطبية ====================
                Section::make('الإحالة الطبية')
                    ->icon('heroicon-o-paper-clip')
                    ->schema([
                        TextEntry::make('referringDoctor.first_name')
                            ->label('الطبيب المحول')
                            ->formatStateUsing(function ($record) {
                                if (!$record->referringDoctor) return 'لا يوجد';
                                $doctor = $record->referringDoctor;
                                return "د. {$doctor->first_name} {$doctor->last_name}" .
                                    ($doctor->specialty ? " - {$doctor->specialty}" : '');
                            })
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-user-circle'),

                        TextEntry::make('medicalAttachment.medical_referral')
                            ->label('تفاصيل الإحالة')
                            ->placeholder('لا توجد تفاصيل إحالة')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                // ==================== الفحص السريري ====================
                Section::make('الفحص السريري')
                    ->icon('heroicon-o-heart')
                    ->schema([
                        // العلامات الحيوية
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('clinicalExamination.blood_pressure')
                                    ->label('ضغط الدم')
                                    ->badge()
                                    ->color('danger')
                                    ->icon('heroicon-o-heart')
                                    ->placeholder('-'),

                                TextEntry::make('clinicalExamination.pulse')
                                    ->label('النبض')
                                    ->badge()
                                    ->suffix(' نبضة/دقيقة')
                                    ->color('info')
                                    ->placeholder('-'),

                                TextEntry::make('clinicalExamination.temperature')
                                    ->label('الحرارة')
                                    ->badge()
                                    ->suffix(' °C')
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('clinicalExamination.oxygen_saturation')
                                    ->label('الأكسجين')
                                    ->badge()
                                    ->suffix(' %')
                                    ->color('success')
                                    ->placeholder('-'),
                            ]),

                        TextEntry::make('clinicalExamination.weight')
                            ->label('الوزن')
                            ->suffix(' كغ')
                            ->placeholder('-'),

                        TextEntry::make('clinicalExamination.abdomen_pelvis_exam')
                            ->label('فحص البطن والحوض')
                            ->placeholder('لم يتم الفحص')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('clinicalExamination.rectal_exam')
                            ->label('المس الشرجي')
                            ->placeholder('لم يتم الفحص')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== إيكو البطن ====================
                Section::make('إيكو البطن')
                    ->icon('heroicon-o-wifi')
                    ->schema([
                        TextEntry::make('clinicalExamination.liver_echo')
                            ->label('الكبد')
                            ->placeholder('-')
                            ->markdown(),

                        TextEntry::make('clinicalExamination.gallbladder_echo')
                            ->label('المرارة')
                            ->placeholder('-')
                            ->markdown(),

                        TextEntry::make('clinicalExamination.pancreas_echo')
                            ->label('البنكرياس')
                            ->placeholder('-')
                            ->markdown(),

                        TextEntry::make('clinicalExamination.spleen_echo')
                            ->label('الطحال')
                            ->placeholder('-')
                            ->markdown(),

                        TextEntry::make('clinicalExamination.kidneys_echo')
                            ->label('الكليتين')
                            ->placeholder('-')
                            ->markdown(),

                        TextEntry::make('clinicalExamination.intestines_echo')
                            ->label('الأمعاء')
                            ->placeholder('-')
                            ->markdown(),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),

                // ==================== خطة العلاج ====================
                Section::make('خطة العلاج')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        TextEntry::make('treatmentPlan.medication_name')
                            ->label('الدواء')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('treatmentPlan.medication_form')
                            ->label('الشكل الدوائي')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'tablets' => 'مضغوطات',
                                'capsules' => 'كبسولات',
                                'syrup' => 'شراب',
                                'suppositories' => 'تحاميل',
                                'solution' => 'محلول',
                                default => $state ?? '-',
                            })
                            ->color('info')
                            ->placeholder('-'),

                        TextEntry::make('treatmentPlan.duration')
                            ->label('المدة')
                            ->badge()
                            ->color('warning')
                            ->placeholder('-'),

                        TextEntry::make('treatmentPlan.usage_instructions')
                            ->label('طريقة الاستخدام')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('treatmentPlan.requested_lab_tests')
                            ->label('التحاليل المطلوبة')
                            ->placeholder('لا توجد تحاليل مطلوبة')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('treatmentPlan.requested_imaging')
                            ->label('الأشعة المطلوبة')
                            ->placeholder('لا توجد أشعة مطلوبة')
                            ->markdown()
                            ->columnSpanFull(),

                        // التنظير
                        Grid::make(4)
                            ->schema([
                                IconEntry::make('treatmentPlan.needs_upper_endoscopy')
                                    ->label('تنظير علوي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('treatmentPlan.needs_colonoscopy')
                                    ->label('تنظير سفلي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('treatmentPlan.needs_ercp')
                                    ->label('ERCP')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                IconEntry::make('treatmentPlan.needs_guided_biopsy')
                                    ->label('خزعة موجهة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),

                        TextEntry::make('treatmentPlan.referrals_consultations')
                            ->label('الإحالة والاستشارات')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                // ==================== التشخيص والمتابعة ====================
                Section::make('التشخيص والمتابعة')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        TextEntry::make('followup.final_diagnosis')
                            ->label('التشخيص النهائي')
                            ->placeholder('لم يتم التشخيص بعد')
                            ->markdown()
                            ->weight('bold')
                            ->color('success')
                            ->columnSpanFull(),

                        // الأمراض المزمنة
                        TextEntry::make('followup.chronic_esophagus_stomach')
                            ->label('أمراض المريء والمعدة المزمنة')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('followup.chronic_intestines_colon')
                            ->label('أمراض الأمعاء والكولون المزمنة')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('followup.chronic_liver')
                            ->label('أمراض الكبد المزمنة')
                            ->placeholder('-')
                            ->markdown()
                            ->columnSpanFull(),

                        // المتابعة
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('followup.followup_required')
                                    ->label('يحتاج متابعة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                TextEntry::make('followup.followup_period')
                                    ->label('فترة المتابعة')
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        '1_week' => 'أسبوع واحد',
                                        '2_weeks' => 'أسبوعين',
                                        '1_month' => 'شهر',
                                        '2_months' => 'شهرين',
                                        '3_months' => '3 أشهر',
                                        '6_months' => '6 أشهر',
                                        '1_year' => 'سنة',
                                        default => $state ?? '-',
                                    })
                                    ->badge()
                                    ->color('info')
                                    ->placeholder('-'),

                                TextEntry::make('followup.final_status')
                                    ->label('الحالة النهائية')
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'recovery' => 'شفاء تام',
                                        'improvement' => 'تحسن',
                                        'under_treatment' => 'تحت العلاج',
                                        'death' => 'وفاة',
                                        default => $state ?? '-',
                                    })
                                    ->badge()
                                    ->color(fn (?string $state): string => match ($state) {
                                        'recovery' => 'success',
                                        'improvement' => 'info',
                                        'under_treatment' => 'warning',
                                        'death' => 'danger',
                                        default => 'gray',
                                    })
                                    ->icon(fn (?string $state): string => match ($state) {
                                        'recovery' => 'heroicon-o-check-circle',
                                        'improvement' => 'heroicon-o-arrow-trending-up',
                                        'under_treatment' => 'heroicon-o-clock',
                                        'death' => 'heroicon-o-x-circle',
                                        default => 'heroicon-o-question-mark-circle',
                                    })
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),

                // ==================== معلومات النظام ====================
                Section::make('معلومات النظام')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('أنشئت بواسطة')
                            ->icon('heroicon-o-user')
                            ->badge()
                            ->color('gray')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->icon('heroicon-o-calendar')
                            ->dateTime('Y-m-d H:i')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('updated_at')
                            ->label('آخر تحديث')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('Y-m-d H:i')
                            ->since()
                            ->badge()
                            ->color('warning'),

                        IconEntry::make('is_completed')
                            ->label('الزيارة مكتملة')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
