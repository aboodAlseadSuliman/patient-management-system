<?php

namespace App\Filament\Resources\EndoscopyProcedures\Schemas;

use App\Models\EndoscopyProcedure;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EndoscopyProcedureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('patient_id')
                    ->numeric(),
                TextEntry::make('sequential_number'),
                TextEntry::make('procedure_date')
                    ->date(),
                TextEntry::make('day_of_week'),
                TextEntry::make('hospital_id')
                    ->numeric(),
                TextEntry::make('admission_type')
                    ->badge(),
                TextEntry::make('source'),
                TextEntry::make('doctor_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('indication_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('indication_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('procedure_type')
                    ->badge(),
                TextEntry::make('result_text')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('biopsy_locations')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('biopsy_results')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('follow_up_status')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (EndoscopyProcedure $record): bool => $record->trashed()),
            ]);
    }
}
