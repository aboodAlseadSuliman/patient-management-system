<?php

namespace App\Filament\Resources\Visits\Schemas\DetailedVisit\InfolistTabs;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class MedicalAttachmentInfoTab
{
    public static function make(): Tab
    {
        return Tab::make('المرفقات والتحاليل')
            ->icon('heroicon-o-document-text')
            ->badge(fn($record) => $record->attachmentFiles()->whereDoesntHave('labTestResults')->count() + $record->labTestResults->count() > 0 ? $record->attachmentFiles()->whereDoesntHave('labTestResults')->count() + $record->labTestResults->count() : null)
            ->badgeColor('success')
            ->schema([

                // ==================== الملفات المرفوعة ====================
                Section::make('الملفات المرفوعة')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->description('صور الأشعة والتقارير الطبية المرفوعة')
                    ->schema([
                        RepeatableEntry::make('attachmentFiles')
                            ->label('')
                            ->getStateUsing(function ($record) {
                                // عرض المرفقات التي ليست مرتبطة بنتائج التحاليل فقط
                                return $record->attachmentFiles()
                                    ->whereDoesntHave('labTestResults')
                                    ->get();
                            })
                            ->schema([
                                Grid::make(6)
                                    ->schema([
                                        TextEntry::make('attachment_name')
                                            ->label('اسم المرفق')
                                            ->default(fn($record) => $record->attachment_type_name)
                                            ->badge()
                                            ->color('success')
                                            ->icon('heroicon-o-document-text')
                                            ->weight('bold')
                                            ->columnSpan(1),

                                        TextEntry::make('attachmentType.category')
                                            ->label('التصنيف')
                                            ->formatStateUsing(fn($state) => match ($state) {
                                                'imaging' => '📷 أشعة وتصوير',
                                                'endoscopy' => '🔬 تنظير',
                                                'pathology' => '🧪 تشريح مرضي',
                                                'other' => '📎 أخرى',
                                                default => $state ?? 'أخرى',
                                            })
                                            ->badge()
                                            ->color(fn($state) => match ($state) {
                                                'imaging' => 'info',
                                                'endoscopy' => 'warning',
                                                'pathology' => 'danger',
                                                'other' => 'gray',
                                                default => 'gray',
                                            })
                                            ->columnSpan(1),

                                        TextEntry::make('file_path')
                                            ->label('الملف')
                                            ->formatStateUsing(function($state, $record) {
                                                // تشفير المسار لدعم الأسماء العربية
                                                $pathParts = explode('/', $state);
                                                $encodedParts = array_map('rawurlencode', $pathParts);
                                                $encodedPath = implode('/', $encodedParts);

                                                return '<a href="' . asset('medical-attachments/' . $encodedPath) . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                                    </svg>
                                                    تحميل - ' . htmlspecialchars($record->original_filename) . ' (' . $record->formatted_file_size . ')
                                                </a>';
                                            })
                                            ->html()
                                            ->columnSpan(1),

                                        TextEntry::make('created_at')
                                            ->label('تاريخ الرفع')
                                            ->dateTime('d/m/Y H:i')
                                            ->badge()
                                            ->color('gray')
                                            ->columnSpan(1),

                                        TextEntry::make('notes')
                                            ->label('📝 النتيجة')
                                            ->markdown()
                                            ->placeholder('لا توجد ملاحظات')
                                            ->columnSpan(2),
                                    ]),


                            ])
                            ->columns(1)
                            ->contained(false),
                    ])
                    ->collapsed(false)
                    ->visible(fn($record) => $record->attachmentFiles()->whereDoesntHave('labTestResults')->count() > 0)
                    ->collapsible(),

                // ==================== نتائج التحاليل المخبرية ====================
                Section::make('نتائج التحاليل المخبرية')
                    ->icon('heroicon-o-beaker')
                    ->description('نتائج التحاليل المخبرية المسجلة')
                    ->schema([
                        RepeatableEntry::make('labTestResults')
                            ->label('')
                            ->schema([
                                Grid::make(6)
                                    ->schema([
                                        TextEntry::make('labTest.name_ar')
                                            ->label('اسم التحليل')
                                            ->badge()
                                            ->color('primary')
                                            ->icon('heroicon-o-beaker')
                                            ->weight('bold')
                                            ->columnSpan(1),

                                        TextEntry::make('test_date')
                                            ->label('تاريخ التحليل')
                                            ->date('d/m/Y')
                                            ->badge()
                                            ->color('gray')
                                            ->icon('heroicon-o-calendar')
                                            ->columnSpan(1),

                                        TextEntry::make('result_value')
                                            ->label('النتيجة')
                                            ->formatStateUsing(fn($state, $record) => $state . ($record->unit ? ' ' . $record->unit : ''))
                                            ->badge()
                                            ->color('info')
                                            ->weight('bold')
                                            ->size('lg')
                                            ->columnSpan(1),

                                        TextEntry::make('reference_range')
                                            ->label('المجال الطبيعي')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),

                                        IconEntry::make('is_normal')
                                            ->label('الحالة')
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-exclamation-triangle')
                                            ->trueColor('success')
                                            ->falseColor('warning')
                                            ->columnSpan(1),

                                        TextEntry::make('attachmentFile.file_path')
                                            ->label('الصورة')
                                            ->formatStateUsing(function($state, $record) {
                                                if (!$state) {
                                                    return '<span class="text-gray-400">لا توجد صورة</span>';
                                                }

                                                // تشفير المسار لدعم الأسماء العربية
                                                $pathParts = explode('/', $state);
                                                $encodedParts = array_map('rawurlencode', $pathParts);
                                                $encodedPath = implode('/', $encodedParts);

                                                return '<a href="' . asset('medical-attachments/' . $encodedPath) . '" target="_blank" class="text-primary-600 hover:underline flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    عرض الصورة
                                                </a>';
                                            })
                                            ->html()
                                            ->columnSpan(1),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('previous_value')
                                            ->label('القيمة السابقة')
                                            ->formatStateUsing(fn($state, $record) => $state ? $state . ($record->unit ? ' ' . $record->unit : '') : 'لا توجد')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),

                                        TextEntry::make('previous_test_date')
                                            ->label('تاريخ التحليل السابق')
                                            ->date('d/m/Y')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-')
                                            ->columnSpan(1),
                                    ]),

                                TextEntry::make('notes')
                                    ->label('📝 ملاحظات')
                                    ->markdown()
                                    ->placeholder('لا توجد ملاحظات')
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->contained(false),
                    ])
                    ->collapsed(false)
                    ->visible(fn($record) => $record->labTestResults->count() > 0)
                    ->collapsible(),
            ]);
    }
}
