<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('patient_id')
                    ->label('رقم المريض')
                    ->required()
                    ->numeric(),
                TextInput::make('visit_number')
                    ->label('رقم الزيارة')
                    ->required()
                    ->numeric(),
                DatePicker::make('visit_date')
                    ->label('تاريخ الزيارة')
                    ->required(),
                Select::make('visit_type')
                    ->label('نوع الزيارة')
                    ->options([
                        'first_visit' => 'زيارة أولى',
                        'follow_up' => 'متابعة',
                        'emergency' => 'طوارئ',
                    ])
                    ->default('follow_up')
                    ->required(),
                Textarea::make('chief_complaint')
                    ->label('الشكوى الرئيسية')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('associated_symptoms')
                    ->label('الأعراض المصاحبة')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('evolution')
                    ->label('تطور الشكوى')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('triggers')
                    ->label('المحفزات')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('severity')
                    ->label('شدة الأعراض')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('vital_signs')
                    ->label('العلامات الحيوية')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('physical_examination')
                    ->label('الفحص السريري')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('current_medications')
                    ->label('الأدوية الحالية')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('previous_surgeries')
                    ->label('العمليات الجراحية السابقة')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('radiology_findings')
                    ->label('نتائج الأشعة')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('endoscopy_findings')
                    ->label('نتائج المناظير')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('proposed_treatment')
                    ->label('العلاج المقترح')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('requested_investigations')
                    ->label('التحاويل المطلوبة')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('general_condition')
                    ->label('الحالة العامة')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('diagnosis')
                    ->label('التشخيص')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('prescription')
                    ->label('الروشتة / الوصفة الطبية')
                    ->default(null)
                    ->columnSpanFull(),
                DatePicker::make('next_visit_date')
                    ->label('تاريخ الزيارة القادمة'),
                Textarea::make('doctor_notes')
                    ->label('ملاحظات الطبيب')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_completed')
                    ->label('مكتملة')
                    ->required(),
                TextInput::make('created_by')
                    ->label('أنشئت بواسطة')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->label('تم التحديث بواسطة')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
