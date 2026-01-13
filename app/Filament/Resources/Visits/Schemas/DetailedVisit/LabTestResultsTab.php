<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit;

use App\Models\LabTest;
use App\Models\LabTestResult;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class LabTestResultsTab
{
    public static function make(): Tab
    {
        return Tab::make('نتائج التحاليل')
            ->icon('heroicon-o-beaker')
            ->badge(fn($get) => count($get('lab_test_results_data') ?? []) ?: null)
            ->badgeColor('success')
            ->schema([
                Section::make('نتائج التحاليل المخبرية')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('سجل نتائج التحاليل مع إمكانية المقارنة مع القيم السابقة')
                    ->schema([
                        Repeater::make('lab_test_results_data')
                            ->label('التحاليل')
                            ->schema([
                                Select::make('lab_test_id')
                                    ->label('اسم التحليل')
                                    ->required()
                                    ->options(LabTest::query()->pluck('name_ar', 'id'))
                                    ->searchable()
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get, $record) {
                                        // جلب آخر نتيجة لهذا التحليل من الزيارات السابقة
                                        if ($state && $record) {
                                            $patientId = $record->patient_id;
                                            $previousResult = LabTestResult::whereHas('visit', function ($query) use ($patientId, $record) {
                                                $query->where('patient_id', $patientId)
                                                    ->where('id', '!=', $record->id);
                                            })
                                                ->where('lab_test_id', $state)
                                                ->latest('test_date')
                                                ->first();

                                            if ($previousResult) {
                                                $set('previous_value', $previousResult->result_value);
                                                $set('previous_test_date', $previousResult->test_date);
                                            }
                                        }
                                    })
                                    ->createOptionForm([
                                        TextInput::make('name_ar')
                                            ->label('اسم التحليل بالعربية')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('name_en')
                                            ->label('اسم التحليل بالإنجليزية')
                                            ->maxLength(255),
                                        TextInput::make('abbreviation')
                                            ->label('الاختصار')
                                            ->placeholder('FBS, CBC, etc.')
                                            ->maxLength(50),
                                        Textarea::make('description')
                                            ->label('وصف التحليل')
                                            ->rows(2),
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        return LabTest::create($data)->id;
                                    })
                                    ->columnSpan(2),

                                DatePicker::make('test_date')
                                    ->label('تاريخ التحليل')
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->closeOnDateSelection()
                                    ->columnSpan(1),

                                TextInput::make('result_value')
                                    ->label('النتيجة')
                                    ->required()
                                    ->placeholder('مثال: 13.5')
                                    ->columnSpan(1),

                                TextInput::make('unit')
                                    ->label('الوحدة')
                                    ->placeholder('g/dL, mg/dL, mmol/L')
                                    ->columnSpan(1),

                                TextInput::make('reference_range')
                                    ->label('المجال الطبيعي')
                                    ->placeholder('مثال: 12-16')
                                    ->helperText('المجال الطبيعي للقيمة')
                                    ->columnSpan(1),

                                Toggle::make('is_normal')
                                    ->label('النتيجة طبيعية؟')
                                    ->inline(false)
                                    ->default(true)
                                    ->columnSpan(1),

                                TextInput::make('previous_value')
                                    ->label('القيمة السابقة')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->placeholder('سيتم جلبها تلقائياً')
                                    ->helperText('القيمة من الزيارة السابقة')
                                    ->columnSpan(1),

                                DatePicker::make('previous_test_date')
                                    ->label('تاريخ التحليل السابق')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->columnSpan(1),

                                Textarea::make('notes')
                                    ->label('ملاحظات')
                                    ->rows(2)
                                    ->placeholder('أي ملاحظات إضافية عن النتيجة...')
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->addActionLabel('+ إضافة نتيجة تحليل')
                            ->collapsible()
                            ->itemLabel(function (array $state): ?string {
                                if (!isset($state['lab_test_id'])) {
                                    return 'نتيجة تحليل';
                                }
                                $labTest = LabTest::find($state['lab_test_id']);
                                $result = $state['result_value'] ?? '';
                                $unit = $state['unit'] ?? '';
                                $status = isset($state['is_normal']) ? ($state['is_normal'] ? '✅' : '⚠️') : '';

                                return $labTest?->name_ar . ' ' . $status . ($result ? " - {$result} {$unit}" : '');
                            })
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
