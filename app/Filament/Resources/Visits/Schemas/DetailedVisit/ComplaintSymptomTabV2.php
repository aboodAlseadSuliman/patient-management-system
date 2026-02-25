<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

class ComplaintSymptomTabV2
{
    private static function getComplaintsData(): array
    {
        return [
            // ==================== المريء ====================
            'oral_thrush'          => ['label' => '1. قلاع فموي',              'sub_options' => []],
            'bad_breath'           => ['label' => '2. رائحة الفم',             'sub_options' => []],
            'globus'               => ['label' => '3. لقمة',                   'sub_options' => []],
            'odynophagia'          => ['label' => '4. بلع مؤلم',               'sub_options' => []],
            'hiccup'               => ['label' => '5. فواق',                   'sub_options' => []],
            'esophageal_reflux'    => ['label' => '6. قلس مريئي',              'sub_options' => []],
            'dysphagia'            => ['label' => '7. عسر بلع',                'sub_options' => [
                'solids'  => 'للجوامد',
                'liquids' => 'للسوائل',
                'both'    => 'للجوامد والسوائل',
            ]],

            // ==================== المعدة ====================
            'dyspepsia'            => ['label' => '8. عسر الهضم',              'sub_options' => [
                'ulcer'      => 'قرحي',
                'functional' => 'خزلي (وظيفي)',
            ]],
            'vomiting'             => ['label' => '9. إقياء',                  'sub_options' => [
                'proximal_obstruction' => 'انسدادي قريب',
                'distal_obstruction'   => 'انسدادي بعيد',
                'vestibular'           => 'دهليزي',
                'neurological'         => 'عصبي',
                'other'                => 'آخر',
            ]],
            'anemia'               => ['label' => '10. فقر دم',                'sub_options' => [
                'iron_deficiency' => 'نقص الحديد',
                'b12_deficiency'  => 'نقص B12',
                'other'           => 'آخر',
            ]],
            'melena'               => ['label' => '11. تغوط زفتي',             'sub_options' => []],

            // ==================== الأمعاء والكولون ====================
            'growth_failure'       => ['label' => '12. ضعف نمو',               'sub_options' => []],
            'bloating_gas'         => ['label' => '13. نفخة وغازات',           'sub_options' => []],
            'constipation'         => ['label' => '14. إمساك',                 'sub_options' => []],
            'bowel_habit_change'   => ['label' => '15. تغير عادات معوية',      'sub_options' => []],
            'abdominal_pain'       => ['label' => '16. ألم بطني',              'sub_options' => [
                'pancreatic'    => 'بنكرياسي',
                'ischemic'      => 'إقفاري',
                'urological'    => 'بولي',
                'gynecological' => 'نسائي',
                'biliary'       => 'صفراوي',
                'cardiac'       => 'قلبي',
                'parietal'      => 'جداري',
            ]],
            'colon_spasm'          => ['label' => '17. تشنج كولون',            'sub_options' => [
                'with_constipation' => 'مع إمساك مسيطر',
                'with_diarrhea'     => 'مع إسهال مسيطر',
                'alternating'       => 'تناوب إمساك وإسهال',
            ]],
            'diarrhea'             => ['label' => '18. إسهال',                 'sub_options' => [
                'fatty'        => 'دهني',
                'inflammatory' => 'التهابي',
                'mucous'       => 'مخاطي',
                'bloody'       => 'مدمى',
            ]],

            // ==================== المستقيم والشرج ====================
            'difficult_defecation' => ['label' => '19. صعوبة تبرز',            'sub_options' => []],
            'tenesmus'             => ['label' => '20. زحير',                  'sub_options' => []],
            'anal_pain'            => ['label' => '21. ألم شرجي',              'sub_options' => []],
            'anal_itching'         => ['label' => '22. حكة شرجية',             'sub_options' => []],
            'rectal_bleeding'      => ['label' => '23. نزف مستقيمي',           'sub_options' => [
                'with_stool'       => 'مع البراز',
                'after_defecation' => 'بعد التبرز',
            ]],
            'incontinence'         => ['label' => '24. عدم استمساك',           'sub_options' => [
                'neurological' => 'عصبي',
                'urgency'      => 'إلحاحي',
                'overflow'     => 'بالإفاضة',
            ]],

            // ==================== الكبد والطرق الصفراوية ====================
            'hepatitis'            => ['label' => '25. التهاب كبد',            'sub_options' => [
                'icteric'   => 'يرقاني',
                'anicteric' => 'لا يرقاني',
            ]],
            'jaundice'             => ['label' => '26. يرقان',                 'sub_options' => [
                'hemolytic'   => 'انحلالي',
                'hepatic'     => 'كبدي',
                'cholestatic' => 'ركودي',
            ]],
            'fatty_liver'          => ['label' => '27. تشحم كبد',              'sub_options' => [
                'alcoholic'     => 'كحولي',
                'non_alcoholic' => 'لا كحولي',
            ]],
            'liver_masses'         => ['label' => '28. كتل كبدية',             'sub_options' => [
                'cystic' => 'كيسية',
                'solid'  => 'صلبة',
            ]],
            'ascites'              => ['label' => '29. حبن',                   'sub_options' => []],
            'elevated_liver_enzymes' => ['label' => '30. ارتفاع إنزيمات الكبد', 'sub_options' => []],
            'liver_cirrhosis'      => ['label' => '31. تشمع كبد',              'sub_options' => []],

            // ==================== الأعضاء الأخرى ====================
            'cough'                => ['label' => '32. سعال',                  'sub_options' => [
                'dry'        => 'جاف',
                'productive' => 'مع قشع',
            ]],
            'dyspnea'              => ['label' => '33. زلة تنفسية',            'sub_options' => [
                'exertional' => 'جهدية',
                'orthopnea'  => 'اضطجاعية',
            ]],
            'chest_pain'           => ['label' => '34. ألم صدري',              'sub_options' => [
                'anginal'    => 'خناقي',
                'pleuritic'  => 'جنبي',
                'esophageal' => 'مريئي',
                'parietal'   => 'جداري',
            ]],
            'dizziness'            => ['label' => '35. دوار',                  'sub_options' => [
                'cardiovascular' => 'قلبي وعائي',
                'neurological'   => 'عصبي',
                'vestibular'     => 'دهليزي',
            ]],
            'skin_rash'            => ['label' => '36. طفح جلدي',              'sub_options' => [
                'urticarial' => 'شروي',
                'vesicular'  => 'حويصلي',
                'papular'    => 'حطاطي',
                'purpura'    => 'فرفريات',
                'other'      => 'آخر',
            ]],
            'joint_pain'           => ['label' => '37. آلام مفصلية',           'sub_options' => [
                'central'    => 'مركزية',
                'peripheral' => 'محيطية',
            ]],
            'fever'                => ['label' => '38. حمى',                   'sub_options' => [
                'diurnal'   => 'نهارية',
                'nocturnal' => 'ليلية',
            ]],
            'weight_loss'          => ['label' => '39. نقص وزن',               'sub_options' => [
                'voluntary'   => 'إرادي',
                'involuntary' => 'لا إرادي',
            ]],
            'hemoptysis'           => ['label' => '40. نفث دموي',              'sub_options' => []],
            'tremor'               => ['label' => '41. رجفان',                 'sub_options' => []],
            'mental_confusion'     => ['label' => '42. تخليط ذهني',            'sub_options' => []],
            'dysuria'              => ['label' => '43. عسر تبول',              'sub_options' => []],
            'hematuria'            => ['label' => '44. بيلة دموية',            'sub_options' => []],
            'itching'              => ['label' => '45. حكة',                   'sub_options' => []],
            'fatigue'              => ['label' => '46. تعب ووهن',              'sub_options' => []],
        ];
    }

