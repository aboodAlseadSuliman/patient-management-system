<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabTestPrintController;

Route::get('/', function () {
    return view('welcome');
});

// مسارات الطباعة المباشرة للتحاليل
Route::middleware(['auth'])->group(function () {
    Route::get('/visits/{visit}/print-lab-tests-detailed', [LabTestPrintController::class, 'printDetailed'])
        ->name('visits.print-lab-tests-detailed');

    Route::get('/visits/{visit}/print-lab-tests-simple', [LabTestPrintController::class, 'printSimple'])
        ->name('visits.print-lab-tests-simple');
});
