<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewVisit extends ViewRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // زر طباعة الطريقة التفصيلية
            Action::make('printDetailedLabTests')
                ->label('طباعة التحاليل المفصلة')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->visible(function () {
                    if (!$this->record->labTests()->exists()) {
                        return false;
                    }

                    $this->record->load('treatmentPlan');
                    $method = $this->record->treatmentPlan?->lab_tests_input_method ?? 'detailed';

                    return $method === 'detailed';
                })
                ->url(fn () => route('visits.print-lab-tests-detailed', $this->record))
                ->openUrlInNewTab(),

            // زر طباعة الطريقة البسيطة
            Action::make('printSimpleLabTests')
                ->label('طباعة قائمة التحاليل')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->visible(function () {
                    if (!$this->record->labTests()->exists()) {
                        return false;
                    }

                    $this->record->load('treatmentPlan');
                    $method = $this->record->treatmentPlan?->lab_tests_input_method ?? 'detailed';

                    return $method === 'simple';
                })
                ->url(fn () => route('visits.print-lab-tests-simple', $this->record))
                ->openUrlInNewTab(),

            // زر تصدير PDF الطريقة التفصيلية
            Action::make('exportDetailedLabTestsPdf')
                ->label('تحميل PDF المفصل')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->visible(function () {
                    if (!$this->record->labTests()->exists()) {
                        return false;
                    }

                    $this->record->load('treatmentPlan');
                    $method = $this->record->treatmentPlan?->lab_tests_input_method ?? 'detailed';

                    return $method === 'detailed';
                })
                ->action(function () {
                    return $this->exportLabTestsToPdf('detailed');
                }),

            // زر تصدير PDF الطريقة البسيطة
            Action::make('exportSimpleLabTestsPdf')
                ->label('تحميل PDF القائمة')
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->visible(function () {
                    if (!$this->record->labTests()->exists()) {
                        return false;
                    }

                    $this->record->load('treatmentPlan');
                    $method = $this->record->treatmentPlan?->lab_tests_input_method ?? 'detailed';

                    return $method === 'simple';
                })
                ->action(function () {
                    return $this->exportLabTestsToPdf('simple');
                }),

            EditAction::make(),
        ];
    }

    protected function exportLabTestsToPdf(string $method = 'detailed')
    {
        $visit = $this->record->load(['patient', 'labTests', 'treatmentPlan']);

        // تحديد Template المناسب
        $template = $method === 'simple' ? 'pdf.lab-tests-simple' : 'pdf.lab-tests';

        // استخدام mPDF بدلاً من dompdf لدعم أفضل للعربية
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'default_font' => 'dejavusans',
        ]);

        // تحميل المحتوى من Blade Template المناسب
        $html = view($template, [
            'visit' => $visit,
            'patient' => $visit->patient,
            'labTests' => $visit->labTests,
        ])->render();

        $mpdf->WriteHTML($html);

        $fileName = $method === 'simple'
            ? 'lab-tests-list-' . $visit->patient->file_number . '-' . now()->format('Y-m-d') . '.pdf'
            : 'lab-tests-detailed-' . $visit->patient->file_number . '-' . now()->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $fileName);
    }

    /**
     * تحميل جميع العلاقات المطلوبة لعرض الزيارة
     */
    protected function resolveRecord(int | string $key): Model
    {
        return static::getResource()::resolveRecordRouteBinding($key)
            ->load([
                'patient',
                'referringDoctor',
                'creator',
                'complaintSymptom',
                'timeline',
                'medicalAttachment',
                'clinicalExamination',
                'treatmentPlan',
                'followup',
                'labTests',
                'preliminaryDiagnoses',
            ]);
    }
}
