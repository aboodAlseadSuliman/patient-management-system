<?php

namespace App\Filament\Resources\EndoscopyProcedures\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EndoscopyProceduresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sequential_number')
                    ->label('الرقم المتسلسل')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('patient.full_name')
                    ->label('المريض')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('procedure_date')
                    ->label('التاريخ')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('day_of_week')
                    ->label('اليوم')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('hospital.name_ar')
                    ->label('المشفى')
                    ->sortable(),

                TextColumn::make('admission_type')
                    ->label('نوع الإدخال')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'internal' => 'داخلي',
                        'external' => 'خارجي',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'internal' => 'success',
                        'external' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('source')
                    ->label('المصدر')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hospital' => 'مشفى',
                        'consultation' => 'استشارة',
                        'private' => 'خاص',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'hospital' => 'info',
                        'consultation' => 'warning',
                        'private' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('procedure_type')
                    ->label('نوع الإجراء')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'upper' => 'علوي',
                        'lower' => 'سفلي',
                        'biopsy' => 'خزعة',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'upper' => 'primary',
                        'lower' => 'warning',
                        'biopsy' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('doctor.name')
                    ->label('الطبيب')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('indication.name_ar')
                    ->label('الاستطباب')
                    ->sortable()
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('follow_up_status')
                    ->label('حالة المتابعة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'completed' => 'مكتمل',
                        'ongoing' => 'مستمر',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'completed' => 'success',
                        'ongoing' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('تاريخ التعديل')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('السجلات المحذوفة'),

                SelectFilter::make('hospital_id')
                    ->label('المشفى')
                    ->relationship('hospital', 'name_ar')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('admission_type')
                    ->label('نوع الإدخال')
                    ->options([
                        'internal' => 'داخلي',
                        'external' => 'خارجي',
                    ]),

                SelectFilter::make('source')
                    ->label('المصدر')
                    ->options([
                        'hospital' => 'مشفى',
                        'consultation' => 'استشارة',
                        'private' => 'خاص',
                    ]),

                SelectFilter::make('procedure_type')
                    ->label('نوع الإجراء')
                    ->options([
                        'upper' => 'علوي',
                        'lower' => 'سفلي',
                        'biopsy' => 'خزعة',
                    ]),

                SelectFilter::make('follow_up_status')
                    ->label('حالة المتابعة')
                    ->options([
                        'completed' => 'مكتمل',
                        'ongoing' => 'مستمر',
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
                        ->label('حذف المحدد'),
                    ForceDeleteBulkAction::make()
                        ->label('حذف نهائي'),
                    RestoreBulkAction::make()
                        ->label('استعادة'),
                ]),
            ])
            ->defaultSort('procedure_date', 'desc');
    }
}
