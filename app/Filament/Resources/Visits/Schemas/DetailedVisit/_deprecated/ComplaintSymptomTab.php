<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\CheckboxList;

/**
 * تبويبة الشكاية الرئيسية والأعراض
 *
 * هذا مثال كامل لتبويبة واحدة - يمكنك نسخ هذا النمط للتبويبات الأخرى
 */
class ComplaintSymptomTab
{
    public static function make(): Tab
    {
        return Tab::make('الشكاية والأعراض')
            ->icon('heroicon-o-clipboard-document-list')
            ->badge(fn($get) => $get('complaintSymptom.chief_complaint') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== المربع الأول: الشكاية الرئيسية ====================
                Section::make('الشكاية الرئيسية')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Textarea::make('complaintSymptom.chief_complaint')
                            ->label('1. الشكاية الرئيسية')
                            ->rows(2)
                            ->placeholder('الشكاية الرئيسية للمريض...')
                            ->columnSpan(2),

                        Textarea::make('complaintSymptom.complaint_characteristics')
                            ->label('2. مواصفات الشكاية')
                            ->rows(2)
                            ->placeholder('وصف تفصيلي للشكاية...')
                            ->columnSpan(2),

                        Textarea::make('complaintSymptom.associated_symptoms')
                            ->label('3. الأعراض المرافقة')
                            ->rows(2)
                            ->placeholder('الأعراض الأخرى المصاحبة...')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ==================== القائمة - المريء ====================
                Section::make('القائمة - المريء')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Checkbox::make('complaintSymptom.oral_thrush')
                            ->label('1. قلاع فموي'),

                        Checkbox::make('complaintSymptom.bad_breath')
                            ->label('2. رائحة الفم'),

                        Checkbox::make('complaintSymptom.mouth_breathing')
                            ->label('تنفس من الفم'),

                        Checkbox::make('complaintSymptom.snoring')
                            ->label('شخير'),

                        Checkbox::make('complaintSymptom.dental_lesions')
                            ->label('آفات سنية'),

                        Checkbox::make('complaintSymptom.globus')
                            ->label('3. لقمة'),



                        Checkbox::make('complaintSymptom.odynophagia')
                            ->label('4. بلع مؤلم'),

                        Checkbox::make('complaintSymptom.hiccup')
                            ->label('5. فواق'),

                        Checkbox::make('complaintSymptom.esophageal_reflux')
                            ->label('6. قلس مريئي'),

                        Select::make('complaintSymptom.dysphagia')
                            ->label('7. عسر بلع')
                            ->options([
                                'solids' => 'للجوامد',
                                'liquids' => 'للسوائل',
                                'both' => 'للجوامد والسوائل',
                            ])
                            ->placeholder('اختر النوع'),
                    ])
                    ->columns(5)
                    ->collapsible()
                    ->collapsed(),

