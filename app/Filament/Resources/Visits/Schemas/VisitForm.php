<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\PatientVisitInfoTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\ComplaintSymptomTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\TimelineTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\MedicalAttachmentTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\ClinicalExaminationTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\TreatmentPlanTab;
use App\Filament\Resources\Visits\Schemas\DetailedVisit\FollowupTab;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('visit_tabs')
                    ->tabs([
                        // ==================== التبويبات التفصيلية ====================
                        PatientVisitInfoTab::make(),
                        ComplaintSymptomTab::make(),
                        TimelineTab::make(),
                        MedicalAttachmentTab::make(),
                        ClinicalExaminationTab::make(),
                        TreatmentPlanTab::make(),
                        FollowupTab::make(),
                    ])
                    ->persistTabInQueryString('tab')
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }
}