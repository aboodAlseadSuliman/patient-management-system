<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Models\Patient;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('file_number')
                    ->label('رقم الملف')
                    ->badge()
                    ->color('primary')
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('full_name')
                    ->label('الاسم الكامل')
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('national_id')
                    ->label('رقم الهوية الوطنية')
                    ->copyable()
                    ->placeholder('-'),

                TextEntry::make('gender')
                    ->label('الجنس')
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                        default => '-',
                    })
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        default => 'gray',
                    }),

                TextEntry::make('date_of_birth')
                    ->label('تاريخ الميلاد')
                    ->date('Y-m-d')
                    ->placeholder('-'),

                TextEntry::make('age_display')
                    ->label('العمر')
                    ->badge()
                    ->color('success'),

                TextEntry::make('phone')
                    ->label('رقم الجوال')
                    ->icon('heroicon-m-phone')
                    ->copyable()
                    ->placeholder('-'),

                TextEntry::make('alternative_phone')
                    ->label('رقم هاتف بديل')
                    ->icon('heroicon-m-phone')
                    ->copyable()
                    ->placeholder('-'),

                TextEntry::make('city')
                    ->label('المدينة')
                    ->icon('heroicon-m-map-pin')
                    ->badge()
                    ->placeholder('-'),

                TextEntry::make('address')
                    ->label('العنوان')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('area')
                    ->label('المنطقة / الحي')
                    ->placeholder('-'),

                TextEntry::make('is_active')
                    ->label('الحالة')
                    ->formatStateUsing(fn($state) => $state ? 'نشط ✅' : 'غير نشط ❌')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextEntry::make('notes')
                    ->label('ملاحظات')
                    ->placeholder('لا توجد ملاحظات')
                    ->columnSpanFull(),

                TextEntry::make('creator.name')
                    ->label('أنشئ بواسطة')
                    ->icon('heroicon-m-user')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('-'),

                TextEntry::make('updater.name')
                    ->label('تم التحديث بواسطة')
                    ->icon('heroicon-m-user')
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('-'),

                TextEntry::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime('Y-m-d H:i')
                    ->visible(fn(Patient $record): bool => $record->trashed()),
            ]);
    }
}
