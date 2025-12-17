<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\ChronicDiseases\ChronicDiseaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ChronicDiseasesRelationManager extends RelationManager
{
    protected static string $relationship = 'chronicDiseases';

    protected static ?string $relatedResource = ChronicDiseaseResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
