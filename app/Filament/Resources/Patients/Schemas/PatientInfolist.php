<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Models\Patient;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات التعريف')
                    ->schema([
                        TextEntry::make('file_number')
                            ->label('رقم الملف')
                            ->badge()
                            ->color('primary')
                            ->size('lg')
                            ->weight('bold')
                            ->copyable(),

                        TextEntry::make('national_id')
                            ->label('رقم الهوية الوطنية')
                            ->copyable()
                            ->placeholder('—'),
                    ])
                    ->columns(2),

                Section::make('البيانات الشخصية')
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('الاسم الكامل')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('first_name')
                            ->label('الاسم الأول'),

                        TextEntry::make('father_name')
                            ->label('اسم الأب')
                            ->placeholder('—'),

                        TextEntry::make('last_name')
                            ->label('اسم العائلة'),

                        TextEntry::make('gender')
                            ->label('الجنس')
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'male' => 'ذكر',
                                'female' => 'أنثى',
                                default => '—',
                            })
                            ->badge()
                            ->color(fn(?string $state): string => match ($state) {
                                'male' => 'info',
                                'female' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('birth_year')
                            ->label('سنة الميلاد')
                            ->badge()
                            ->color('success')
                            ->placeholder('—'),

                        TextEntry::make('date_of_birth')
                            ->label('تاريخ الميلاد الكامل')
                            ->date('Y-m-d')
                            ->placeholder('—'),

                        TextEntry::make('age_display')
                            ->label('العمر')
                            ->badge()
                            ->color('success')
                            ->placeholder('—'),
                    ])
                    ->columns(3),

                Section::make('معلومات الاتصال')
                    ->schema([
                        TextEntry::make('phone')
                            ->label('رقم الهاتف')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->size('lg'),
                    ]),

                Section::make('الإقامة')
                    ->schema([
                        TextEntry::make('country')
                            ->label('البلد')
                            ->icon('heroicon-m-globe-alt')
                            ->placeholder('—'),

                        TextEntry::make('province')
                            ->label('المحافظة')
                            ->icon('heroicon-m-map-pin')
                            ->placeholder('—'),

                        TextEntry::make('neighborhood')
                            ->label('الحي / القرية')
                            ->icon('heroicon-m-home')
                            ->placeholder('—'),
                    ])
                    ->columns(3)
                    ->collapsed()
                    ->collapsible(),

                Section::make('معلومات إضافية')
                    ->schema([
                        TextEntry::make('occupation')
                            ->label('المهنة')
                            ->icon('heroicon-m-briefcase')
                            ->placeholder('—'),

                        TextEntry::make('referringDoctor.full_name')
                            ->label('الطبيب المحول')
                            ->icon('heroicon-m-user')
                            ->placeholder('—')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('referringDoctor.specialty')
                            ->label('تخصص الطبيب المحول')
                            ->icon('heroicon-m-academic-cap')
                            ->placeholder('—')
                            ->visible(fn($record) => $record->referring_doctor_id !== null),

                        TextEntry::make('is_active')
                            ->label('الحالة')
                            ->formatStateUsing(fn($state) => $state ? 'نشط ✅' : 'غير نشط ❌')
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'danger'),

                        TextEntry::make('notes')
                            ->label('ملاحظات')
                            ->placeholder('لا توجد ملاحظات')
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->collapsed()
                    ->collapsible(),

                Section::make('معلومات النظام')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('أنشئ بواسطة')
                            ->icon('heroicon-m-user')
                            ->placeholder('—'),

                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->dateTime('Y-m-d H:i')
                            ->placeholder('—'),

                        TextEntry::make('updater.name')
                            ->label('تم التحديث بواسطة')
                            ->icon('heroicon-m-user')
                            ->placeholder('—'),

                        TextEntry::make('updated_at')
                            ->label('تاريخ التحديث')
                            ->dateTime('Y-m-d H:i')
                            ->placeholder('—'),

                        TextEntry::make('deleted_at')
                            ->label('تاريخ الحذف')
                            ->dateTime('Y-m-d H:i')
                            ->visible(fn(Patient $record): bool => $record->trashed())
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->collapsed()
                    ->collapsible(),
            ]);
    }
}
