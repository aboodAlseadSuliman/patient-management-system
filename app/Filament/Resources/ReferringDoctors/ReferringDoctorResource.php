<?php

namespace App\Filament\Resources\ReferringDoctors;

use App\Filament\Resources\ReferringDoctors\Pages\CreateReferringDoctor;
use App\Filament\Resources\ReferringDoctors\Pages\EditReferringDoctor;
use App\Filament\Resources\ReferringDoctors\Pages\ListReferringDoctors;
use App\Filament\Resources\ReferringDoctors\Schemas\ReferringDoctorForm;
use App\Filament\Resources\ReferringDoctors\Tables\ReferringDoctorsTable;
use App\Models\ReferringDoctor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReferringDoctorResource extends Resource
{
    protected static ?string $model = ReferringDoctor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'الأطباء المحولين';

    protected static ?string $modelLabel = 'طبيب محول';

    protected static ?string $pluralModelLabel = 'الأطباء المحولين';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ReferringDoctorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReferringDoctorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReferringDoctors::route('/'),
            'create' => CreateReferringDoctor::route('/create'),
            'edit' => EditReferringDoctor::route('/{record}/edit'),
        ];
    }
}
