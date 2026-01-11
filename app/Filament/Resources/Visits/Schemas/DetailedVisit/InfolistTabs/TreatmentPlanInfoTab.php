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
                                        $text = "**{$number}. {$labTest->name_ar}**";

                                        if ($labTest->abbreviation) {
                                            $text .= " ({$labTest->abbreviation})";
                                        }

                                        if ($labTest->name_en) {
                                            $text .= " - {$labTest->name_en}";
                                        }

                                        $items[] = $text;
                                    }

                                    $result = implode("\n", $items);

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

                // ==================== 4. الأشعة المطلوبة ====================
                Section::make('الأشعة المطلوبة')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        TextEntry::make('treatmentPlan.requested_imaging')
                            ->label('الأشعة المطلوبة')
                            ->markdown()
                            ->placeholder('لا توجد أشعة مطلوبة')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 5. التنظير ====================
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

                // ==================== 6. الإحالة والاستشارات ====================
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
