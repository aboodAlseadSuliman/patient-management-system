<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ==================== معلومات التعريف ====================
                Section::make('معلومات التعريف')
                    ->schema([
                        TextInput::make('file_number')
                            ->label('رقم الملف (6 خانات)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(6)
                            ->minLength(6)
                            ->numeric()
                            ->placeholder('255205')
                            ->helperText('خانتين للسنة + خانتين للأسبوع + خانتين للترتيب')
                            ->default(fn() => self::generateFileNumber())
                            ->columnSpan(1),

                        TextInput::make('national_id')
                            ->label('رقم الهوية الوطنية (اختياري)')
                            ->maxLength(50)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // ==================== البيانات الشخصية ====================
                Section::make('البيانات الشخصية')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('الاسم الأول')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $set('full_name', self::buildFullNameFromForm($get))
                            )
                            ->columnSpan(1),

                        TextInput::make('father_name')
                            ->label('اسم الأب (اختياري)')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $set('full_name', self::buildFullNameFromForm($get))
                            )
                            ->columnSpan(1),

                        TextInput::make('last_name')
                            ->label('اسم العائلة')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $set('full_name', self::buildFullNameFromForm($get))
                            )
                            ->columnSpan(1),


                        Select::make('gender')
                            ->label('الجنس')
                            ->options([
                                'male' => 'ذكر',
                                'female' => 'أنثى',
                            ])
                            ->required()
                            ->columnSpan(1),

                        Select::make('birth_year')
                            ->label('سنة الميلاد')
                            ->options(self::getBirthYearOptions())
                            ->searchable()
                            ->columnSpan(1),

                        DatePicker::make('date_of_birth')
                            ->label('تاريخ الميلاد (اختياري)')
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible(),

                // ==================== معلومات الاتصال ====================
                Section::make('معلومات الاتصال')
                    ->schema([
                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])
                    ->collapsible(),

                // ==================== الإقامة ====================
                Section::make('الإقامة')
                    ->description('اختياري - حدد بيانات الإقامة')
                    ->schema([
                        TextInput::make('country')
                            ->label('البلد (للمغترب)')
                            ->maxLength(100)
                            ->columnSpan(1),

                        TextInput::make('province')
                            ->label('المحافظة')
                            ->maxLength(100)
                            ->columnSpan(1),

                        TextInput::make('neighborhood')
                            ->label('الحي / القرية')
                            ->maxLength(100)
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),

                // ==================== معلومات إضافية ====================
                Section::make('معلومات إضافية')
                    ->schema([
                        TextInput::make('occupation')
                            ->label('المهنة (اختياري)')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('referring_doctor_id')
                            ->label('الطبيب المحول (اختياري)')
                            ->relationship('referringDoctor', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}" . ($record->specialty ? " - {$record->specialty}" : ''))
                            ->searchable(['first_name', 'last_name', 'specialty'])
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('first_name')
                                    ->label('الاسم الأول')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->label('الكنية')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('specialty')
                                    ->label('التخصص')
                                    ->maxLength(255),
                                TextInput::make('mobile_phone')
                                    ->label('رقم الجوال')
                                    ->tel()
                                    ->maxLength(20),
                            ])
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(2),

                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    /**
     * توليد رقم ملف تلقائي
     * Format: YYMMNN
     * YY = السنة (خانتين)
     * WW = رقم الأسبوع (خانتين)
     * NN = الترتيب في الأسبوع (خانتين)
     */
    private static function generateFileNumber(): string
    {
        $year = date('y'); // آخر خانتين من السنة
        $week = date('W'); // رقم الأسبوع في السنة

        // البحث عن آخر رقم ملف في هذا الأسبوع
        $prefix = $year . str_pad($week, 2, '0', STR_PAD_LEFT);

        $lastPatient = \App\Models\Patient::where('file_number', 'LIKE', $prefix . '%')
            ->orderBy('file_number', 'desc')
            ->first();

        if ($lastPatient) {
            $lastNumber = (int) substr($lastPatient->file_number, -2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }

    /**
     * الحصول على خيارات سنة الميلاد
     */
    private static function getBirthYearOptions(): array
    {
        $currentYear = date('Y');
        $years = [];

        for ($year = $currentYear; $year >= 1920; $year--) {
            $years[$year] = (string) $year;
        }

        return $years;
    }

    /**
     * بناء الاسم الكامل من حقول الفورم
     */
    private static function buildFullNameFromForm(callable $get): string
    {
        $firstName = $get('first_name');
        $fatherName = $get('father_name');
        $lastName = $get('last_name');

        $parts = array_filter([$firstName, $fatherName, $lastName]);
        return implode(' ', $parts);
    }
}