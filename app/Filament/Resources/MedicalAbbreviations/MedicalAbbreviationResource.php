<?php

namespace App\Filament\Resources\MedicalAbbreviations;

use App\Filament\Resources\MedicalAbbreviations\Pages\ManageMedicalAbbreviations;
use App\Models\MedicalAbbreviation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MedicalAbbreviationResource extends Resource
{
    protected static ?string $model = MedicalAbbreviation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static ?string $recordTitleAttribute = 'abbreviation';

    protected static ?string $navigationLabel = 'الاختصارات الطبية';

    protected static ?string $modelLabel = 'اختصار طبي';

    protected static ?string $pluralModelLabel = 'الاختصارات الطبية';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('abbreviation')
                    ->label('الاختصار')
                    ->required(),
                TextInput::make('full_text')
                    ->label('النص الكامل')
                    ->required(),
                Select::make('category')
                    ->label('الفئة')
                    ->options([
                        'symptom' => 'أعراض',
                        'diagnosis' => 'تشخيص',
                        'medication' => 'دواء',
                        'procedure' => 'إجراء',
                        'examination' => 'فحص',
                        'general' => 'عام',
                    ])
                    ->default('general')
                    ->required(),
                Select::make('language')
                    ->label('اللغة')
                    ->options([
                        'ar' => 'عربي',
                        'en' => 'إنجليزي',
                        'both' => 'كلاهما',
                    ])
                    ->default('ar')
                    ->required(),
                TextInput::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->label('أنشئ بواسطة')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_system')
                    ->label('اختصار نظامي')
                    ->required(),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('abbreviation')
                    ->label('الاختصار'),
                TextEntry::make('full_text')
                    ->label('النص الكامل'),
                TextEntry::make('category')
                    ->label('الفئة')
                    ->badge(),
                TextEntry::make('language')
                    ->label('اللغة')
                    ->badge(),
                TextEntry::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->numeric(),
                TextEntry::make('created_by')
                    ->label('أنشئ بواسطة')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_system')
                    ->label('اختصار نظامي')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('abbreviation')
            ->columns([
                TextColumn::make('abbreviation')
                    ->label('الاختصار')
                    ->searchable(),
                TextColumn::make('full_text')
                    ->label('النص الكامل')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('الفئة')
                    ->badge(),
                TextColumn::make('language')
                    ->label('اللغة')
                    ->badge(),
                TextColumn::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_by')
                    ->label('أنشئ بواسطة')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_system')
                    ->label('نظامي')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMedicalAbbreviations::route('/'),
        ];
    }
}
