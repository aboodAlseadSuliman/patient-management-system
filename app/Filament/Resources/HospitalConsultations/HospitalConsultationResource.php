<?php

namespace App\Filament\Resources\HospitalConsultations;

use App\Filament\Resources\HospitalConsultations\Pages\CreateHospitalConsultation;
use App\Filament\Resources\HospitalConsultations\Pages\EditHospitalConsultation;
use App\Filament\Resources\HospitalConsultations\Pages\ListHospitalConsultations;
use App\Filament\Resources\HospitalConsultations\Pages\ViewHospitalConsultation;
use App\Filament\Resources\HospitalConsultations\Schemas\HospitalConsultationForm;
use App\Filament\Resources\HospitalConsultations\Schemas\HospitalConsultationInfolist;
use App\Filament\Resources\HospitalConsultations\Tables\HospitalConsultationsTable;
use App\Models\HospitalConsultation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HospitalConsultationResource extends Resource
{
    protected static ?string $model = HospitalConsultation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'معاينات المشفى';

    protected static ?string $modelLabel = 'معاينة مشفى';

    protected static ?string $pluralModelLabel = 'معاينات المشفى';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return HospitalConsultationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HospitalConsultationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HospitalConsultationsTable::configure($table);
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
            'index' => ListHospitalConsultations::route('/'),
            'create' => CreateHospitalConsultation::route('/create'),
            'view' => ViewHospitalConsultation::route('/{record}'),
            'edit' => EditHospitalConsultation::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
