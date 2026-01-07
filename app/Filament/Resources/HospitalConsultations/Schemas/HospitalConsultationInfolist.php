<?php

namespace App\Filament\Resources\HospitalConsultations\Schemas;

use App\Models\HospitalConsultation;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HospitalConsultationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('patient_id')
                    ->numeric(),
                TextEntry::make('sequential_number'),
                TextEntry::make('consultation_date')
                    ->date(),
                TextEntry::make('day_of_week'),
                TextEntry::make('hospital_id')
                    ->numeric(),
                TextEntry::make('source')
                    ->badge(),
                TextEntry::make('doctor_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('preliminary_diagnosis_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('preliminary_diagnosis_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('accompanying_diseases')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('procedures')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('final_diagnosis')
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
                    ->visible(fn (HospitalConsultation $record): bool => $record->trashed()),
            ]);
    }
}
