<?php

namespace App\Filament\Resources\LabTests;

use App\Filament\Resources\LabTests\Pages\ManageLabTests;
use App\Models\LabTest;
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

class LabTestResource extends Resource
{
    protected static ?string $model = LabTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?string $recordTitleAttribute = 'name_ar';

    protected static ?string $navigationLabel = 'التحاليل';
    protected static ?string $modelLabel = 'تحليل';
    protected static ?string $pluralModelLabel = 'التحاليل المخبرية';
    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label('الاسم بالعربية')
                    ->required()
                    ->placeholder('مثال: سكر صائم'),

                TextInput::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->placeholder('Example: Fasting Blood Sugar'),

                TextInput::make('abbreviation')
                    ->label('الاختصار')
                    ->placeholder('مثال: FBS'),

                Select::make('category')
                    ->label('الفئة')
                    ->options([
                        'blood' => '🩸 دم',
                        'urine' => '💧 بول',
                        'stool' => '🧪 براز',
                        'culture' => '🦠 زراعة',
                        'hormones' => '⚗️ هرمونات',
                        'other' => '📋 أخرى',
                    ])
                    ->default('blood'),

                TextInput::make('normal_range')
                    ->label('المجال الطبيعي')
                    ->placeholder('مثال: 70-110 mg/dl')
                    ->columnSpan(1),

                TextInput::make('unit')
                    ->label('الوحدة')
                    ->placeholder('مثال: mg/dl, mmol/L, %')
                    ->columnSpan(1),

                Textarea::make('description')
                    ->label('الوصف')
                    ->rows(3)
                    ->placeholder('وصف التحليل...')
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
            ])
            ->columns(2);
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

                TextColumn::make('abbreviation')
                    ->label('الاختصار')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('category')
                    ->label('الفئة')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'blood' => 'دم',
                        'urine' => 'بول',
                        'stool' => 'براز',
                        'culture' => 'زراعة',
                        'hormones' => 'هرمونات',
                        default => 'أخرى',
                    })
                    ->color(fn(?string $state): string => match ($state) {
                        'blood' => 'danger',
                        'urine' => 'info',
                        'stool' => 'warning',
                        'culture' => 'success',
                        'hormones' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('normal_range')
                    ->label('المجال الطبيعي')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('unit')
                    ->label('الوحدة')
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
            'index' => ManageLabTests::route('/'),
        ];
    }
}
