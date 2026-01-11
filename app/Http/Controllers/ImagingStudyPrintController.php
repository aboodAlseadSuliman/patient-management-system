<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class ImagingStudyPrintController extends Controller
{
    /**
     * عرض صفحة الطباعة للأشعة
     */
    public function print(Visit $visit)
    {
        // تحميل العلاقات المطلوبة
        $visit->load(['patient', 'imagingStudies']);

        // التحقق من وجود أشعة
        if ($visit->imagingStudies->isEmpty()) {
            abort(404, 'لا توجد أشعة مطلوبة لطباعتها');
        }

        return view('print.imaging-studies', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'imagingStudies' => $visit->imagingStudies,
        ]);
    }
}
