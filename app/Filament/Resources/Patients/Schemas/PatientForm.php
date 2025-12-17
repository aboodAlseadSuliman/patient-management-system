<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;




class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('file_number')
                    ->label('رقم الملف')
                    ->required(),
                TextInput::make('national_id')
                    ->label('رقم الهوية الوطنية')
                    ->default(null),
                TextInput::make('full_name')
                    ->label('الاسم الكامل')
                    ->required(),
                Select::make('gender')
                    ->label('الجنس')
                    ->options([
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                    ])
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->label('تاريخ الميلاد')
                    ->required(),
                TextInput::make('phone')
                    ->label('رقم الهاتف الرئيسي')
                    ->tel()
                    ->default(null),
                TextInput::make('alternative_phone')
                    ->label('رقم هاتف بديل')
                    ->tel()
                    ->default(null),
                Textarea::make('address')
                    ->label('العنوان')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->label('المدينة')
                    ->default(null),
                TextInput::make('area')
                    ->label('المنطقة / الحي')
                    ->default(null),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required(),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->label('أنشئ بواسطة')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->label('تم التحديث بواسطة')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
