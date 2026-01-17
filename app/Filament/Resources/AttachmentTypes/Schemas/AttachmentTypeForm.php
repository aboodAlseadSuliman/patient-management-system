<?php

namespace App\Filament\Resources\AttachmentTypes\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AttachmentTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات النوع')
                    ->schema([
                        TextInput::make('name_ar')
                            ->label('الاسم بالعربية')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('name_en')
                            ->label('الاسم بالإنجليزية')
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('icon')
                            ->label('الأيقونة')
                            ->required()
                            ->default('📎')
                            ->maxLength(10)
                            ->helperText('اختر رمز تعبيري (emoji) للنوع')
                            ->columnSpan(1),

                        Select::make('category')
                            ->label('التصنيف')
                            ->options([
                                'imaging' => 'أشعة وتصوير طبي',
                                'endoscopy' => 'تنظير',
                                'pathology' => 'تشريح مرضي',
                                'other' => 'أخرى',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('display_order')
                            ->label('ترتيب العرض')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('رقم أقل يعني الظهور أولاً في القائمة')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('فعال')
                            ->required()
                            ->default(true)
                            ->helperText('الأنواع الغير فعالة لن تظهر في قائمة الاختيار')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
