<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Appointment;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AppointmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('patient.id')
                    ->label('Patient'),
                TextEntry::make('visit.id')
                    ->label('Visit')
                    ->placeholder('-'),
                TextEntry::make('appointment_type_id')
                    ->numeric(),
                TextEntry::make('appointment_date')
                    ->date(),
                TextEntry::make('appointment_time')
                    ->time(),
                TextEntry::make('duration')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('priority')
                    ->badge(),
                TextEntry::make('location')
                    ->placeholder('-'),
                TextEntry::make('reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('doctor_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('payment_status')
                    ->badge(),
                IconEntry::make('reminder_sent')
                    ->boolean(),
                TextEntry::make('reminder_sent_at')
                    ->dateTime()
                    ->placeholder('-'),
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
                    ->visible(fn (Appointment $record): bool => $record->trashed()),
            ]);
    }
}
