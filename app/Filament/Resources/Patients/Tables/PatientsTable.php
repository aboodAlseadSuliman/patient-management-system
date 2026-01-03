<?php

namespace App\Filament\Resources\Patients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('file_number')
                    ->label('رقم الملف')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('full_name')
                    ->label('الاسم الكامل')
                    ->searchable(['first_name', 'father_name', 'last_name', 'full_name'])
                    ->sortable()
                    ->description(fn ($record) => $record->national_id ? "هوية: {$record->national_id}" : null),

                TextColumn::make('gender')
                    ->label('الجنس')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('birth_year')
                    ->label('سنة الميلاد')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                TextColumn::make('country')
                    ->label('البلد')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('province')
                    ->label('المحافظة')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('neighborhood')
                    ->label('الحي/القرية')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('occupation')
                    ->label('المهنة')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('referringDoctor.full_name')
                    ->label('الطبيب المحول')
                    ->searchable(['first_name', 'last_name'])
                    ->toggleable()
                    ->placeholder('—')
                    ->description(fn ($record) => $record->referringDoctor?->specialty),

                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label('أنشأه')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updater.name')
                    ->label('عدّله')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('gender')
                    ->label('الجنس')
                    ->options([
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                    ]),

                SelectFilter::make('is_active')
                    ->label('الحالة')
                    ->options([
                        1 => 'نشط',
                        0 => 'غير نشط',
                    ]),

                SelectFilter::make('referring_doctor_id')
                    ->label('الطبيب المحول')
                    ->relationship('referringDoctor', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable()
                    ->preload(),

                SelectFilter::make('province')
                    ->label('المحافظة')
                    ->options(fn () => \App\Models\Patient::whereNotNull('province')
                        ->distinct()
                        ->pluck('province', 'province')
                        ->toArray()
                    )
                    ->searchable(),
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
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->persistFiltersInSession();
    }
}
