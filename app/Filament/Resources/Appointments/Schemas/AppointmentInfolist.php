<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Appointment;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AppointmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الموعد')
                    ->schema([
                        TextEntry::make('patient.full_name')
                            ->label('المريض')
                            ->icon('heroicon-m-user')
                            ->size('lg')
                            ->weight('bold')
                            ->color('primary')
                            ->columnSpan(2),

                        TextEntry::make('appointment_type.name_ar')
                            ->label('نوع الموعد')
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-m-clipboard-document-list')
                            ->columnSpan(2),

                        TextEntry::make('appointment_date')
                            ->label('تاريخ الموعد')
                            ->date('l, d F Y')
                            ->icon('heroicon-m-calendar-days')
                            ->weight('semibold')
                            ->color('primary')
                            ->columnSpan(2),

                        TextEntry::make('appointment_time')
                            ->label('وقت الموعد')
                            ->time('h:i A')
                            ->icon('heroicon-m-clock')
                            ->weight('semibold')
                            ->columnSpan(2),

                        TextEntry::make('duration')
                            ->label('المدة (دقيقة)')
                            ->formatStateUsing(fn(?int $state): string => $state ? "{$state} دقيقة" : '-')
                            ->icon('heroicon-m-arrow-path')
                            ->columnSpan(2),

                        TextEntry::make('status')
                            ->label('الحالة')
                            ->badge()
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'scheduled' => '📅 مجدول',
                                'confirmed' => '✅ مؤكد',
                                'in_progress' => '⏳ قيد التنفيذ',
                                'completed' => '✔️ مكتمل',
                                'cancelled' => '❌ ملغي',
                                'no_show' => '👤 لم يحضر',
                                'rescheduled' => '🔄 معاد جدولة',
                                default => $state ?? '-',
                            })
                            ->color(fn(?string $state): string => match ($state) {
                                'scheduled' => 'warning',
                                'confirmed' => 'info',
                                'in_progress' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                'no_show' => 'gray',
                                'rescheduled' => 'warning',
                                default => 'gray',
                            })
                            ->columnSpan(2),

                        TextEntry::make('priority')
                            ->label('الأولوية')
                            ->badge()
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'normal' => '🟢 عادي',
                                'urgent' => '🟡 عاجل',
                                'emergency' => '🔴 طارئ',
                                'low' => '⚪ منخفض',
                                default => $state ?? '-',
                            })
                            ->color(fn(?string $state): string => match ($state) {
                                'emergency' => 'danger',
                                'urgent' => 'warning',
                                'normal' => 'success',
                                'low' => 'gray',
                                default => 'gray',
                            })
                            ->columnSpan(2),

                        TextEntry::make('location')
                            ->label('الموقع (غرفة/عيادة)')
                            ->icon('heroicon-m-map-pin')
                            ->placeholder('غير محدد')
                            ->columnSpan(4),

                        TextEntry::make('reason')
                            ->label('سبب الزيارة')
                            ->icon('heroicon-m-chat-bubble-left-right')
                            ->placeholder('لم يتم تحديد السبب')
                            ->html()
                            ->columnSpanFull(),

                        TextEntry::make('notes')
                            ->label('ملاحظات')
                            ->icon('heroicon-m-pencil-square')
                            ->placeholder('لا توجد ملاحظات')
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->icon('heroicon-m-calendar'),

                Section::make('المالية')
                    ->schema([
                        TextEntry::make('fee')
                            ->label('السعر')
                            ->money('SAR')
                            ->icon('heroicon-m-currency-dollar')
                            ->placeholder('غير محدد')
                            ->size('lg')
                            ->weight('bold')
                            ->color('success'),

                        TextEntry::make('payment_status')
                            ->label('حالة الدفع')
                            ->badge()
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'paid' => '✅ مدفوع',
                                'pending' => '⏳ معلق',
                                'partial' => '💰 جزئي',
                                'cancelled' => '❌ ملغي',
                                'refunded' => '↩️ مسترد',
                                default => $state ?? '-',
                            })
                            ->color(fn(?string $state): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'partial' => 'info',
                                'cancelled' => 'danger',
                                'refunded' => 'gray',
                                default => 'gray',
                            })
                            ->icon('heroicon-m-credit-card'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-m-banknotes'),

                Section::make('ملاحظات الطبيب')
                    ->schema([
                        TextEntry::make('doctor_notes')
                            ->label('ملاحظات الطبيب')
                            ->icon('heroicon-m-clipboard-document-check')
                            ->placeholder('لا توجد ملاحظات من الطبيب')
                            ->html()
                            ->color('success')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-m-clipboard-document-check'),

                Section::make('معلومات إضافية')
                    ->schema([
                        TextEntry::make('visit.visit_number')
                            ->label('رقم الزيارة المرتبطة')
                            ->icon('heroicon-m-hashtag')
                            ->badge()
                            ->color('primary')
                            ->placeholder('لا توجد زيارة مرتبطة')
                            ->visible(fn($record) => $record->visit_id !== null),

                        TextEntry::make('visit.visit_date')
                            ->label('تاريخ الزيارة')
                            ->icon('heroicon-m-calendar')
                            ->date('Y-m-d')
                            ->placeholder('-')
                            ->visible(fn($record) => $record->visit_id !== null),

                        IconEntry::make('reminder_sent')
                            ->label('تم إرسال التذكير')
                            ->boolean()
                            ->trueIcon('heroicon-m-check-circle')
                            ->falseIcon('heroicon-m-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('reminder_sent_at')
                            ->label('وقت إرسال التذكير')
                            ->icon('heroicon-m-clock')
                            ->dateTime('d F Y - h:i A')
                            ->placeholder('لم يتم الإرسال')
                            ->visible(fn($record) => $record->reminder_sent),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-m-information-circle'),

                Section::make('معلومات النظام')
                    ->schema([
                        TextEntry::make('createdBy.name')
                            ->label('أنشئ بواسطة')
                            ->icon('heroicon-m-user-plus')
                            ->placeholder('النظام'),

                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->icon('heroicon-m-calendar')
                            ->dateTime('d F Y - h:i A'),

                        TextEntry::make('updatedBy.name')
                            ->label('تم التحديث بواسطة')
                            ->icon('heroicon-m-user')
                            ->placeholder('لم يتم التحديث'),

                        TextEntry::make('updated_at')
                            ->label('تاريخ التحديث')
                            ->icon('heroicon-m-calendar')
                            ->dateTime('d F Y - h:i A'),

                        TextEntry::make('deleted_at')
                            ->label('تاريخ الحذف')
                            ->icon('heroicon-m-trash')
                            ->dateTime('d F Y - h:i A')
                            ->color('danger')
                            ->visible(fn(Appointment $record): bool => $record->trashed()),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->icon('heroicon-m-cog-6-tooth'),
            ]);
    }
}
