<?php

namespace App\Filament\Resources\HospitalConsultations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class HospitalConsultationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات المعاينة الأساسية')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('patient_id')
                                    ->label('المريض')
                                    ->relationship('patient', 'full_name')
                                    ->searchable(['full_name', 'file_number', 'phone'])
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('first_name')
                                            ->label('الاسم الأول')
                                            ->required(),
                                        TextInput::make('father_name')
                                            ->label('اسم الأب')
                                            ->required(),
                                        TextInput::make('last_name')
                                            ->label('اسم العائلة')
                                            ->required(),
                                    ]),

                                DatePicker::make('consultation_date')
                                    ->label('تاريخ المعاينة')
                                    ->required()
                                    ->default(now())
                                    ->native(false),

                                Select::make('hospital_id')
                                    ->label('المشفى')
                                    ->relationship('hospital', 'name_ar')
                                    ->searchable()
                                    ->preload()
                                    ->required(),


                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('source')
                                    ->label('المصدر')
                                    ->options([
                                        'hospital' => 'مشفى',
                                        'consultation' => 'استشارة',
                                        'private' => 'خاص',
                                    ])
                                    ->required()
                                    ->default('hospital'),

                                Select::make('doctor_id')
                                    ->label('الطبيب')
                                    ->relationship('doctor', 'name')
                                    ->searchable()
                                    ->preload(),

                                Select::make('preliminary_diagnosis_id')
                                    ->label('التشخيص الأولي')
                                    ->relationship('preliminaryDiagnosis', 'name_ar')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('الاسم بالعربية')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('name_en')
                                            ->label('الاسم بالإنجليزية')
                                            ->maxLength(255),
                                        TextInput::make('category')
                                            ->label('التصنيف')
                                            ->maxLength(100),
                                    ])
                                    ->createOptionUsing(function (array $data): int {
                                        $diagnosis = \App\Models\Diagnosis::create([
                                            'name_ar' => $data['name_ar'],
                                            'name_en' => $data['name_en'] ?? null,
                                            'category' => $data['category'] ?? 'عام',
                                            'is_active' => true,
                                            'usage_count' => 0,
                                        ]);

                                        \Filament\Notifications\Notification::make()
                                            ->title('تم إضافة التشخيص بنجاح')
                                            ->body("تم إضافة: {$diagnosis->name_ar}")
                                            ->success()
                                            ->send();

                                        return $diagnosis->id;
                                    })
                                    ->createOptionModalHeading('إضافة تشخيص جديد')
                                    ->helperText('اختر التشخيص المبدئي أو أضف جديد'),
                            ]),
                    ]),

                Section::make('التفاصيل الطبية')
                    ->schema([
                        Textarea::make('accompanying_diseases')
                            ->label('الأمراض المرافقة')
                            ->rows(3)
                            ->placeholder('مثال: ضغط دم، سكري، أمراض قلبية...')
                            ->columnSpanFull(),

                        Textarea::make('procedures')
                            ->label('الإجراءات المتخذة')
                            ->rows(3)
                            ->placeholder('وصف الإجراءات الطبية التي تم اتخاذها...')
                            ->columnSpanFull(),

                        Textarea::make('final_diagnosis')
                            ->label('التشخيص النهائي')
                            ->rows(3)
                            ->placeholder('التشخيص النهائي بعد الفحص...')
                            ->columnSpanFull(),
                    ]),

                Section::make('المتابعة والملاحظات')
                    ->schema([
                        Select::make('follow_up_status')
                            ->label('حالة المتابعة')
                            ->options([
                                'cured' => 'شفاء',
                                'ongoing' => 'مستمر',
                                'deceased' => 'وفاة',
                            ])
                            ->placeholder('اختر حالة المتابعة'),

                        Textarea::make('notes')
                            ->label('ملاحظات إضافية')
                            ->rows(3)
                            ->placeholder('أي ملاحظات أخرى...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
