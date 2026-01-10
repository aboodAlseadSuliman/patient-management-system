<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewVisit extends ViewRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportLabTestsPdf')
                ->label('تصدير التحاليل إلى PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->visible(fn () => $this->record->labTests()->exists())
                ->action(function () {
                    return $this->exportLabTestsToPdf();
                }),
            EditAction::make(),
        ];
    }

    protected function exportLabTestsToPdf()
    {
        $visit = $this->record->load(['patient', 'labTests']);

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

        // تحميل المحتوى من Blade
        $html = view('pdf.lab-tests', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'labTests' => $visit->labTests,
        ])->render();

        $mpdf->WriteHTML($html);

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, 'lab-tests-' . $visit->patient->file_number . '-' . now()->format('Y-m-d') . '.pdf');
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
