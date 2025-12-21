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



use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;



class VisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // رقم الزيارة
                TextColumn::make('visit_number')
                    ->label('رقم الزيارة')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                // المريض - عرض الاسم بدلاً من الرقم
                TextColumn::make('patient.full_name')
                    ->label('اسم المريض')
                    ->sortable()
                    ->searchable()
                    ->description(fn($record) => 'ملف: ' . $record->patient?->file_number),

                // رقم ملف المريض
                TextColumn::make('patient.file_number')
                    ->label('رقم الملف')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // تاريخ الزيارة
                TextColumn::make('visit_date')
                    ->label('تاريخ الزيارة')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),

                // نوع الزيارة
                TextColumn::make('visit_type')
                    ->label('نوع الزيارة')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'first' => 'أولى',
                        'followup' => 'متابعة',
                        'emergency' => 'طوارئ',
                        default => $state ?? '-',
                    })
                    ->color(fn(?string $state): string => match ($state) {
                        'first' => 'success',
                        'followup' => 'info',
                        'emergency' => 'danger',
                        default => 'gray',
                    }),

                // الشكوى الرئيسية
                TextColumn::make('chief_complaint')
                    ->label('الشكوى الرئيسية')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                // التشخيص
                TextColumn::make('diagnosis')
                    ->label('التشخيص')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                // تاريخ الزيارة القادمة
                TextColumn::make('next_visit_date')
                    ->label('الزيارة القادمة')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),

                // حالة الاكتمال
                IconColumn::make('is_completed')
                    ->label('مكتملة')
                    ->boolean()
                    ->sortable(),

                // أنشأها - عرض اسم المستخدم
                TextColumn::make('creator.name')
                    ->label('أنشأها')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // آخر تحديث - عرض اسم المستخدم
                TextColumn::make('updater.name')
                    ->label('آخر تحديث')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // تاريخ الإنشاء
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // تاريخ التحديث
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // تاريخ الحذف
                TextColumn::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // فلتر المحذوفات
                TrashedFilter::make()
                    ->label('المحذوفة (سلة المهملات)'),

                // فلتر نوع الزيارة
                SelectFilter::make('visit_type')
                    ->label('نوع الزيارة')
                    ->options([
                        'first' => 'أولى',
                        'followup' => 'متابعة',
                        'emergency' => 'طوارئ',
                    ]),

                // فلتر الحالة
                SelectFilter::make('is_completed')
                    ->label('حالة الزيارة')
                    ->options([
                        '1' => 'مكتملة',
                        '0' => 'غير مكتملة',
                    ]),
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
                ])->label('إجراءات جماعية'),
            ])
            ->defaultSort('visit_date', 'desc');
    }
}
