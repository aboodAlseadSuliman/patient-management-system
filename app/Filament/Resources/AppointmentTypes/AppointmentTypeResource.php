<?php

namespace App\Filament\Resources\AppointmentTypes;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\AppointmentType;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\AppointmentTypes\Pages\ManageAppointmentTypes;

class AppointmentTypeResource extends Resource
{
    protected static ?string $model = AppointmentType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name_ar';


    protected static ?string $navigationLabel = 'أنواع المواعيد';
    protected static ?string $modelLabel = 'نوع موعد';
    protected static ?string $pluralModelLabel = 'أنواع المواعيد';
    protected static ?int $navigationSort = 9;
    // protected static ?string $navigationGroup = 'الإعدادات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label('الاسم بالعربية')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                TextInput::make('name_en')
                    ->label('الاسم بالإنجليزية')
                    ->columnSpan(1),

                TextInput::make('slug')
                    ->label('المعرّف (Slug)')
                    ->helperText('يُنشأ تلقائياً إذا ترك فارغاً')
                    ->unique(ignoreRecord: true)
                    ->columnSpan(2),

                Textarea::make('description')
                    ->label('الوصف')
                    ->rows(2)
                    ->columnSpanFull(),

                Select::make('color')
                    ->label('اللون')
                    ->options([
                        'gray' => 'رمادي',
                        'primary' => 'أزرق',
                        'success' => 'أخضر',
                        'warning' => 'أصفر',
                        'danger' => 'أحمر',
                        'info' => 'سماوي',
                    ])
                    ->default('gray')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('icon')
                    ->label('الأيقونة')
                    ->placeholder('heroicon-o-calendar')
                    ->helperText('اسم أيقونة Heroicon')
                    ->columnSpan(1),

                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(2),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ar')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('المعرّف')
                    ->searchable()
                    ->toggleable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('color')
                    ->label('اللون')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'gray' => 'رمادي',
                        'primary' => 'أزرق',
                        'success' => 'أخضر',
                        'warning' => 'أصفر',
                        'danger' => 'أحمر',
                        'info' => 'سماوي',
                        default => $state,
                    })
                    ->color(fn($state) => $state),

                TextColumn::make('appointments_count')
                    ->label('عدد المواعيد')
                    ->counts('appointments')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name_ar')
            ->recordActions([
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
            'index' => ManageAppointmentTypes::route('/'),
        ];
    }
}
