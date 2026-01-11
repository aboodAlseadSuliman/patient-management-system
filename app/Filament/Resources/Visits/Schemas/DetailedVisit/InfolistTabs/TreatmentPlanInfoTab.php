<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class TreatmentPlanInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('خطة العلاج')
            ->icon('heroicon-o-clipboard-document-check')
            ->badge(fn ($record) => $record->treatmentPlan ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. التعليمات والحمية ====================
                Section::make('التعليمات والحمية')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('تعليمات غذائية ونصائح حسب التشخيص')
                    ->schema([
                        TextEntry::make('treatmentPlan.gerd_instructions')
                            ->label('القلس المريئي (GERD)')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.dyspepsia_instructions')
                            ->label('عسر الهضم')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.ibs_instructions')
                            ->label('تشنج الكولون (IBS)')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.constipation_instructions')
                            ->label('الإمساك')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.gastroenteritis_instructions')
                            ->label('التهاب الأمعاء')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.celiac_instructions')
                            ->label('الداء الزلاقي (Celiac)')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.ibd_instructions')
                            ->label('الداء المعوي الالتهابي (IBD)')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.hemorrhoids_fissure_instructions')
                            ->label('البواسير والشق الشرجي')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.hepatitis_a_instructions')
                            ->label('التهاب الكبد A')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.hepatitis_b_instructions')
                            ->label('التهاب الكبد B')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.cirrhosis_instructions')
                            ->label('تشمع الكبد')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
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
                        TextEntry::make('treatmentPlan.medication_name')
                            ->label('الدواء المطلوب')
                            ->markdown()
                            ->placeholder('لا توجد أدوية موصوفة')
                            ->columnSpan(2),

                        TextEntry::make('treatmentPlan.medication_form')
                            ->label('الشكل الدوائي')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn (string $state = null): string => match ($state) {
                                'tablets' => 'مضغوطات',
                                'capsules' => 'كبسولات',
                                'syrup' => 'شراب',
                                'suppositories' => 'تحاميل',
                                'solution' => 'محلول',
                                default => 'غير محدد',
                            })
                            ->placeholder('غير محدد')
                            ->columnSpan(1),

                        TextEntry::make('treatmentPlan.duration')
                            ->label('المدة الزمنية')
                            ->badge()
                            ->color('warning')
                            ->placeholder('غير محدد')
                            ->columnSpan(1),

                        TextEntry::make('treatmentPlan.usage_instructions')
                            ->label('طريقة الاستخدام')
                            ->markdown()
                            ->placeholder('لا توجد تعليمات')
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== 3. التحاليل المطلوبة ====================
                Section::make('التحاليل المطلوبة')
                    ->icon('heroicon-o-beaker')
                    ->description('التحاليل المخبرية المطلوبة مع التعليمات')
                    ->schema([
                        TextEntry::make('treatmentPlan.lab_tests_input_method')
                            ->label('طريقة الإدخال')
                            ->badge()
                            ->color(fn (string $state = null): string => match ($state) {
                                'detailed' => 'success',
                                'simple' => 'info',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state = null): string => match ($state) {
                                'detailed' => 'تفصيلية - ملاحظات لكل تحليل',
                                'simple' => 'بسيطة - ملاحظات عامة',
                                default => 'تفصيلية',
                            })
                            ->columnSpanFull(),

                        TextEntry::make('lab_tests_display')
                            ->label(false)
                            ->state(function ($record) {
                                // تحميل العلاقات
                                $record->load(['labTests', 'treatmentPlan']);

                                $labTests = $record->labTests;
                                $inputMethod = $record->treatmentPlan?->lab_tests_input_method ?? 'detailed';

                                if ($labTests->isEmpty()) {
                                    return 'لا توجد تحاليل مطلوبة';
                                }

                                // إذا كانت الطريقة البسيطة
                                if ($inputMethod === 'simple') {
                                    $items = [];
                                    foreach ($labTests as $index => $labTest) {
                                        $number = $index + 1;

                                        // بناء النص بدون الرقم أولاً
                                        $text = "**{$labTest->name_ar}**";

                                        if ($labTest->abbreviation) {
                                            $text .= " ({$labTest->abbreviation})";
                                        }

                                        if ($labTest->name_en) {
                                            $text .= " - {$labTest->name_en}";
                                        }

                                        // إضافة الرقم في النهاية
                                        $items[] = "{$number}. {$text}";
                                    }

                                    $result = implode("\n\n", $items);

                                    // إضافة الملاحظات العامة
                                    if ($record->treatmentPlan?->lab_tests_simple_notes) {
                                        $result .= "\n\n---\n\n📋 **الملاحظات والتعليمات العامة:**\n\n" . $record->treatmentPlan->lab_tests_simple_notes;
                                    }

                                    return $result;
                                }

                                // الطريقة التفصيلية
                                $items = [];
                                foreach ($labTests as $index => $labTest) {
                                    $number = $index + 1;
                                    $text = "**{$number}. {$labTest->name_ar}**";

                                    if ($labTest->abbreviation) {
                                        $text .= " ({$labTest->abbreviation})";
                                    }

                                    if ($labTest->name_en) {
                                        $text .= " - {$labTest->name_en}";
                                    }

                                    if ($labTest->pivot && $labTest->pivot->notes) {
                                        $text .= "\n\n   📋 **التعليمات:** " . $labTest->pivot->notes;
                                    }

                                    $items[] = $text;
                                }

                                return implode("\n\n---\n\n", $items);
                            })
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->labTests && $record->labTests->count() > 0),

                // ==================== 4. الأدوية الموصوفة ====================
                Section::make('الأدوية الموصوفة')
                    ->icon('heroicon-o-beaker')
                    ->description('الأدوية الموصوفة مع تعليمات الاستخدام')
                    ->schema([
                        TextEntry::make('medications_display')
                            ->label(false)
                            ->state(function ($record) {
                                $record->load('medications');

                                $medications = $record->medications;

                                if ($medications->isEmpty()) {
                                    return 'لا توجد أدوية موصوفة';
                                }

                                $items = [];
                                foreach ($medications as $index => $medication) {
                                    $number = $index + 1;
                                    $text = "**{$number}. {$medication->name_ar}**";

                                    if ($medication->strength) {
                                        $text .= " ({$medication->strength})";
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
                                        $text .= ' - ' . ($forms[$medication->dosage_form] ?? $medication->dosage_form);
                                    }

                                    // معلومات الجرعة والتكرار
                                    $details = [];
                                    if ($medication->pivot && $medication->pivot->dosage) {
                                        $details[] = "**الجرعة:** {$medication->pivot->dosage}";
                                    }
                                    if ($medication->pivot && $medication->pivot->frequency) {
                                        $details[] = "**التكرار:** {$medication->pivot->frequency}";
                                    }
                                    if ($medication->pivot && $medication->pivot->duration) {
                                        $details[] = "**المدة:** {$medication->pivot->duration}";
                                    }
                                    if ($medication->pivot && $medication->pivot->instructions) {
                                        $details[] = "**التعليمات:** {$medication->pivot->instructions}";
                                    }

                                    if (!empty($details)) {
                                        $text .= "\n\n   " . implode(" | ", $details);
                                    }

                                    if ($medication->pivot && $medication->pivot->notes) {
                                        $text .= "\n\n   📋 **ملاحظات:** " . $medication->pivot->notes;
                                    }

                                    $items[] = $text;
                                }

                                return implode("\n\n---\n\n", $items);
                            })
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->medications && $record->medications->count() > 0),

                // ==================== 5. الأشعة المطلوبة ====================
                Section::make('الأشعة المطلوبة')
                    ->icon('heroicon-o-camera')
                    ->description('الفحوصات الإشعاعية المطلوبة مع التعليمات')
                    ->schema([
                        TextEntry::make('imaging_studies_display')
                            ->label(false)
                            ->state(function ($record) {
                                $record->load('imagingStudies');

                                $imagingStudies = $record->imagingStudies;

                                if ($imagingStudies->isEmpty()) {
                                    return 'لا توجد أشعة مطلوبة';
                                }

                                $items = [];
                                foreach ($imagingStudies as $index => $imaging) {
                                    $number = $index + 1;
                                    $text = "**{$number}. {$imaging->name_ar}**";

                                    // نوع الأشعة
                                    $types = [
                                        'x-ray' => 'أشعة عادية',
                                        'ct' => 'أشعة مقطعية',
                                        'mri' => 'رنين مغناطيسي',
                                        'ultrasound' => 'إيكو/سونار',
                                        'doppler' => 'دوبلر',
                                        'other' => 'أخرى',
                                    ];
                                    $typeLabel = $types[$imaging->type] ?? $imaging->type;
                                    $text .= " ({$typeLabel})";

                                    if ($imaging->body_part) {
                                        $text .= " - {$imaging->body_part}";
                                    }

                                    if ($imaging->abbreviation) {
                                        $text .= " ({$imaging->abbreviation})";
                                    }

                                    if ($imaging->pivot && $imaging->pivot->notes) {
                                        $text .= "\n\n   📋 **ملاحظات:** " . $imaging->pivot->notes;
                                    }

                                    $items[] = $text;
                                }

                                return implode("\n\n---\n\n", $items);
                            })
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn ($record) => $record->imagingStudies && $record->imagingStudies->count() > 0),

                // ==================== 6. التنظير ====================
                Section::make('التنظير المطلوب')
                    ->icon('heroicon-o-magnifying-glass-circle')
                    ->schema([
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

                        TextEntry::make('treatmentPlan.endoscopy_notes')
                            ->label('ملاحظات التنظير')
                            ->markdown()
                            ->placeholder('لا توجد ملاحظات')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 7. الإحالة والاستشارات ====================
                Section::make('الإحالة والاستشارات')
                    ->icon('heroicon-o-users')
                    ->schema([
                        TextEntry::make('treatmentPlan.referrals_consultations')
                            ->label('الإحالة والاستشارات')
                            ->markdown()
                            ->placeholder('لا توجد إحالات')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
