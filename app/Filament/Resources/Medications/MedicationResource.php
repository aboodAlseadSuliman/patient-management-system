<?php

namespace App\Filament\Resources\Medications;

use App\Filament\Resources\Medications\Pages\ManageMedications;
use App\Models\Medication;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
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

class MedicationResource extends Resource
{
    protected static ?string $model = Medication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static ?string $recordTitleAttribute = 'name_ar';

    protected static ?string $navigationLabel = 'الأدوية';

    protected static ?string $modelLabel = 'دواء';

    protected static ?string $pluralModelLabel = 'الأدوية';

    protected static ?int $navigationSort = 4;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label('الاسم بالعربية')->required(),
                TextInput::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->default(null),
                TextInput::make('generic_name')
                    ->label('الاسم العلمي')
                    ->default(null),
                TextInput::make('brand_name')
                    ->label('الاسم التجاري')
                    ->default(null),
                TextInput::make('abbreviation')
                    ->label('االاختصار')
                    ->default(null),
                Select::make('dosage_form')
                    ->label('الشكل الدوائي')
                    ->options([
                        'tablet' => 'أقراص',
                        'capsule' => 'كبسولات',
                        'syrup' => 'شراب',
                        'injection' => 'حقن',
                        'cream' => 'كريم',
                        'ointment' => 'مرهم',
                        'drops' => 'قطرة',
                        'spray' => 'بخاخ',
                        'inhaler' => 'جهاز استنشاق',
                        'suppository' => 'تحميلة',
                        'patch' => 'لاصقة طبية',
                        'other' => 'أخرى',
                    ])
                    ->default('tablet')
                    ->required(),
                TextInput::make('strength')
                    ->label('التركيز')
                    ->default(null),
                TextInput::make('manufacturer')
                    ->label('الشركة المصنعة')
                    ->default(null),
                Textarea::make('description')
                    ->label('الوصف')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('common_dosage')
                    ->label('الجرعة الشائعة')
                    ->default(null),
                Textarea::make('side_effects')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('contraindications')
                    ->default(null)
                    ->columnSpanFull(),
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
                TextEntry::make('generic_name')
                    ->label('الاسم العلمي')
                    ->placeholder('-'),
                TextEntry::make('brand_name')
                    ->label('الاسم التجاري')
                    ->placeholder('-'),
                TextEntry::make('abbreviation')
                    ->label('االاختصار')
                    ->placeholder('-'),
                TextEntry::make('dosage_form')
                    ->label('الشكل الدوائي')
                    ->badge(),
                TextEntry::make('strength')
                    ->label('التركيز')
                    ->placeholder('-'),
                TextEntry::make('manufacturer')
                    ->label('الشركة المصنعة')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label('الوصف')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('common_dosage')
                    ->label('الجرعة الشائعة')
                    ->placeholder('-'),
                TextEntry::make('side_effects')
                    ->label('الآثار الجانبية')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('contraindications')
                    ->label('موانع الاستعمال')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('آخر تعديل')
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
                    ->label('الاسم بالعربية')->searchable(),
                TextColumn::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->searchable(),
                TextColumn::make('generic_name')
                    ->label('الاسم العلمي')
                    ->searchable(),
                TextColumn::make('brand_name')
                    ->label('الاسم التجاري')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('abbreviation')
                    ->label('االاختصار')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('dosage_form')
                    ->label('الشكل الدوائي')
                    ->badge(),
                TextColumn::make('strength')
                    ->label('التركيز')
                    ->searchable(),
                TextColumn::make('manufacturer')
                    ->label('الشركة المصنعة')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('common_dosage')
                    ->label('الجرعة الشائعة')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('آخر تعديل')
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
            'index' => ManageMedications::route('/'),
        ];
    }
}
