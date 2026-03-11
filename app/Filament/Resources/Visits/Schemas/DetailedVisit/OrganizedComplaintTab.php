<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

class OrganizedComplaintTab
{
    public static function make(): Tab
    {
        return Tab::make('الشكاية المنظمة ')
            ->icon('heroicon-o-clipboard-document-list')
            ->badge(fn($get) => $get('organized_complaint.organ') ? '✓' : null)
            ->badgeColor('success')
            ->schema([
                Section::make('العضو المصاب')
                    ->icon('heroicon-o-map-pin')
                    ->description('اختر العضو أولاً ثم حدد الشكاوى المرتبطة به')
                    ->schema([
                        Select::make('organized_complaint.organ')
                            ->label('العضو الرئيسي')
                            ->options([
                                'esophagus' => '🔴 المريء',
                                'stomach' => '🟠 المعدة',
                                'intestines' => '🟡 الأمعاء والكولون',
                                'rectum' => '🟢 المستقيم والشرج',
                                'liver' => '🔵 الكبد والطرق الصفراوية',
                                'pancreas' => '🟣 البنكرياس',
                                'other' => '⚪ أعضاء أخرى',
                            ])
                            ->native(false)
                            ->live()
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // ==================== المريء ====================
                Section::make('شكاوى المريء')
                    ->icon('heroicon-o-arrow-down-circle')
                    ->schema([
                        Checkbox::make('organized_complaint.esophagus.dysphagia')
                            ->label('عسر بلع (Dysphagia)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.esophagus.odynophagia')
                            ->label('ألم بلع (Odynophagia)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.esophagus.heartburn')
                            ->label('حرقة فؤاد (Heartburn)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.esophagus.regurgitation')
                            ->label('قلس (Regurgitation)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.esophagus.chest_pain')
                            ->label('ألم صدري')
                            ->inline(false),

                        Textarea::make('organized_complaint.esophagus.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'esophagus')
                    ->collapsible(),

                // ==================== المعدة ====================
                Section::make('شكاوى المعدة')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Checkbox::make('organized_complaint.stomach.nausea')
                            ->label('غثيان (Nausea)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.stomach.vomiting')
                            ->label('إقياء (Vomiting)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.stomach.epigastric_pain')
                            ->label('ألم شرسوفي')
                            ->inline(false),

                        Checkbox::make('organized_complaint.stomach.bloating')
                            ->label('نفخة')
                            ->inline(false),

                        Checkbox::make('organized_complaint.stomach.early_satiety')
                            ->label('شبع مبكر')
                            ->inline(false),

                        Checkbox::make('organized_complaint.stomach.hematemesis')
                            ->label('إقياء دموي (Hematemesis)')
                            ->inline(false),

                        Textarea::make('organized_complaint.stomach.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'stomach')
                    ->collapsible(),

                // ==================== الأمعاء والكولون ====================
                Section::make('شكاوى الأمعاء والكولون')
                    ->icon('heroicon-o-arrows-right-left')
                    ->schema([
                        Checkbox::make('organized_complaint.intestines.abdominal_pain')
                            ->label('ألم بطني')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.diarrhea')
                            ->label('إسهال (Diarrhea)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.constipation')
                            ->label('إمساك (Constipation)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.alternating')
                            ->label('تناوب إسهال وإمساك')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.bloating')
                            ->label('نفخة وغازات')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.mucus')
                            ->label('مخاط في البراز')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.blood')
                            ->label('دم في البراز')
                            ->inline(false),

                        Checkbox::make('organized_complaint.intestines.weight_loss')
                            ->label('نقص وزن')
                            ->inline(false),

                        Textarea::make('organized_complaint.intestines.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'intestines')
                    ->collapsible(),

                // ==================== المستقيم والشرج ====================
                Section::make('شكاوى المستقيم والشرج')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->schema([
                        Checkbox::make('organized_complaint.rectum.rectal_bleeding')
                            ->label('نزف شرجي')
                            ->inline(false),

                        Checkbox::make('organized_complaint.rectum.hemorrhoids')
                            ->label('بواسير')
                            ->inline(false),

                        Checkbox::make('organized_complaint.rectum.anal_pain')
                            ->label('ألم شرجي')
                            ->inline(false),

                        Checkbox::make('organized_complaint.rectum.pruritus')
                            ->label('حكة شرجية')
                            ->inline(false),

                        Checkbox::make('organized_complaint.rectum.tenesmus')
                            ->label('زحير (Tenesmus)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.rectum.incontinence')
                            ->label('سلس برازي')
                            ->inline(false),

                        Textarea::make('organized_complaint.rectum.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'rectum')
                    ->collapsible(),

                // ==================== الكبد والطرق الصفراوية ====================
                Section::make('شكاوى الكبد والطرق الصفراوية')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        Checkbox::make('organized_complaint.liver.jaundice')
                            ->label('يرقان (Jaundice)')
                            ->inline(false),

                        Checkbox::make('organized_complaint.liver.right_upper_pain')
                            ->label('ألم ربع علوي أيمن')
                            ->inline(false),

                        Checkbox::make('organized_complaint.liver.dark_urine')
                            ->label('بول غامق')
                            ->inline(false),

                        Checkbox::make('organized_complaint.liver.pale_stool')
                            ->label('براز فاتح')
                            ->inline(false),

                        Checkbox::make('organized_complaint.liver.itching')
                            ->label('حكة جلدية')
                            ->inline(false),

                        Checkbox::make('organized_complaint.liver.ascites')
                            ->label('حبن (Ascites)')
                            ->inline(false),

                        Textarea::make('organized_complaint.liver.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'liver')
                    ->collapsible(),

                // ==================== البنكرياس ====================
                Section::make('شكاوى البنكرياس')
                    ->icon('heroicon-o-fire')
                    ->schema([
                        Checkbox::make('organized_complaint.pancreas.epigastric_pain')
                            ->label('ألم شرسوفي شديد')
                            ->inline(false),

                        Checkbox::make('organized_complaint.pancreas.radiating_back')
                            ->label('ألم منتشر للظهر')
                            ->inline(false),

                        Checkbox::make('organized_complaint.pancreas.nausea_vomiting')
                            ->label('غثيان وإقياء')
                            ->inline(false),

                        Checkbox::make('organized_complaint.pancreas.steatorrhea')
                            ->label('إسهال دهني')
                            ->inline(false),

                        Checkbox::make('organized_complaint.pancreas.weight_loss')
                            ->label('نقص وزن')
                            ->inline(false),

                        Textarea::make('organized_complaint.pancreas.notes')
                            ->label('ملاحظات إضافية')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'pancreas')
                    ->collapsible(),

                // ==================== أعضاء أخرى ====================
                Section::make('شكاوى أخرى')
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->schema([
                        Textarea::make('organized_complaint.other.complaints')
                            ->label('اذكر الشكاوى')
                            ->rows(4)
                            ->placeholder('اكتب الشكاوى المتعلقة بأعضاء أخرى...')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn(Get $get) => $get('organized_complaint.organ') === 'other')
                    ->collapsible(),
            ]);
    }
}
