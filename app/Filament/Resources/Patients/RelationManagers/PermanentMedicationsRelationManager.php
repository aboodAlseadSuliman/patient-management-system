<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Filament\Resources\Medications\MedicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PermanentMedicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'permanentMedications';

    protected static ?string $relatedResource = MedicationResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
