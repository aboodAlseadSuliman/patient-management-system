<?php

namespace App\Filament\Resources\Diagnoses;

use App\Filament\Resources\Diagnoses\Pages\ManageDiagnoses;
use App\Models\Diagnosis;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DiagnosisResource extends Resource
{
    protected static ?string $model = Diagnosis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;
    protected static ?string $recordTitleAttribute = 'name_ar';

    protected static ?string $navigationLabel = 'التشخيصات';

    protected static ?string $modelLabel = 'تشخيص';

    protected static ?string $pluralModelLabel = 'التشخيصات';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label('الاسم بالعربية')
                    ->required(),
                TextInput::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->default(null),
                TextInput::make('abbreviation')
                    ->label('الاختصار')
                    ->default(null),
                TextInput::make('icd_code')
                    ->label('كود ICD')
                    ->default(null),
                TextInput::make('category')
                    ->label('الفئة')
                    ->default(null),
                Textarea::make('description')
                    ->label('الوصف')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_chronic')
                    ->label('مزمن')
                    ->required(),
                TextInput::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name_ar')
                    ->label('الاسم بالعربية'),
                TextEntry::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->placeholder('-'),
                TextEntry::make('abbreviation')
                    ->label('الاختصار')
                    ->placeholder('-'),
                TextEntry::make('icd_code')
                    ->label('كود ICD')
                    ->placeholder('-'),
                TextEntry::make('category')
                    ->label('الفئة')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label('الوصف')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_chronic')
                    ->label('مزمن')
                    ->boolean(),
                TextEntry::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->numeric(),
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
            ->recordTitleAttribute('name_ar')
            ->columns([
                TextColumn::make('name_ar')
                    ->label('الاسم بالعربية')
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->searchable(),
                TextColumn::make('abbreviation')
                    ->label('الاختصار')
                    ->searchable(),
                TextColumn::make('icd_code')
                    ->label('كود ICD')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('الفئة')
                    ->searchable(),
                IconColumn::make('is_chronic')
                    ->label('مزمن')
                    ->boolean(),
                TextColumn::make('usage_count')
                    ->label('عدد مرات الاستخدام')
                    ->numeric()
                    ->sortable(),
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
            'index' => ManageDiagnoses::route('/'),
        ];
    }
}
