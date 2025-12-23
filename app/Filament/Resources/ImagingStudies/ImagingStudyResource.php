<?php

namespace App\Filament\Resources\ImagingStudies;

use App\Filament\Resources\ImagingStudies\Pages\ManageImagingStudies;
use App\Models\ImagingStudy;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImagingStudyResource extends Resource
{
    protected static ?string $model = ImagingStudy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'name_ar';

    protected static ?string $navigationLabel = 'التصوير والأشعة';
    protected static ?string $modelLabel = 'تصوير';
    protected static ?string $pluralModelLabel = 'التصوير والأشعة';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label('الاسم بالعربية')
                    ->required()
                    ->placeholder('مثال: أشعة صدر'),

                TextInput::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->placeholder('Example: Chest X-Ray'),

                TextInput::make('abbreviation')
                    ->label('الاختصار')
                    ->placeholder('مثال: CXR'),

                Select::make('type')
                    ->label('نوع التصوير')
                    ->options([
                        'x-ray' => '🔲 أشعة عادية',
                        'ct' => '🔄 أشعة مقطعية (CT)',
                        'mri' => '🧲 رنين مغناطيسي (MRI)',
                        'ultrasound' => '📡 إيكو/سونار',
                        'doppler' => '🩺 دوبلر',
                        'mammogram' => '🎀 ماموجرام',
                        'fluoroscopy' => '📹 فلوروسكوبي',
                        'other' => '📋 أخرى',
                    ])
                    ->default('x-ray')
                    ->required(),

                TextInput::make('body_part')
                    ->label('المنطقة المصورة')
                    ->placeholder('مثال: صدر، بطن، رأس، حوض...'),

                Textarea::make('description')
                    ->label('الوصف')
                    ->rows(3)
                    ->placeholder('وصف إضافي...')
                    ->columnSpanFull(),

                TextInput::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),

                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_ar')
            ->columns([
                TextColumn::make('name_ar')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'x-ray' => 'أشعة عادية',
                        'ct' => 'CT',
                        'mri' => 'MRI',
                        'ultrasound' => 'إيكو',
                        'doppler' => 'دوبلر',
                        'mammogram' => 'ماموجرام',
                        'fluoroscopy' => 'فلوروسكوبي',
                        default => 'أخرى',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'x-ray' => 'info',
                        'ct' => 'warning',
                        'mri' => 'success',
                        'ultrasound' => 'primary',
                        'doppler' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('body_part')
                    ->label('المنطقة')
                    ->searchable(),

                TextColumn::make('abbreviation')
                    ->label('الاختصار')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('usage_count')
                    ->label('مرات الاستخدام')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('تعديل'),
                DeleteAction::make()
                    ->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف'),
                ]),
            ])
            ->defaultSort('usage_count', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageImagingStudies::route('/'),
        ];
    }
}
