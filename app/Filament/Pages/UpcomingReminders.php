<?php

namespace App\Filament\Pages;

use App\Models\UpcomingReminder;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UpcomingReminders extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.upcoming-reminders';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-bell-alert';
    }

    public static function getNavigationLabel(): string
    {
        return 'التذكيرات القادمة';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public function getHeading(): string
    {
        return 'التذكيرات القادمة';
    }

    public function getSubheading(): ?string
    {
        return 'عرض المواعيد القادمة للمتابعة ونتائج التشريح المرضي';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getRemindersQuery())
            ->columns([
                TextColumn::make('patient.full_name')
                    ->label('المريض')
                    ->searchable(['first_name', 'last_name'])
                    ->weight('bold')
                    ->url(fn($record) => route('filament.admin.resources.visits.view', $record->visit_id))
                    ->color('primary'),

                TextColumn::make('reminder_type')
                    ->label('نوع التذكير')
                    ->badge()
                    ->color(fn(string $state): string => match($state) {
                        'followup' => 'info',
                        'pathology' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match($state) {
                        'followup' => 'متابعة',
                        'pathology' => 'نتيجة تشريح مرضي',
                        default => $state,
                    }),

                TextColumn::make('reminder_date')
                    ->label('التاريخ')
                    ->date('Y-m-d')
                    ->sortable()
                    ->badge()
                    ->color(function($record): string {
                        $date = $record->reminder_date;
                        if (!$date) {
                            return 'gray';
                        }

                        $parsedDate = Carbon::parse($date);
                        if ($parsedDate->isPast()) {
                            return 'danger';
                        }

                        return $parsedDate->diffInDays(now()) <= 3 ? 'warning' : 'success';
                    }),

                TextColumn::make('days_remaining')
                    ->label('المتبقي')
                    ->state(function($record): ?string {
                        $date = $record->reminder_date;
                        if (!$date) {
                            return null;
                        }

                        $days = Carbon::parse($date)->diffInDays(now(), false);
                        if ($days < 0) {
                            return 'متأخر ' . abs($days) . ' يوم';
                        } elseif ($days == 0) {
                            return 'اليوم';
                        } else {
                            return 'بعد ' . $days . ' يوم';
                        }
                    })
                    ->badge()
                    ->color(function($record): string {
                        $date = $record->reminder_date;
                        if (!$date) {
                            return 'gray';
                        }
                        return Carbon::parse($date)->isPast() ? 'danger' : 'info';
                    }),

                TextColumn::make('description')
                    ->label('التفاصيل')
                    ->wrap()
                    ->limit(100),
            ])
            ->defaultSort('reminder_date', 'asc')
            ->paginated([10, 25, 50, 100]);
    }

    protected function getRemindersQuery(): Builder
    {
        $upcomingDays = 30;

        return UpcomingReminder::query()
            ->with(['patient', 'visit'])
            ->upcoming($upcomingDays)
            ->orderBy('reminder_date', 'asc');
    }
}
