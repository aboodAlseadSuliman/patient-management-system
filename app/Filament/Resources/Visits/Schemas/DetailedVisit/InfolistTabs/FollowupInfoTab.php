<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class FollowupInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('المتابعة والتشخيص النهائي')
            ->icon('heroicon-o-clipboard-document-check')
            ->badge(fn ($record) => $record->followup ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== 1. التشخيص المبدئي ====================
                Section::make('التشخيص المبدئي (للدراسة)')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('التشخيصات المحتملة التي تحتاج إلى دراسة ومتابعة')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('followup.ulcers_for_study')
                                    ->label('قرحات للدراسة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.dysphagia_for_study')
                                    ->label('عسرة بلع للدراسة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_gerd')
                                    ->label('قلس مريئي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.ibs_suspected')
                                    ->label('كولون عصبي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_malabsorption')
                                    ->label('سوء امتصاص مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_celiac')
                                    ->label('داء زلاقي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_ibd')
                                    ->label('داء معوي التهابي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_hemorrhoids_fissure')
                                    ->label('بواسير/شق شرجي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_liver_disease')
                                    ->label('مرض كبدي مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_hepatitis_a')
                                    ->label('التهاب كبد A مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_hepatitis_b')
                                    ->label('التهاب كبد B مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_cirrhosis')
                                    ->label('تشمع كبد مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_gallstones')
                                    ->label('حصيات مرارية مشتبهة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_pancreatitis')
                                    ->label('التهاب بنكرياس مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.gi_bleeding_for_study')
                                    ->label('نزف هضمي للدراسة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.acute_abdomen_for_study')
                                    ->label('بطن حادة للدراسة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.suspected_malignancy')
                                    ->label('ورم خبيث مشتبه')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('followup.other_suspected_diagnosis')
                                    ->label('تشخيصات أخرى مشتبهة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== 2. التشخيص النهائي ====================
                Section::make('التشخيص النهائي')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('التشخيص المؤكد بعد الفحوصات والمتابعة')
                    ->schema([
                        TextEntry::make('followup.final_diagnosis')
                            ->label('التشخيص النهائي')
                            ->markdown()
                            ->placeholder('لم يتم تحديد التشخيص النهائي بعد')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 3. الأمراض المزمنة ====================
                Section::make('الأمراض المزمنة حسب الجهاز')
                    ->icon('heroicon-o-heart')
                    ->description('الأمراض المزمنة المؤكدة مصنفة حسب الأعضاء')
                    ->schema([
                        TextEntry::make('followup.chronic_esophagus_stomach')
                            ->label('أمراض المريء والمعدة المزمنة')
                            ->markdown()
                            ->placeholder('لا توجد أمراض مزمنة')
                            ->columnSpanFull(),

                        TextEntry::make('followup.chronic_intestines_colon')
                            ->label('أمراض الأمعاء والكولون المزمنة')
                            ->markdown()
                            ->placeholder('لا توجد أمراض مزمنة')
                            ->columnSpanFull(),

                        TextEntry::make('followup.chronic_liver')
                            ->label('أمراض الكبد المزمنة')
                            ->markdown()
                            ->placeholder('لا توجد أمراض مزمنة')
                            ->columnSpanFull(),

                        TextEntry::make('followup.chronic_biliary_pancreas')
                            ->label('أمراض الطرق الصفراوية والبنكرياس المزمنة')
                            ->markdown()
                            ->placeholder('لا توجد أمراض مزمنة')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== 4. المتابعة المطلوبة ====================
                Section::make('المتابعة المطلوبة')
                    ->icon('heroicon-o-calendar-days')
                    ->description('هل يحتاج المريض لمتابعة؟')
                    ->schema([
                        IconEntry::make('followup.followup_required')
                            ->label('يحتاج لمتابعة')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('info')
                            ->falseColor('gray')
                            ->columnSpan(1),

                        TextEntry::make('followup.followup_period')
                            ->label('فترة المتابعة')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn (string $state = null): string => match ($state) {
                                '1_week' => 'أسبوع واحد',
                                '2_weeks' => 'أسبوعين',
                                '1_month' => 'شهر',
                                '2_months' => 'شهرين',
                                '3_months' => '3 أشهر',
                                '6_months' => '6 أشهر',
                                '1_year' => 'سنة',
                                default => 'غير محدد',
                            })
                            ->placeholder('غير محدد')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ==================== 5. الحالة النهائية ====================
                Section::make('الحالة النهائية للمريض')
                    ->icon('heroicon-o-heart')
                    ->description('الحالة العامة للمريض عند إنهاء الزيارة')
                    ->schema([
                        TextEntry::make('followup.final_status')
                            ->label('الحالة النهائية')
                            ->badge()
                            ->color(fn (string $state = null): string => match ($state) {
                                'recovery' => 'success',
                                'improvement' => 'info',
                                'under_treatment' => 'warning',
                                'death' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state = null): string => match ($state) {
                                'recovery' => 'شفاء تام (Recovery)',
                                'improvement' => 'تحسن (Improvement)',
                                'under_treatment' => 'تحت العلاج (Under Treatment)',
                                'death' => 'وفاة (Death)',
                                default => 'غير محدد',
                            })
                            ->placeholder('غير محدد')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
