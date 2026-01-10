<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class FollowupTab
{
    public static function make(): Tab
    {
        return Tab::make('المتابعة والتشخيص النهائي')
            ->icon('heroicon-o-clipboard-document-check')
            ->badge(fn ($get) => $get('followup.final_diagnosis') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. التشخيص المبدئي ====================
                Section::make('التشخيص المبدئي (للدراسة)')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('التشخيصات المحتملة التي تحتاج إلى دراسة ومتابعة')
                    ->schema([
                        CheckboxList::make('preliminaryDiagnoses')
                            ->relationship('preliminaryDiagnoses', 'name_ar')
                            ->options(function () {
                                return \App\Models\Diagnosis::where('is_active', true)
                                    ->orderBy('category')
                                    ->orderBy('name_ar')
                                    ->get()
                                    ->mapWithKeys(function ($diagnosis) {
                                        $label = $diagnosis->name_ar;
                                        if ($diagnosis->name_en) {
                                            $label .= " ({$diagnosis->name_en})";
                                        }
                                        return [$diagnosis->id => $label];
                                    });
                            })
                            ->descriptions(function () {
                                return \App\Models\Diagnosis::where('is_active', true)
                                    ->orderBy('category')
                                    ->orderBy('name_ar')
                                    ->get()
                                    ->mapWithKeys(function ($diagnosis) {
                                        return [$diagnosis->id => $diagnosis->category ?? ''];
                                    });
                            })
                            ->searchable()
                            ->bulkToggleable()
                            ->gridDirection('row')
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== 2. التشخيص النهائي ====================
                Section::make('التشخيص النهائي')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('التشخيص المؤكد بعد الفحوصات والمتابعة')
                    ->schema([
                        Textarea::make('followup.final_diagnosis')
                            ->label('التشخيص النهائي')
                            ->rows(4)
                            ->placeholder('التشخيص المؤكد بناءً على الفحص السريري والفحوصات...')
                            ->helperText('اكتب التشخيص النهائي المؤكد هنا')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 3. الأمراض المزمنة ====================
                Section::make('الأمراض المزمنة حسب الجهاز')
                    ->icon('heroicon-o-heart')
                    ->description('الأمراض المزمنة المؤكدة مصنفة حسب الأعضاء')
                    ->schema([
                        Textarea::make('followup.chronic_esophagus_stomach')
                            ->label('1. أمراض المريء والمعدة المزمنة')
                            ->rows(2)
                            ->placeholder('مثال: قلس مريئي مزمن، قرحة معدة مزمنة، التهاب معدة مزمن...')
                            ->columnSpanFull(),

                        Textarea::make('followup.chronic_intestines_colon')
                            ->label('2. أمراض الأمعاء والكولون المزمنة')
                            ->rows(2)
                            ->placeholder('مثال: كولون عصبي، داء كرون، التهاب كولون تقرحي، داء زلاقي...')
                            ->columnSpanFull(),

                        Textarea::make('followup.chronic_liver')
                            ->label('3. أمراض الكبد المزمنة')
                            ->rows(2)
                            ->placeholder('مثال: تشمع كبد، التهاب كبد B مزمن، التهاب كبد C مزمن...')
                            ->columnSpanFull(),

                        Textarea::make('followup.chronic_biliary_pancreas')
                            ->label('4. أمراض الطرق الصفراوية والبنكرياس المزمنة')
                            ->rows(2)
                            ->placeholder('مثال: حصيات مرارية مزمنة، التهاب بنكرياس مزمن...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 4. المتابعة المطلوبة ====================
                Section::make('المتابعة المطلوبة')
                    ->icon('heroicon-o-calendar-days')
                    ->description('هل يحتاج المريض لمتابعة؟')
                    ->schema([
                        Checkbox::make('followup.followup_required')
                            ->label('يحتاج لمتابعة')
                            ->inline(false)
                            ->live()
                            ->columnSpan(1),

                        Select::make('followup.followup_period')
                            ->label('فترة المتابعة')
                            ->options([
                                '1_week' => 'أسبوع واحد',
                                '2_weeks' => 'أسبوعين',
                                '1_month' => 'شهر',
                                '2_months' => 'شهرين',
                                '3_months' => '3 أشهر',
                                '6_months' => '6 أشهر',
                                '1_year' => 'سنة',
                            ])
                            ->placeholder('اختر فترة المتابعة')
                            ->visible(fn ($get) => $get('followup.followup_required'))
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ==================== 5. الحالة النهائية ====================
                Section::make('الحالة النهائية للمريض')
                    ->icon('heroicon-o-heart')
                    ->description('الحالة العامة للمريض عند إنهاء الزيارة')
                    ->schema([
                        Select::make('followup.final_status')
                            ->label('الحالة النهائية')
                            ->options([
                                'recovery' => 'شفاء تام (Recovery)',
                                'improvement' => 'تحسن (Improvement)',
                                'under_treatment' => 'تحت العلاج (Under Treatment)',
                                'death' => 'وفاة (Death)',
                            ])
                            ->placeholder('اختر الحالة النهائية للمريض')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
