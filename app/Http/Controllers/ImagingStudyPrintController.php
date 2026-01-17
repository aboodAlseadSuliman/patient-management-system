<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class ImagingStudyPrintController extends Controller
{
    public function print(Visit $visit)
    {
        // تحميل بيانات المريض والطبيب
        $visit->load(['patient', 'creator']);

        // جلب طلبات الأشعة من visit_imaging_studies مع attachment_types
        $imagingStudies = \DB::table('visit_imaging_studies')
            ->join('attachment_types', 'visit_imaging_studies.attachment_type_id', '=', 'attachment_types.id')
            ->where('visit_imaging_studies.visit_id', $visit->id)
            ->select(
                'attachment_types.name_ar',
                'attachment_types.name_en',
                'attachment_types.icon',
                'visit_imaging_studies.notes',
                'visit_imaging_studies.created_at'
            )
            ->get();

        return view('print.imaging-studies', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'doctor' => $visit->creator,
            'imagingStudies' => $imagingStudies,
        ]);
    }
}
