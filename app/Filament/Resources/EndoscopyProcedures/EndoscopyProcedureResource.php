<?php

namespace App\Filament\Resources\EndoscopyProcedures;

use App\Filament\Resources\EndoscopyProcedures\Pages\CreateEndoscopyProcedure;
use App\Filament\Resources\EndoscopyProcedures\Pages\EditEndoscopyProcedure;
use App\Filament\Resources\EndoscopyProcedures\Pages\ListEndoscopyProcedures;
use App\Filament\Resources\EndoscopyProcedures\Pages\ViewEndoscopyProcedure;
use App\Filament\Resources\EndoscopyProcedures\Schemas\EndoscopyProcedureForm;
use App\Filament\Resources\EndoscopyProcedures\Schemas\EndoscopyProcedureInfolist;
use App\Filament\Resources\EndoscopyProcedures\Tables\EndoscopyProceduresTable;
use App\Models\EndoscopyProcedure;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EndoscopyProcedureResource extends Resource
{
    protected static ?string $model = EndoscopyProcedure::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'إجراءات التنظير';

    protected static ?string $modelLabel = 'إجراء تنظير';

    protected static ?string $pluralModelLabel = 'إجراءات التنظير';

    protected static ?string $navigationGroup = 'السجلات الطبية';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return EndoscopyProcedureForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EndoscopyProcedureInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EndoscopyProceduresTable::configure($table);
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
            'index' => ListEndoscopyProcedures::route('/'),
            'create' => CreateEndoscopyProcedure::route('/create'),
            'view' => ViewEndoscopyProcedure::route('/{record}'),
            'edit' => EditEndoscopyProcedure::route('/{record}/edit'),
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
