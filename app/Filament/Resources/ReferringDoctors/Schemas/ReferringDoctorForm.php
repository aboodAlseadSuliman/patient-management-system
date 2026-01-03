<?php

namespace App\Filament\Resources\ReferringDoctors\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ReferringDoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('البيانات الشخصية')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('الاسم الأول')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('last_name')
                            ->label('الكنية / اسم العائلة')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('specialty')
                            ->label('التخصص')
                            ->maxLength(255)
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('معلومات التواصل')
                    ->schema([
                        TextInput::make('clinic_address')
                            ->label('عنوان العيادة')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('clinic_phone')
                            ->label('رقم العيادة')
                            ->tel()
                            ->maxLength(20)
                            ->columnSpan(1),

                        TextInput::make('mobile_phone')
                            ->label('رقم الجوال')
                            ->tel()
                            ->maxLength(20)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('معلومات إضافية')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->inline(false),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
