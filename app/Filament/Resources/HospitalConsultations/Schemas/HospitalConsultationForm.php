<?php

namespace App\Filament\Resources\HospitalConsultations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HospitalConsultationForm
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
                DatePicker::make('consultation_date')
                    ->required(),
                TextInput::make('day_of_week')
                    ->required(),
                TextInput::make('hospital_id')
                    ->required()
                    ->numeric(),
                Select::make('source')
                    ->options(['hospital' => 'Hospital', 'consultation' => 'Consultation', 'private' => 'Private'])
                    ->required(),
                TextInput::make('doctor_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('preliminary_diagnosis_id')
                    ->numeric()
                    ->default(null),
                Textarea::make('preliminary_diagnosis_notes')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('accompanying_diseases')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('procedures')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('final_diagnosis')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('follow_up_status')
                    ->options(['cured' => 'Cured', 'ongoing' => 'Ongoing', 'deceased' => 'Deceased'])
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
