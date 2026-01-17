<?php

namespace App\Filament\Resources\AttachmentTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AttachmentTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_order')
                    ->label('الترتيب')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('full_name')
                    ->label('الاسم الكامل')
                    ->searchable(['name_ar', 'name_en'])
                    ->sortable(query: function ($query, string $direction) {
                        return $query->orderBy('name_ar', $direction);
                    }),

                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => match($state) {
                        'imaging' => 'أشعة وتصوير',
                        'endoscopy' => 'تنظير',
                        'pathology' => 'تشريح مرضي',
                        'other' => 'أخرى',
                        default => $state,
                    })
                    ->color(fn(string $state) => match($state) {
                        'imaging' => 'info',
                        'endoscopy' => 'warning',
                        'pathology' => 'danger',
                        'other' => 'gray',
                        default => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('attachmentFiles_count')
                    ->label('عدد الاستخدامات')
                    ->counts('attachmentFiles')
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options([
                        'imaging' => 'أشعة وتصوير',
                        'endoscopy' => 'تنظير',
                        'pathology' => 'تشريح مرضي',
                        'other' => 'أخرى',
                    ])
                    ->native(false),

                SelectFilter::make('is_active')
                    ->label('الحالة')
                    ->options([
                        1 => 'فعال',
                        0 => 'غير فعال',
                    ])
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('display_order', 'asc');
    }
}
