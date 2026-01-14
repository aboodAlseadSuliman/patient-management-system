<?php

namespace App\Filament\Resources\Visits\Schemas;

use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\ComplaintSymptomInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\TimelineInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\MedicalAttachmentInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\ClinicalExaminationInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\TreatmentPlanInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs\FollowupInfoTab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class VisitInfolistTabs
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('visit_view_tabs')
                    ->tabs([
                        // ==================== التاب الأول: معلومات الزيارة ====================
                        Tab::make('معلومات الزيارة')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        // معلومات المريض
                                        Section::make('بيانات المريض')
                                            ->icon('heroicon-o-user')
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

                                                TextEntry::make('patient.gender')
                                                    ->label('الجنس')
                                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                                        'male' => 'ذكر',
                                                        'female' => 'أنثى',
                                                        default => $state ?? '-',
                                                    })
                                                    ->badge(),
                                            ])
                                            ->columnSpan(1),

                                        // معلومات الزيارة
                                        Section::make('بيانات الزيارة')
                                            ->icon('heroicon-o-calendar')
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

                                                IconEntry::make('is_completed')
                                                    ->label('الزيارة مكتملة')
                                                    ->boolean()
                                                    ->trueIcon('heroicon-o-check-circle')
                                                    ->falseIcon('heroicon-o-x-circle')
                                                    ->trueColor('success')
                                                    ->falseColor('danger'),
                                            ])
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        // ==================== التابات التفصيلية ====================
                        ComplaintSymptomInfoTab::make(),
                        TimelineInfoTab::make(),
                        MedicalAttachmentInfoTab::make(),
                        ClinicalExaminationInfoTab::make(),
                        TreatmentPlanInfoTab::make(),
                        FollowupInfoTab::make(),

                        // ==================== التاب الثامن: معلومات النظام ====================
                        Tab::make('معلومات النظام')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Section::make('بيانات النظام')
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        Grid::make(2)
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
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString('view_tab')
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }
}