                // ==================== المعدة ====================
                Section::make('المعدة')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Select::make('complaintSymptom.dyspepsia')
                            ->label('8. عسر الهضم')
                            ->options([
                                'ulcer' => 'قرحي',
                                'functional' => 'خزلي (وظيفي)',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.vomiting')
                            ->label('9. إقياء')
                            ->options([
                                'proximal_obstruction' => 'انسدادي قريب',
                                'distal_obstruction' => 'انسدادي بعيد',
                                'vestibular' => 'دهليزي',
                                'neurological' => 'عصبي',
                                'other' => 'آخر',
                            ])
                            ->placeholder('اختر النوع'),


                        Select::make('complaintSymptom.anemia')
                            ->label('10. فقر دم')
                            ->options([
                                'iron_deficiency' => 'نقص الحديد',
                                'b12_deficiency' => 'نقص B12',
                                'other' => 'آخر',
                            ])
                            ->placeholder('اختر النوع'),

                        Checkbox::make('complaintSymptom.melena')
                            ->label('11. تغوط زفتي'),


                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== الأمعاء والكولون ====================
                Section::make('الأمعاء والكولون')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Checkbox::make('complaintSymptom.growth_failure')
                            ->label('12. ضعف نمو'),


                        Checkbox::make('complaintSymptom.bloating_gas')
                            ->label('13. نفخة وغازات'),

                        Checkbox::make('complaintSymptom.constipation')
                            ->label('14. إمساك'),

                        Checkbox::make('complaintSymptom.bowel_habit_change')
                            ->label('15. تغير عادات معوية'),

                        Select::make('complaintSymptom.abdominal_pain')
                            ->label('16. ألم بطني')
                            ->options([
                                'pancreatic' => 'بنكرياسي',
                                'ischemic' => 'إقفاري',
                                'urological' => 'بولي',
                                'gynecological' => 'نسائي',
                                'biliary' => 'صفراوي',
                                'cardiac' => 'قلبي',
                                'parietal' => 'جداري',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.colon_spasm')
                            ->label('17. تشنج كولون')
                            ->options([
                                'with_constipation' => 'مع إمساك مسيطر',
                                'with_diarrhea' => 'مع إسهال مسيطر',
                                'alternating' => 'تناوب إمساك وإسهال',
                            ])
                            ->placeholder('اختر النوع'),


                        Select::make('complaintSymptom.diarrhea')
                            ->label('18. إسهال')
                            ->options([
                                'fatty' => 'دهني',
                                'inflammatory' => 'التهابي',
                                'mucous' => 'مخاطي',
                                'bloody' => 'مدمى',
                            ])
                            ->placeholder('اختر النوع'),


                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== المستقيم والشرج ====================
                Section::make('المستقيم والشرج')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Checkbox::make('complaintSymptom.difficult_defecation')
                            ->label('19. صعوبة تبرز'),

                        Checkbox::make('complaintSymptom.tenesmus')
                            ->label('20. زحير'),

                        Checkbox::make('complaintSymptom.anal_pain')
                            ->label('21. ألم شرجي'),

                        Checkbox::make('complaintSymptom.anal_itching')
                            ->label('22. حكة شرجية'),

                        Select::make('complaintSymptom.rectal_bleeding')
                            ->label('23. نزف مستقيمي')
                            ->options([
                                'with_stool' => 'مع البراز',
                                'after_defecation' => 'بعد التبرز',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.incontinence')
                            ->label('24. عدم استمساك')
                            ->options([
                                'neurological' => 'عصبي',
                                'urgency' => 'إلحاحي',
                                'overflow' => 'بالإفاضة',
                            ])
                            ->placeholder('اختر النوع'),


                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),

                // ==================== الكبد والطرق الصفراوية ====================
                Section::make('الكبد والطرق الصفراوية')
                    ->icon('heroicon-o-beaker')
                    ->schema([


                        Select::make('complaintSymptom.hepatitis')
                            ->label('25. التهاب كبد')
                            ->options([
                                'icteric' => 'يرقاني',
                                'anicteric' => 'لا يرقاني',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make(name: 'complaintSymptom.jaundice')
                            ->label('26. يرقان')
                            ->options([
                                'hemolytic' => 'انحلالي',
                                'hepatic' => 'كبدي',
                                'cholestatic' => 'ركودي',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.fatty_liver')
                            ->label(label: '27. تشحم كبد')
                            ->options([
                                'alcoholic' => 'كحولي',
                                'non_alcoholic' => 'لا كحولي',
                            ])
                            ->placeholder('اختر النوع'),


                        Select::make('complaintSymptom.liver_masses')
                            ->label('28. كتل كبدية')
                            ->options([
                                'cystic' => 'كيسية',
                                'solid' => 'صلبة',
                            ])
                            ->placeholder('اختر النوع'),

                        Checkbox::make('complaintSymptom.ascites')
                            ->label('29. حبن'),

                        Checkbox::make('complaintSymptom.elevated_liver_enzymes')
                            ->label('30. ارتفاع إنزيمات الكبد'),
                        Checkbox::make('complaintSymptom.liver_cirrhosis')
                            ->label('31. تشمع كبد'),

                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== الأعضاء الأخرى ====================
                Section::make('الأعضاء الأخرى')
                    ->icon('heroicon-o-beaker')
                    ->description('أعراض الأجهزة الأخرى المرتبطة')
                    ->schema([
                        // الجهاز التنفسي
                        Select::make('complaintSymptom.cough')
                            ->label('32. سعال')
                            ->options([
                                'dry' => 'جاف',
                                'productive' => 'مع قشع',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.dyspnea')
                            ->label('33. زلة تنفسية')
                            ->options([
                                'exertional' => 'جهدية',
                                'orthopnea' => 'اضطجاعية',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.chest_pain')
                            ->label('34. ألم صدري')
                            ->options([
                                'anginal' => 'خناقي',
                                'pleuritic' => 'جنبي',
                                'esophageal' => 'مريئي',
                                'parietal' => 'جداري',
                            ])
                            ->placeholder('اختر النوع'),
                        Select::make('complaintSymptom.dizziness')
                            ->label('35. دوار')
                            ->options([
                                'cardiovascular' => 'قلبي وعائي',
                                'neurological' => 'عصبي',
                                'vestibular' => 'دهليزي',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.skin_rash')
                            ->label('36. طفح جلدي')
                            ->options([
                                'urticarial' => 'شروي',
                                'vesicular' => 'حويصلي',
                                'papular' => 'حطاطي',
                                'purpura' => 'فرفريات',
                                'other' => 'آخر',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.joint_pain')
                            ->label('37. آلام مفصلية')
                            ->options([
                                'central' => 'مركزية',
                                'peripheral' => 'محيطية',
                            ])
                            ->placeholder('اختر النوع'),

                        // أعراض عامة
                        Select::make('complaintSymptom.fever')
                            ->label('38. حمى')
                            ->options([
                                'diurnal' => 'نهارية',
                                'nocturnal' => 'ليلية',
                            ])
                            ->placeholder('اختر النوع'),

                        Select::make('complaintSymptom.weight_loss')
                            ->label('39. نقص وزن')
                            ->options([
                                'voluntary' => 'إرادي',
                                'involuntary' => 'لا إرادي',
                            ])
                            ->placeholder('اختر النوع'),
                        Checkbox::make('complaintSymptom.hemoptysis')
                            ->label('40. نفث دموي'),

                        // الجهاز العصبي

                        Checkbox::make('complaintSymptom.tremor')
                            ->label('41. رجفان'),

                        Checkbox::make('complaintSymptom.mental_confusion')
                            ->label('42. تخليط ذهني'),

                        // الجهاز البولي
                        Checkbox::make('complaintSymptom.dysuria')
                            ->label('43. عسر تبول'),

                        Checkbox::make('complaintSymptom.hematuria')
                            ->label('44. بيلة دموية'),

                        // الجلد والمفاصل

                        Checkbox::make('complaintSymptom.itching')
                            ->label('45. حكة'),


                        Checkbox::make('complaintSymptom.fatigue')
                            ->label('46. تعب ووهن'),


                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
