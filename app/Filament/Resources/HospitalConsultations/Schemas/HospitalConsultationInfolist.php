<?php

namespace App\Filament\Resources\HospitalConsultations\Schemas;

use App\Models\HospitalConsultation;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HospitalConsultationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات المعاينة الأساسية')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextEntry::make('patient.full_name')
                            ->label('المريض')
                            ->weight('bold')
                            ->icon('heroicon-o-user')
                            ->color('primary'),

                        TextEntry::make('sequential_number')
                            ->label('الرقم التسلسلي')
                            ->badge()
                            ->color('success'),

                        TextEntry::make('consultation_date')
                            ->label('تاريخ المعاينة')
                            ->date('Y-m-d')
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('day_of_week')
                            ->label('يوم الأسبوع')
                            ->badge(),

                        TextEntry::make('hospital.name_ar')
                            ->label('المشفى')
                            ->icon('heroicon-o-building-office-2')
                            ->placeholder('-'),

                        TextEntry::make('source')
                            ->label('المصدر')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'hospital' => 'مشفى',
                                'consultation' => 'استشارة',
                                'private' => 'خاص',
                                default => $state,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'hospital' => 'success',
                                'consultation' => 'info',
                                'private' => 'warning',
                                default => 'gray',
                            }),

                        TextEntry::make('doctor.name')
                            ->label('الطبيب')
                            ->icon('heroicon-o-user-circle')
                            ->placeholder('-'),

                        TextEntry::make('preliminaryDiagnosis.name_ar')
                            ->label('التشخيص الأولي')
                            ->badge()
                            ->color('info')
                            ->placeholder('-'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('التفاصيل الطبية')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('accompanying_diseases')
                            ->label('الأمراض المرافقة')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown(),

                        TextEntry::make('procedures')
                            ->label('الإجراءات المتخذة')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown(),

                        TextEntry::make('final_diagnosis')
                            ->label('التشخيص النهائي')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown()
                            ->weight('bold'),
                    ])
                    ->collapsible(),

                Section::make('المتابعة والملاحظات')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        TextEntry::make('follow_up_status')
                            ->label('حالة المتابعة')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'cured' => 'شفاء',
                                'ongoing' => 'مستمر',
                                'deceased' => 'وفاة',
                                default => '-',
                            })
                            ->color(fn (?string $state): string => match ($state) {
                                'cured' => 'success',
                                'ongoing' => 'warning',
                                'deceased' => 'danger',
                                default => 'gray',
                            })
                            ->placeholder('-'),

                        TextEntry::make('notes')
                            ->label('ملاحظات إضافية')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown(),
                    ])
                    ->collapsible(),

                Section::make('معلومات النظام')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('أنشئ بواسطة')
                            ->placeholder('-')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('updater.name')
                            ->label('آخر تحديث بواسطة')
                            ->placeholder('-')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->dateTime('Y-m-d H:i')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('تاريخ آخر تحديث')
                            ->dateTime('Y-m-d H:i')
                            ->placeholder('-'),

                        TextEntry::make('deleted_at')
                            ->label('تاريخ الحذف')
                            ->dateTime('Y-m-d H:i')
                            ->visible(fn (HospitalConsultation $record): bool => $record->trashed())
                            ->badge()
                            ->color('danger'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
