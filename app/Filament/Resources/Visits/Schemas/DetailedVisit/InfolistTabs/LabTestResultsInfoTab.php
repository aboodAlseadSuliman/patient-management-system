<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs\Tab;

class LabTestResultsInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('نتائج التحاليل')
            ->icon('heroicon-o-beaker')
            ->badge(fn($record) => $record->labTestResults->count() ?: null)
            ->badgeColor('success')
            ->schema([
                Section::make('نتائج التحاليل المخبرية')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('نتائج التحاليل مع المقارنة بالقيم السابقة')
                    ->schema([
                        RepeatableEntry::make('labTestResults')
                            ->label('')
                            ->schema([
                                Grid::make(5)->schema([
                                    TextEntry::make('labTest.name')
                                        ->label('اسم التحليل')
                                        ->weight('bold')
                                        ->size('lg')
                                        ->icon('heroicon-m-beaker')
                                        ->color('primary')
                                        ->columnSpan(2),

                                    TextEntry::make('test_date')
                                        ->label('تاريخ التحليل')
                                        ->date('d/m/Y')
                                        ->icon('heroicon-m-calendar')
                                        ->columnSpan(1),

                                    TextEntry::make('formatted_result')
                                        ->label('النتيجة')
                                        ->weight('bold')
                                        ->size('lg')
                                        ->columnSpan(1),

                                    TextEntry::make('status')
                                        ->label('الحالة')
                                        ->badge()
                                        ->color(fn($record) => $record->status_color)
                                        ->icon(fn($record) => match($record->status_color) {
                                            'success' => 'heroicon-m-check-circle',
                                            'danger' => 'heroicon-m-exclamation-circle',
                                            default => 'heroicon-m-question-mark-circle',
                                        })
                                        ->columnSpan(1),
                                ]),

                                Grid::make(4)->schema([
                                    TextEntry::make('reference_range')
                                        ->label('المجال الطبيعي')
                                        ->icon('heroicon-m-chart-bar')
                                        ->placeholder('-')
                                        ->columnSpan(1),

                                    TextEntry::make('previous_value')
                                        ->label('القيمة السابقة')
                                        ->placeholder('-')
                                        ->icon('heroicon-m-arrow-trending-up')
                                        ->color('gray')
                                        ->formatStateUsing(function ($record) {
                                            if (!$record->previous_value) {
                                                return '-';
                                            }
                                            $value = $record->previous_value . ($record->unit ? ' ' . $record->unit : '');
                                            if ($record->previous_test_date) {
                                                $value .= ' (' . $record->previous_test_date->format('d/m/Y') . ')';
                                            }
                                            return $value;
                                        })
                                        ->columnSpan(2),

                                    TextEntry::make('value_difference')
                                        ->label('التغيير')
                                        ->placeholder('-')
                                        ->badge()
                                        ->color(function ($record) {
                                            if (!$record->value_difference) return 'gray';
                                            if (str_contains($record->value_difference, '↑')) return 'warning';
                                            if (str_contains($record->value_difference, '↓')) return 'info';
                                            return 'gray';
                                        })
                                        ->columnSpan(1),

                                    TextEntry::make('notes')
                                        ->label('ملاحظات')
                                        ->placeholder('لا توجد ملاحظات')
                                        ->icon('heroicon-m-chat-bubble-left-ellipsis')
                                        ->color('gray')
                                        ->columnSpanFull(),
                                ]),
                            ])
                            ->contained(true)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->visible(fn($record) => $record->labTestResults->count() > 0),

                Section::make()
                    ->schema([
                        TextEntry::make('no_results')
                            ->label('')
                            ->default('لا توجد نتائج تحاليل مسجلة')
                            ->color('gray')
                            ->icon('heroicon-o-information-circle'),
                    ])
                    ->visible(fn($record) => $record->labTestResults->count() === 0),
            ]);
    }
}
