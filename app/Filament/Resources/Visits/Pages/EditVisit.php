<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditVisit extends EditRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    /**
     * تحميل البيانات من الجداول المرتبطة عند تحرير الزيارة
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $visit = $this->record;

        // تحميل بيانات الشكاية والأعراض
        if ($visit->complaintSymptom) {
            $data['complaintSymptom'] = $visit->complaintSymptom->toArray();
        }

        // تحميل بيانات الخط الزمني
        if ($visit->timeline) {
            $data['timeline'] = $visit->timeline->toArray();
        }

        // تحميل بيانات المرفقات الطبية
        if ($visit->medicalAttachment) {
            $data['medicalAttachment'] = $visit->medicalAttachment->toArray();
        }

        // تحميل بيانات الفحص السريري
        if ($visit->clinicalExamination) {
            $data['clinicalExamination'] = $visit->clinicalExamination->toArray();
        }

        // تحميل بيانات خطة العلاج
        if ($visit->treatmentPlan) {
            $data['treatmentPlan'] = $visit->treatmentPlan->toArray();
        }

        // تحميل بيانات المتابعة
        if ($visit->followup) {
            $data['followup'] = $visit->followup->toArray();
        }

        return $data;
    }

    /**
     * حفظ/تحديث البيانات في الجداول المرتبطة بعد تحديث الزيارة
     */
    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $visit = $this->record;

        // تحديث أو إنشاء الشكاية والأعراض
        if (isset($data['complaintSymptom'])) {
            $visit->complaintSymptom()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['complaintSymptom']
            );
        }

        // تحديث أو إنشاء الخط الزمني
        if (isset($data['timeline'])) {
            $visit->timeline()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['timeline']
            );
        }

        // تحديث أو إنشاء المرفقات الطبية
        if (isset($data['medicalAttachment'])) {
            $visit->medicalAttachment()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['medicalAttachment']
            );
        }

        // تحديث أو إنشاء الفحص السريري
        if (isset($data['clinicalExamination'])) {
            $visit->clinicalExamination()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['clinicalExamination']
            );
        }

        // تحديث أو إنشاء خطة العلاج
        if (isset($data['treatmentPlan'])) {
            $visit->treatmentPlan()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['treatmentPlan']
            );
        }

        // تحديث أو إنشاء المتابعة
        if (isset($data['followup'])) {
            $visit->followup()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['followup']
            );
        }
    }
}