    public static function make(): Tab
    {
        return Tab::make('الشكاية والأعراض (تجريبي 2)')
            ->icon('heroicon-o-clipboard-document-check')
            ->badge(fn($get) => $get('complaint_v2.chief_complaint') ? '✓' : null)
            ->badgeColor('success')
            ->schema([

                // ==================== المربع الأول: الشكاية الرئيسية ====================
                Section::make('الشكاية الرئيسية')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Select::make('complaint_v2.chief_complaint')
                            ->label('الشكاية الرئيسية')
                            ->options(
                                collect(static::getComplaintsData())
                                    ->map(fn($v) => $v['label'])
                                    ->all()
                            )
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->placeholder('اختر الشكاية الرئيسية...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== المربع الثاني: مواصفات الشكاية ====================
                Section::make('مواصفات الشكاية')
                    ->icon('heroicon-o-list-bullet')
                    ->description(fn(Get $get) =>
                        static::getComplaintsData()[$get('complaint_v2.chief_complaint')]['label'] ?? null
                    )
                    ->schema([
                        Select::make('complaint_v2.sub_type')
                            ->label('النوع')
                            ->options(fn(Get $get) =>
                                static::getComplaintsData()[$get('complaint_v2.chief_complaint')]['sub_options'] ?? []
                            )
                            ->placeholder('اختر النوع')
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn(Get $get) => !empty(
                        static::getComplaintsData()[$get('complaint_v2.chief_complaint')]['sub_options'] ?? []
                    )),

                // ==================== المربع الثالث: الأعراض المرافقة ====================
                Section::make('الأعراض المرافقة')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('complaint_v2.associated_symptoms')
                            ->label('الأعراض المرافقة')
                            ->rows(4)
                            ->placeholder('اكتب الأعراض المرافقة بشكل حر...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
