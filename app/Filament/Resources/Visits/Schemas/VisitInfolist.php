<?php

namespace App\Filament\Resources\Visits\Schemas;

use App\Models\Visit;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('patient_id')
                    ->label('رقم المريض')
                    ->numeric(),
                TextEntry::make('visit_number')
                    ->label('رقم الزيارة')
                    ->numeric(),
                TextEntry::make('visit_date')
                    ->label('تاريخ الزيارة')
                    ->date(),
                TextEntry::make('visit_type')
                    ->label('نوع الزيارة')
                    ->badge(),
                TextEntry::make('chief_complaint')
                    ->label('الشكوى الرئيسية')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('associated_symptoms')
                    ->label('الأعراض المصاحبة')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('evolution')
                    ->label('تطور الشكوى')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('triggers')
                    ->label('المحفزات')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('severity')
                    ->label('شدة الأعراض')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('vital_signs')
                    ->label('العلامات الحيوية')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('physical_examination')
                    ->label('الفحص السريري')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('current_medications')
                    ->label('الأدوية الحالية')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('previous_surgeries')
                    ->label('العمليات الجراحية السابقة')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('radiology_findings')
                    ->label('نتائج الأشعة')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('endoscopy_findings')
                    ->label('نتائج المناظير')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('proposed_treatment')
                    ->label('العلاج المقترح')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('requested_investigations')
                    ->label('التحاويل المطلوبة')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('general_condition')
                    ->label('الحالة العامة')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('diagnosis')
                    ->label('التشخيص')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('prescription')
                    ->label('الروشتة / الوصفة الطبية')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('next_visit_date')
                    ->label('تاريخ الزيارة القادمة')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('doctor_notes')
                    ->label('ملاحظات الطبيب')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_completed')
                    ->label('مكتملة')
                    ->boolean(),
                TextEntry::make('created_by')
                    ->label('أنشئت بواسطة')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->label('تم التحديث بواسطة')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('تاريخ الحذف')
                    ->dateTime()
                    ->visible(fn(Visit $record): bool => $record->trashed()),
            ]);
    }
}
