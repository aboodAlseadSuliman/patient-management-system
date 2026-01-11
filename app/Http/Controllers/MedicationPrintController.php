<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class MedicationPrintController extends Controller
{
    /**
     * عرض صفحة الطباعة للأدوية
     */
    public function print(Visit $visit)
    {
        // تحميل العلاقات المطلوبة
        $visit->load(['patient', 'medications']);

        // التحقق من وجود أدوية
        if ($visit->medications->isEmpty()) {
            abort(404, 'لا توجد أدوية موصوفة لطباعتها');
        }

        return view('print.medications', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'medications' => $visit->medications,
        ]);
    }
}
