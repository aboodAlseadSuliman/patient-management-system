<?php

namespace App\Filament\Resources\Visits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient_id')
                    ->label('رقم المريض')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('visit_number')
                    ->label('رقم الزيارة')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('visit_date')
                    ->label('تاريخ الزيارة')
                    ->date()
                    ->sortable(),
                TextColumn::make('visit_type')
                    ->label('نوع الزيارة')
                    ->badge(),
                TextColumn::make('next_visit_date')
                    ->label('تاريخ الزيارة القادمة')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_completed')
                    ->label('مكتملة')
                    ->boolean(),
                TextColumn::make('created_by')
                    ->label('أنشئت بواسطة')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->label('تم التحديث بواسطة')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('المحذوفة (سلة المهملات)'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('عرض'),
                EditAction::make()
                    ->label('تعديل'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف'),
                    ForceDeleteBulkAction::make()
                        ->label('حذف نهائي'),
                    RestoreBulkAction::make()
                        ->label('استعادة'),
                ]),
            ]);
    }
}
