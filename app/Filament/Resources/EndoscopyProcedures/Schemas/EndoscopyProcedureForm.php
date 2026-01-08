<?php

namespace App\Filament\Resources\EndoscopyProcedures\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class EndoscopyProcedureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الإجراء الأساسية')
                    ->schema([
                        Grid::make(2)
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

                                DatePicker::make('procedure_date')
                                    ->label('تاريخ الإجراء')
                                    ->required()
                                    ->default(now())
                                    ->native(false),

                                Select::make('hospital_id')
                                    ->label('المشفى')
                                    ->relationship('hospital', 'name_ar')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('admission_type')
                                    ->label('نوع الإدخال')
                                    ->options([
                                        'internal' => 'داخلي',
                                        'external' => 'خارجي',
                                    ])
                                    ->required()
                                    ->default('internal'),

                                Select::make('source')
                                    ->label('المصدر')
                                    ->options([
                                        'hospital' => 'مشفى',
                                        'consultation' => 'استشارة',
                                        'private' => 'خاص',
                                    ])
                                    ->required()
                                    ->default('hospital'),

                                Select::make('procedure_type')
                                    ->label('نوع الإجراء')
                                    ->options([
                                        'upper' => 'علوي',
                                        'lower' => 'سفلي',
                                        'biopsy' => 'خزعة',
                                    ])
                                    ->required()
                                    ->default('upper'),
                            ]),


                        Grid::make(2)
                            ->schema([
                                Select::make('doctor_id')
                                    ->label('الطبيب')
                                    ->relationship('doctor', 'name')
                                    ->searchable()
                                    ->preload(),

                                Select::make('indication_id')
                                    ->label('الاستطباب')
                                    ->relationship('indication', 'name_ar')
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
                                        $indication = \App\Models\PreliminaryDiagnosis::create([
                                            'name_ar' => $data['name_ar'],
                                            'name_en' => $data['name_en'] ?? null,
                                            'category' => $data['category'] ?? 'عام',
                                            'is_active' => true,
                                        ]);

                                        \Filament\Notifications\Notification::make()
                                            ->title('تم إضافة الاستطباب بنجاح')
                                            ->body("تم إضافة: {$indication->name_ar}")
                                            ->success()
                                            ->send();

                                        return $indication->id;
                                    })
                                    ->createOptionModalHeading('إضافة استطباب جديد')
                                    ->helperText('اختر الاستطباب أو أضف جديد'),
                            ]),

                        Textarea::make('indication_notes')
                            ->label('ملاحظات الاستطباب')
                            ->rows(3)
                            ->placeholder('أي ملاحظات حول الاستطباب...')
                            ->columnSpanFull(),
                    ])->collapsible()
                    ->collapsed(),

                Section::make('التداخلات')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->description('اختر التداخلات التي تم إجراؤها')
                    ->schema([
                        Select::make('interventions')
                            ->label('التداخلات المنفذة')
                            ->relationship('interventions', 'name_ar')
                            ->multiple()
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
                                TextInput::make('abbreviation')
                                    ->label('الاختصار')
                                    ->maxLength(50),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $intervention = \App\Models\EndoscopyIntervention::create([
                                    'name_ar' => $data['name_ar'],
                                    'name_en' => $data['name_en'] ?? null,
                                    'abbreviation' => $data['abbreviation'] ?? null,
                                    'is_active' => true,
                                ]);

                                \Filament\Notifications\Notification::make()
                                    ->title('تم إضافة التداخل بنجاح')
                                    ->body("تم إضافة: {$intervention->name_ar}")
                                    ->success()
                                    ->send();

                                return $intervention->id;
                            })
                            ->createOptionModalHeading('إضافة تداخل جديد')
                            ->suffixIcon('heroicon-o-plus-circle')
                            ->helperText('يمكنك اختيار أكثر من تداخل أو إضافة تداخل جديد')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('نتائج الإجراء')
                    ->schema([
                        Textarea::make('result_text')
                            ->label('نص النتيجة')
                            ->rows(4)
                            ->placeholder('وصف تفصيلي لنتيجة الإجراء...')
                            ->columnSpanFull(),

                        Select::make('biopsyLocations')
                            ->label('مواقع الخزعة')
                            ->relationship('biopsyLocations', 'name_ar')
                            ->multiple()
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
                                TextInput::make('abbreviation')
                                    ->label('الاختصار')
                                    ->maxLength(50),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $location = \App\Models\BiopsyLocation::create([
                                    'name_ar' => $data['name_ar'],
                                    'name_en' => $data['name_en'] ?? null,
                                    'abbreviation' => $data['abbreviation'] ?? null,
                                    'is_active' => true,
                                ]);

                                \Filament\Notifications\Notification::make()
                                    ->title('تم إضافة مكان الخزعة بنجاح')
                                    ->body("تم إضافة: {$location->name_ar}")
                                    ->success()
                                    ->send();

                                return $location->id;
                            })
                            ->createOptionModalHeading('إضافة مكان خزعة جديد')
                            ->suffixIcon('heroicon-o-plus-circle')
                            ->helperText('يمكنك اختيار أكثر من مكان أو إضافة مكان جديد')
                            ->columnSpanFull(),

                        Textarea::make('biopsy_results')
                            ->label('نتائج الخزعة')
                            ->rows(3)
                            ->placeholder('نتائج تحليل الخزعة...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('المتابعة والملاحظات')
                    ->schema([
                        Select::make('follow_up_status')
                            ->label('حالة المتابعة')
                            ->options([
                                'completed' => 'مكتمل',
                                'ongoing' => 'مستمر',
                            ])
                            ->placeholder('اختر حالة المتابعة'),

                        Textarea::make('notes')
                            ->label('ملاحظات إضافية')
                            ->rows(3)
                            ->placeholder('أي ملاحظات أخرى...')
                            ->columnSpanFull(),
                    ])->collapsible()
                    ->collapsed(),
            ]);
    }
}
