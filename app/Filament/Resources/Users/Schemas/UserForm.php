<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('email')
                    ->label('البريد')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label('تأكيد البريد'),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required(),
                Select::make('role_id')
                    ->label('الدور')
                    ->relationship('role', 'display_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                TextInput::make('phone')
                    ->label('الهاتف')
                    ->tel()
                    ->default(null),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true)
                    ->required(),
                DateTimePicker::make('last_login_at')
                    ->label('اخر تسجيل دخول'),
            ]);
    }
}
