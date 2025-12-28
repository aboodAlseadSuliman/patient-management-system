<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')
                    ->label('المريض')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointmentType.name_ar')
                    ->label('النوع')
                    ->badge()
                    ->color(fn($record) => $record->appointmentType->color ?? 'gray')
                    ->icon(fn($record) => $record->appointmentType->icon)
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('appointment_time')
                    ->label('الوقت')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'scheduled' => 'مجدول',
                        'confirmed' => 'مؤكد',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        'no_show' => 'لم يحضر',
                        'rescheduled' => 'معاد جدولة',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'no_show' => 'warning',
                        'rescheduled' => 'primary',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('priority')
                    ->label('الأولوية')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'normal' => 'عادي',
                        'urgent' => 'عاجل',
                        'emergency' => 'طارئ',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'normal' => 'success',
                        'urgent' => 'warning',
                        'emergency' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('fee')
                    ->label('السعر')
                    ->money('SAR')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('appointment_type_id')
                    ->label('نوع الموعد')
                    ->relationship('appointmentType', 'name_ar'),

                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'scheduled' => 'مجدول',
                        'confirmed' => 'مؤكد',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        'no_show' => 'لم يحضر',
                    ]),

                Filter::make('today')
                    ->label('اليوم')
                    ->query(fn(Builder $query) => $query->today()),

                Filter::make('upcoming')
                    ->label('القادمة')
                    ->query(fn(Builder $query) => $query->upcoming()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
