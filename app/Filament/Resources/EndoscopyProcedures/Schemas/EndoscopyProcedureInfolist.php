<?php

namespace App\Filament\Resources\EndoscopyProcedures\Schemas;

use App\Models\EndoscopyProcedure;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EndoscopyProcedureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الإجراء الأساسية')
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

                        TextEntry::make('procedure_date')
                            ->label('تاريخ الإجراء')
                            ->date('Y-m-d')
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('day_of_week')
                            ->label('يوم الأسبوع')
                            ->badge(),

                        TextEntry::make('hospital.name_ar')
                            ->label('المشفى')
                            ->icon('heroicon-o-building-office-2')
                            ->placeholder('-'),

                        TextEntry::make('admission_type')
                            ->label('نوع الإدخال')
                            ->badge()
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'internal' => 'داخلي',
                                'external' => 'خارجي',
                                default => $state,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'internal' => 'success',
                                'external' => 'info',
                                default => 'gray',
                            }),

                        TextEntry::make('source')
                            ->label('المصدر')
                            ->badge()
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'hospital' => 'مشفى',
                                'consultation' => 'استشارة',
                                'private' => 'خاص',
                                default => $state,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'hospital' => 'success',
                                'consultation' => 'info',
                                'private' => 'warning',
                                default => 'gray',
                            }),

                        TextEntry::make('procedure_type')
                            ->label('نوع الإجراء')
                            ->badge()
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'upper' => 'علوي',
                                'lower' => 'سفلي',
                                'biopsy' => 'خزعة',
                                default => $state,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'upper' => 'info',
                                'lower' => 'warning',
                                'biopsy' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('doctor.name')
                            ->label('الطبيب')
                            ->icon('heroicon-o-user-circle')
                            ->placeholder('-'),

                        TextEntry::make('indication.name_ar')
                            ->label('الاستطباب')
                            ->badge()
                            ->color('info')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('ملاحظات الاستطباب')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('indication_notes')
                            ->label('ملاحظات الاستطباب')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('التداخلات المنفذة')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        TextEntry::make('interventions.name_ar')
                            ->label('التداخلات')
                            ->badge()
                            ->color('warning')
                            ->separator(', ')
                            ->placeholder('لا يوجد تداخلات')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(fn(EndoscopyProcedure $record): bool => $record->interventions()->exists()),

                Section::make('نتائج الإجراء')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        TextEntry::make('result_text')
                            ->label('نص النتيجة')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown()
                            ->weight('bold'),

                        TextEntry::make('biopsyLocations.name_ar')
                            ->label('مواقع الخزعة')
                            ->badge()
                            ->color('info')
                            ->separator(', ')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull(),

                        TextEntry::make('biopsy_results')
                            ->label('نتائج الخزعة')
                            ->placeholder('لا يوجد')
                            ->columnSpanFull()
                            ->markdown(),
                    ])
                    ->collapsible(),

                Section::make('المتابعة والملاحظات')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        TextEntry::make('follow_up_status')
                            ->label('حالة المتابعة')
                            ->badge()
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'completed' => 'مكتمل',
                                'ongoing' => 'مستمر',
                                default => '-',
                            })
                            ->color(fn(?string $state): string => match ($state) {
                                'completed' => 'success',
                                'ongoing' => 'warning',
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
                            ->visible(fn(EndoscopyProcedure $record): bool => $record->trashed())
                            ->badge()
                            ->color('danger'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
