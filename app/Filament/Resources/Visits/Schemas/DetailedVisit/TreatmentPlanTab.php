<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
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
                    ->schema([
                        Textarea::make('treatmentPlan.requested_lab_tests')
                            ->label('التحاليل المطلوبة')
                            ->rows(3)
                            ->placeholder('CBC، وظائف الكبد، وظائف الكلى...')
                            ->helperText('يمكن إضافة التحاليل التفصيلية من التبويبات الأخرى')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 4. الأشعة المطلوبة ====================
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

                // ==================== 6. الإحالة والاستشارات ====================
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
