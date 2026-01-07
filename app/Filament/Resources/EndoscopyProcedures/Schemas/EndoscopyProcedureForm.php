<?php

namespace App\Filament\Resources\EndoscopyProcedures\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EndoscopyProcedureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('patient_id')
                    ->required()
                    ->numeric(),
                TextInput::make('sequential_number')
                    ->required(),
                DatePicker::make('procedure_date')
                    ->required(),
                TextInput::make('day_of_week')
                    ->required(),
                TextInput::make('hospital_id')
                    ->required()
                    ->numeric(),
                Select::make('admission_type')
                    ->options(['internal' => 'Internal', 'external' => 'External'])
                    ->required(),
                TextInput::make('source')
                    ->required(),
                TextInput::make('doctor_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('indication_id')
                    ->numeric()
                    ->default(null),
                Textarea::make('indication_notes')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('procedure_type')
                    ->options(['upper' => 'Upper', 'lower' => 'Lower', 'biopsy' => 'Biopsy'])
                    ->required(),
                Textarea::make('result_text')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('biopsy_locations')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('biopsy_results')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('follow_up_status')
                    ->options(['completed' => 'Completed', 'ongoing' => 'Ongoing'])
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
