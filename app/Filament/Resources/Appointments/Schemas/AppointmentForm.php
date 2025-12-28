<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Schema;
use App\Models\AppointmentType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DateTimePicker;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الموعد')
                    ->schema([
                        Select::make('patient_id')
                            ->label('المريض')
                            ->relationship('patient', 'full_name')
                            ->searchable(['full_name', 'file_number', 'phone'])
                            ->required()
                            ->preload()
                            ->columnSpan(2),

                        Select::make('appointment_type_id')
                            ->label('نوع الموعد')
                            ->relationship('appointmentType', 'name_ar')
                            ->options(AppointmentType::getDropdownOptions())
                            ->searchable()
                            ->required()
                            ->createOptionUsing(function (array $data): int {
                                $type = AppointmentType::create([
                                    'name_ar' => $data['name_ar'],
                                    'is_active' => true,
                                ]);
                                return $type->id;
                            })
                            ->createOptionForm([
                                TextInput::make('name_ar')
                                    ->label('اسم النوع')
                                    ->required(),
                            ])
                            ->columnSpan(2),

                        DatePicker::make('appointment_date')
                            ->label('تاريخ الموعد')
                            ->required()
                            ->default(now())
                            ->minDate(now())
                            ->columnSpan(2),

                        TimePicker::make('appointment_time')
                            ->label('وقت الموعد')
                            ->required()
                            ->seconds(false)
                            ->columnSpan(1),

                        TextInput::make('duration')
                            ->label('المدة (دقيقة)')
                            ->numeric()
                            ->default(30)
                            ->suffix('دقيقة')
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'scheduled' => '📅 مجدول',
                                'confirmed' => '✅ مؤكد',
                                'completed' => '✔️ مكتمل',
                                'cancelled' => '❌ ملغي',
                                'no_show' => '👤 لم يحضر',
                                'rescheduled' => '🔄 معاد جدولة',
                            ])
                            ->default('scheduled')
                            ->required()
                            ->columnSpan(2),

                        Select::make('priority')
                            ->label('الأولوية')
                            ->options([
                                'normal' => '🟢 عادي',
                                'urgent' => '🟡 عاجل',
                                'emergency' => '🔴 طارئ',
                            ])
                            ->default('normal')
                            ->columnSpan(2),

                        TextInput::make('location')
                            ->label('الموقع (غرفة/عيادة)')
                            ->placeholder('مثال: غرفة 101، عيادة A')
                            ->columnSpan(2),

                        Textarea::make('reason')
                            ->label('سبب الزيارة')
                            ->rows(2)
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(4),

                Section::make('المالية')
                    ->schema([
                        TextInput::make('fee')
                            ->label('السعر')
                            ->numeric()
                            ->prefix('ر.س')
                            ->columnSpan(1),

                        Select::make('payment_status')
                            ->label('حالة الدفع')
                            ->options([
                                'pending' => 'معلق',
                                'paid' => 'مدفوع',
                                'partial' => 'جزئي',
                            ])
                            ->default('pending')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                Section::make('ملاحظات الطبيب')
                    ->schema([
                        Textarea::make('doctor_notes')
                            ->label('ملاحظات الطبيب')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visibleOn('edit'),

            ]);
    }
}