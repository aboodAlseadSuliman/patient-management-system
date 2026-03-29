<?php

namespace App\Filament\Resources\AttachmentTypes;

use App\Filament\Resources\AttachmentTypes\Pages\CreateAttachmentType;
use App\Filament\Resources\AttachmentTypes\Pages\EditAttachmentType;
use App\Filament\Resources\AttachmentTypes\Pages\ListAttachmentTypes;
use App\Filament\Resources\AttachmentTypes\Schemas\AttachmentTypeForm;
use App\Filament\Resources\AttachmentTypes\Tables\AttachmentTypesTable;
use App\Models\AttachmentType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttachmentTypeResource extends Resource
{
    protected static ?string $model = AttachmentType::class;

    
    public static function canViewAny(): bool
    {
        return !auth()->user()?->isStaff();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'أنواع المرفقات';

    protected static ?string $modelLabel = 'نوع مرفق';

    protected static ?string $pluralModelLabel = 'أنواع المرفقات';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return AttachmentTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttachmentTypesTable::configure($table);
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
            'index' => ListAttachmentTypes::route('/'),
            'create' => CreateAttachmentType::route('/create'),
            'edit' => EditAttachmentType::route('/{record}/edit'),
        ];
    }
}
