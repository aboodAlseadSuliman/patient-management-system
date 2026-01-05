<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class ComplaintSymptomInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('الشكاية والأعراض')
            ->icon('heroicon-o-clipboard-document-list')
            ->badge(fn ($record) => $record->complaintSymptom ? '✓' : null)
            ->badgeColor('success')
            ->schema([
                // ==================== الشكاية الرئيسية ====================
                Section::make('الشكاية الرئيسية')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('complaintSymptom.chief_complaint')
                            ->label('1. الشكاية الرئيسية')
                            ->icon('heroicon-o-exclamation-circle')
                            ->placeholder('لا توجد شكوى مسجلة')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('complaintSymptom.complaint_characteristics')
                            ->label('2. مواصفات الشكاية')
                            ->placeholder('لم يتم التحديد')
                            ->markdown()
                            ->columnSpanFull(),

                        TextEntry::make('complaintSymptom.associated_symptoms')
                            ->label('3. الأعراض المرافقة')
                            ->placeholder('لا توجد أعراض مصاحبة')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                // ==================== القائمة والمريء ====================
                Section::make('القائمة - المريء')
                    ->icon('heroicon-o-beaker')
                    ->description('أعراض الفم والمريء')
                    ->schema([
                        Grid::make(5)
                            ->schema([
                                IconEntry::make('complaintSymptom.oral_thrush')
                                    ->label('1. قلاع فموي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.bad_breath')
                                    ->label('2. رائحة الفم')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.mouth_breathing')
                                    ->label('تنفس من الفم')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('info')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.snoring')
                                    ->label('شخير')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.dental_lesions')
                                    ->label('آفات سنية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.globus')
                                    ->label('3. لقمة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.odynophagia')
                                    ->label('4. بلع مؤلم')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.hiccup')
                                    ->label('5. فواق')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('info')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.esophageal_reflux')
                                    ->label('6. قلس مريئي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                TextEntry::make('complaintSymptom.dysphagia')
                                    ->label('7. عسر بلع')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'solids' => 'للجوامد',
                                        'liquids' => 'للسوائل',
                                        'both' => 'للجوامد والسوائل',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== المعدة ====================
                Section::make('المعدة')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('complaintSymptom.dyspepsia')
                                    ->label('8. عسر الهضم')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'ulcer' => 'قرحي',
                                        'functional' => 'خزلي (وظيفي)',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.vomiting')
                                    ->label('9. إقياء')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'proximal_obstruction' => 'انسدادي قريب',
                                        'distal_obstruction' => 'انسدادي بعيد',
                                        'vestibular' => 'دهليزي',
                                        'neurological' => 'عصبي',
                                        'other' => 'آخر',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.anemia')
                                    ->label('10. فقر دم')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'iron_deficiency' => 'نقص الحديد',
                                        'b12_deficiency' => 'نقص B12',
                                        'other' => 'آخر',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                IconEntry::make('complaintSymptom.melena')
                                    ->label('11. تغوط زفتي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== الأمعاء والكولون ====================
                Section::make('الأمعاء والكولون')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                IconEntry::make('complaintSymptom.growth_failure')
                                    ->label('12. ضعف نمو')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.bloating_gas')
                                    ->label('13. نفخة وغازات')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.constipation')
                                    ->label('14. إمساك')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.bowel_habit_change')
                                    ->label('15. تغير عادات معوية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                TextEntry::make('complaintSymptom.abdominal_pain')
                                    ->label('16. ألم بطني')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'pancreatic' => 'بنكرياسي',
                                        'ischemic' => 'إقفاري',
                                        'urological' => 'بولي',
                                        'gynecological' => 'نسائي',
                                        'biliary' => 'صفراوي',
                                        'cardiac' => 'قلبي',
                                        'parietal' => 'جداري',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.colon_spasm')
                                    ->label('17. تشنج كولون')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'with_constipation' => 'مع إمساك مسيطر',
                                        'with_diarrhea' => 'مع إسهال مسيطر',
                                        'alternating' => 'تناوب إمساك وإسهال',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.diarrhea')
                                    ->label('18. إسهال')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'fatty' => 'دهني',
                                        'inflammatory' => 'التهابي',
                                        'mucous' => 'مخاطي',
                                        'bloody' => 'مدمى',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== المستقيم والشرج ====================
                Section::make('المستقيم والشرج')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('complaintSymptom.difficult_defecation')
                                    ->label('19. صعوبة تبرز')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.tenesmus')
                                    ->label('20. زحير')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.anal_pain')
                                    ->label('21. ألم شرجي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.anal_itching')
                                    ->label('22. حكة شرجية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                TextEntry::make('complaintSymptom.rectal_bleeding')
                                    ->label('23. نزف مستقيمي')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'with_stool' => 'مع البراز',
                                        'after_defecation' => 'بعد التبرز',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.incontinence')
                                    ->label('24. عدم استمساك')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'neurological' => 'عصبي',
                                        'urgency' => 'إلحاحي',
                                        'overflow' => 'بالإفاضة',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== الكبد والطرق الصفراوية ====================
                Section::make('الكبد والطرق الصفراوية')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('complaintSymptom.hepatitis')
                                    ->label('25. التهاب كبد')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'icteric' => 'يرقاني',
                                        'anicteric' => 'لا يرقاني',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.jaundice')
                                    ->label('26. يرقان')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'hemolytic' => 'انحلالي',
                                        'hepatic' => 'كبدي',
                                        'cholestatic' => 'ركودي',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.fatty_liver')
                                    ->label('27. تشحم كبد')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'alcoholic' => 'كحولي',
                                        'non_alcoholic' => 'لا كحولي',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.liver_masses')
                                    ->label('28. كتل كبدية')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'cystic' => 'كيسية',
                                        'solid' => 'صلبة',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                IconEntry::make('complaintSymptom.ascites')
                                    ->label('29. حبن')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.elevated_liver_enzymes')
                                    ->label('30. ارتفاع إنزيمات الكبد')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.liver_cirrhosis')
                                    ->label('31. تشمع كبد')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // ==================== الأعضاء الأخرى ====================
                Section::make('الأعضاء الأخرى')
                    ->icon('heroicon-o-beaker')
                    ->description('أعراض الأجهزة الأخرى المرتبطة')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                // الجهاز التنفسي
                                TextEntry::make('complaintSymptom.cough')
                                    ->label('32. سعال')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'dry' => 'جاف',
                                        'productive' => 'مع قشع',
                                        default => '-',
                                    })
                                    ->color('info')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.dyspnea')
                                    ->label('33. زلة تنفسية')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'exertional' => 'جهدية',
                                        'orthopnea' => 'اضطجاعية',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.chest_pain')
                                    ->label('34. ألم صدري')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'anginal' => 'خناقي',
                                        'pleuritic' => 'جنبي',
                                        'esophageal' => 'مريئي',
                                        'parietal' => 'جداري',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.dizziness')
                                    ->label('35. دوار')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'cardiovascular' => 'قلبي وعائي',
                                        'neurological' => 'عصبي',
                                        'vestibular' => 'دهليزي',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.skin_rash')
                                    ->label('36. طفح جلدي')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'urticarial' => 'شروي',
                                        'vesicular' => 'حويصلي',
                                        'papular' => 'حطاطي',
                                        'purpura' => 'فرفريات',
                                        'other' => 'آخر',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.joint_pain')
                                    ->label('37. آلام مفصلية')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'central' => 'مركزية',
                                        'peripheral' => 'محيطية',
                                        default => '-',
                                    })
                                    ->color('warning')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.fever')
                                    ->label('38. حمى')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'diurnal' => 'نهارية',
                                        'nocturnal' => 'ليلية',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                TextEntry::make('complaintSymptom.weight_loss')
                                    ->label('39. نقص وزن')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'voluntary' => 'إرادي',
                                        'involuntary' => 'لا إرادي',
                                        default => '-',
                                    })
                                    ->color('danger')
                                    ->placeholder('-'),

                                IconEntry::make('complaintSymptom.hemoptysis')
                                    ->label('40. نفث دموي')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.tremor')
                                    ->label('41. رجفان')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.mental_confusion')
                                    ->label('42. تخليط ذهني')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.dysuria')
                                    ->label('43. عسر تبول')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.hematuria')
                                    ->label('44. بيلة دموية')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.itching')
                                    ->label('45. حكة')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                IconEntry::make('complaintSymptom.fatigue')
                                    ->label('46. تعب ووهن')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
