<?php

namespace App\Filament\Resources\ReferringDoctors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class ReferringDoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('الاسم الأول')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label('الكنية')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('specialty')
                    ->label('التخصص')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('mobile_phone')
                    ->label('رقم الجوال')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('clinic_phone')
                    ->label('رقم العيادة')
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('patients_count')
                    ->label('عدد المرضى')
                    ->counts('patients')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('الحالة')
                    ->options([
                        1 => 'نشط',
                        0 => 'غير نشط',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
