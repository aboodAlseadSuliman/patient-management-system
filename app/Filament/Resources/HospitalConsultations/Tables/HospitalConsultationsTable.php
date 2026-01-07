<?php

namespace App\Filament\Resources\HospitalConsultations\Tables;

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

class HospitalConsultationsTable
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

                TextColumn::make('consultation_date')
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

                TextColumn::make('preliminaryDiagnosis.name_ar')
                    ->label('التشخيص الأولي')
                    ->sortable()
                    ->limit(30),

                TextColumn::make('doctor.name')
                    ->label('الطبيب')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('follow_up_status')
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

                SelectFilter::make('source')
                    ->label('المصدر')
                    ->options([
                        'hospital' => 'مشفى',
                        'consultation' => 'استشارة',
                        'private' => 'خاص',
                    ]),

                SelectFilter::make('follow_up_status')
                    ->label('حالة المتابعة')
                    ->options([
                        'cured' => 'شفاء',
                        'ongoing' => 'مستمر',
                        'deceased' => 'وفاة',
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
            ->defaultSort('consultation_date', 'desc');
    }
}
