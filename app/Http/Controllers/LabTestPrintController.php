<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class LabTestPrintController extends Controller
{
    /**
     * طباعة التحاليل بالطريقة التفصيلية
     */
    public function printDetailed(Visit $visit)
    {
        $visit->load(['patient', 'labTests', 'treatmentPlan']);

        // التحقق من وجود تحاليل
        if ($visit->labTests->isEmpty()) {
            abort(404, 'لا توجد تحاليل لطباعتها');
        }

        return view('print.lab-tests-detailed', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'labTests' => $visit->labTests,
        ]);
    }

    /**
     * طباعة التحاليل بالطريقة البسيطة
     */
    public function printSimple(Visit $visit)
    {
        $visit->load(['patient', 'labTests', 'treatmentPlan']);

        // التحقق من وجود تحاليل
        if ($visit->labTests->isEmpty()) {
            abort(404, 'لا توجد تحاليل لطباعتها');
        }

        return view('print.lab-tests-simple', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'labTests' => $visit->labTests,
        ]);
    }
}
