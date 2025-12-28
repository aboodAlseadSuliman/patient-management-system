<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use App\Models\Appointment;
use Filament\Actions\Action;
// use Filament\Actions\EditAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
// use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class EndoscopyAppointmentsTable extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '🔬 مواعيد التنظير';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereHas('appointmentType', function (Builder $query) {
                        $query->where('slug', 'endoscopy');
                    })
                    ->whereIn('status', ['scheduled', 'confirmed'])
                    ->where('appointment_date', '>=', today())
                    ->orderBy('appointment_date')
                    ->orderBy('appointment_time')
            )
            ->columns([
                TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('appointment_time')
                    ->label('الوقت')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('patient.full_name')
                    ->label('المريض')
                    ->searchable()
                    ->url(fn($record) => route('filament.admin.resources.patients.view', $record->patient_id))
                    ->color('primary')
                    ->weight('bold'),

                TextColumn::make('patient.phone')
                    ->label('الجوال')
                    ->toggleable(),

                TextColumn::make('duration')
                    ->label('المدة')
                    ->suffix(' د')
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('الموقع')
                    ->default('-')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'scheduled' => 'مجدول',
                        'confirmed' => 'مؤكد',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'confirmed' => 'success',
                        default => 'gray',
                    }),

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
                    })
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('date_filter')
                    ->label('التاريخ')
                    ->options([
                        'today' => 'اليوم',
                        'tomorrow' => 'غداً',
                        'this_week' => 'هذا الأسبوع',
                        'next_week' => 'الأسبوع القادم',
                    ])
                    ->query(function (Builder $query, array $data) {
                        return match ($data['value'] ?? null) {
                            'today' => $query->whereDate('appointment_date', today()),
                            'tomorrow' => $query->whereDate('appointment_date', today()->addDay()),
                            'this_week' => $query->whereBetween('appointment_date', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ]),
                            'next_week' => $query->whereBetween('appointment_date', [
                                now()->addWeek()->startOfWeek(),
                                now()->addWeek()->endOfWeek()
                            ]),
                            default => $query,
                        };
                    }),

                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'scheduled' => 'مجدول',
                        'confirmed' => 'مؤكد',
                    ]),
            ])
            ->recordActions([
                // ActionGroup::make([
                ViewAction::make('view')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => route('filament.admin.resources.appointments.view', $record)),

                EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->url(fn($record) => route('filament.admin.resources.appointments.edit', $record)),

                DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('حذف الموعد')
                    ->modalDescription('هل أنت متأكد من حذف هذا الموعد؟')
                    ->modalSubmitActionLabel('نعم، احذف')
                    ->modalCancelActionLabel('إلغاء'),
                // ])
                //     ->label('العمليات')
                //     ->icon('heroicon-o-ellipsis-vertical')
                //     ->size('sm')
                //     ->color('gray')
                //     ->button(),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('موعد جديد')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(route('filament.admin.resources.appointments.create'))
                    ->button(),
            ])
            ->emptyStateHeading('لا توجد مواعيد تنظير قادمة')
            ->emptyStateDescription('جميع المواعيد مكتملة أو لا توجد مواعيد مجدولة')
            ->emptyStateIcon('heroicon-o-beaker')
            ->emptyStateActions([
                Action::make('create')
                    ->label('إضافة موعد جديد')
                    ->icon('heroicon-o-plus')
                    ->url(route('filament.admin.resources.appointments.create'))
                    ->button(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }
}
