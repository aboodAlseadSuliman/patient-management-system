@push('styles')
<link rel="stylesheet" href="{{ asset('css/patient-view.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@vite(['resources/css/app.css'])
@endpush

<x-filament-panels::page>
    @php
    $patient = $this->record;
    @endphp



    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        {{-- جدول المريض - 3 أعمدة --}}
        <div class="lg:col-span-4">
            <div class="info-section mt-4">
                <div class="section-title">
                    <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    بيانات المريض الكاملة
                </div>

                <div class="overflow-x-auto">
                    <table class="patient-info-table">
                        <thead>
                            <tr>
                                <th> رقم الملف </th>
                                <th> الاسم الكامل </th>
                                <th>رقم الهوية</th>
                                <th> الجنس </th>
                                <th>سنة الميلاد</th>
                                <th> العمر </th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="stat-value text-blue">
                                    {{ $patient->file_number }}
                                </td>
                                <td class="stat-value text-orange"> {{ $patient->full_name }}
                                </td>
                                <td>{{ $patient->national_id ?? '-' }}</td>
                                <td class="stat-value text-orange"> {{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}

                                </td>
                                <td class="stat-value text-blue">
                                    {{ $patient->birth_year ?? ($patient->date_of_birth?->format('Y') ?? '-') }}
                                </td>
                                <td class="stat-value text-green">
                                    {{ $patient->age_display ?? '-' }}
                                </td>
                                <td>
                                    @if($patient->is_active)
                                    <span
                                        class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        نشط
                                    </span>
                                    @else
                                    <span
                                        class="status-badge bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        غير نشط
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>رقم الجوال</th>
                                <th>البلد</th>
                                <th>المحافظة</th>
                                <th>الحي/القرية</th>
                                <th>المهنة</th>
                                <th>الطبيب المحول</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                            <tr>
                                <td>{{ $patient->phone ?? '-' }}</td>
                                <td>{{ $patient->country ?? '-' }}</td>
                                <td>{{ $patient->province ?? '-' }}</td>
                                <td>{{ $patient->neighborhood ?? '-' }}</td>
                                <td>{{ $patient->occupation ?? '-' }}</td>
                                <td>
                                    @if($patient->referringDoctor)
                                    <span
                                        class="stat-value text-orange">{{ $patient->referringDoctor->full_name }}</span>
                                    @if($patient->referringDoctor->specialty)
                                    <br><span
                                        class="text-xs text-gray-500">{{ $patient->referringDoctor->specialty }}</span>
                                    @endif
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $patient->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- الملاحظات إن وجدت --}}
                @if($patient->notes)
                <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-yellow-50 dark:bg-yellow-900/10">
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">ملاحظات:</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $patient->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- الإحصائيات --}}

        <div class="lg:col-span-4 ">
            <div class="info-section mt-4">
                <div class="section-title">
                    <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    إحصائيات
                </div>

                <div class="overflow-x-auto">
                    <table class="patient-info-table">
                        <thead>
                            <tr>
                                <th> إجمالي الزيارات </th>
                                <th> معاينات المشفى </th>
                                <th> إجراءات التنظير </th>
                                <th> الأمراض المزمنة </th>
                                <th> الأدوية الدائمة </th>
                                <th> آخر زيارة </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="stat-value text-blue">
                                    {{ $patient->visits()->count() }}
                                </td>
                                <td class="stat-value text-green">
                                    {{ $patient->hospitalConsultations()->count() }}
                                </td>
                                <td class="stat-value text-purple">
                                    {{ $patient->endoscopyProcedures()->count() }}
                                </td>
                                <td class="stat-value text-orange">
                                    {{ $patient->activeChronicDiseases()->count() }}
                                </td>
                                <td class="stat-value text-green">
                                    {{ $patient->activePermanentMedications()->count() }}
                                </td>
                                <td>
                                    {{ $patient->visits()->latest('visit_date')->first()?->visit_date?->format('Y-m-d') ?? 'لا توجد' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- بعد جدول الإحصائيات --}}
        {{-- ==================== الأمراض المزمنة ==================== --}}
        <div class="lg:col-span-4 mt-4">
            <div class="info-section">
                <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span>🩺 الأمراض المزمنة ({{ $patient->activeChronicDiseases()->count() }})</span>
                    </div>

                    {{ ($this->addChronicDiseaseAction)(['patient_id' => $patient->id]) }}
                </div>

                <div class="overflow-x-auto">
                    <table class="patient-info-table">
                        <thead>
                            <tr>
                                <th>المرض</th>
                                <th>تاريخ التشخيص</th>
                                <th>ملاحظات</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->activeChronicDiseases as $disease)
                            <tr>
                                <td class="stat-value text-blue">{{ $disease->name_ar }}</td>
                                <td>
                                    @php
                                    $date = $disease->pivot->diagnosis_date;
                                    if ($date) {
                                    echo is_string($date) ? $date : $date->format('Y-m-d');
                                    } else {
                                    echo '-';
                                    }
                                    @endphp
                                </td>
                                <td>{{ Str::limit($disease->pivot->notes, 40) ?? '-' }}</td>
                                <td>
                                    @if($disease->pivot->is_active)
                                    <span
                                        class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">نشط</span>
                                    @else
                                    <span
                                        class="status-badge bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">غير
                                        نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <button wire:click="deleteChronicDisease({{ $disease->id }})"
                                            wire:confirm="هل أنت متأكد من الحذف؟" class="visit-action-btn"
                                            style="padding: 0.25rem 0.5rem; color: #dc2626; border-color: #fca5a5;">
                                            حذف
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem; color: #6b7280;">
                                    لا توجد أمراض مزمنة مسجلة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ==================== الأدوية الدائمة ==================== --}}
        <div class="lg:col-span-4 mt-4">
            <div class="info-section">
                <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <span>💊 الأدوية الدائمة ({{ $patient->activePermanentMedications()->count() }})</span>
                    </div>

                    {{ ($this->addPermanentMedicationAction)(['patient_id' => $patient->id]) }}
                </div>

                <div class="overflow-x-auto">
                    <table class="patient-info-table">
                        <thead>
                            <tr>
                                <th>الدواء</th>
                                <th>الجرعة</th>
                                <th>التكرار</th>
                                <th>الطريق</th>
                                <th>تاريخ البدء</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->activePermanentMedications as $medication)
                            <tr>
                                <td class="stat-value text-orange">{{ $medication->name_ar }}</td>
                                <td>{{ $medication->pivot->dosage ?? '-' }}</td>
                                <td>{{ $medication->pivot->frequency ?? '-' }}</td>
                                <td>
                                    @php
                                    $route = $medication->pivot->route;
                                    echo match($route) {
                                    'oral' => 'فموي',
                                    'injection' => 'حقن',
                                    'topical' => 'موضعي',
                                    'inhalation' => 'استنشاق',
                                    'rectal' => 'شرجي',
                                    'sublingual' => 'تحت اللسان',
                                    'transdermal' => 'عبر الجلد',
                                    default => $route ?? '-',
                                    };
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    $date = $medication->pivot->start_date;
                                    if ($date) {
                                    echo is_string($date) ? $date : $date->format('Y-m-d');
                                    } else {
                                    echo '-';
                                    }
                                    @endphp
                                </td>
                                <td>
                                    @if($medication->pivot->is_active)
                                    <span
                                        class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">نشط</span>
                                    @else
                                    <span
                                        class="status-badge bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">موقوف</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <button wire:click="deletePermanentMedication({{ $medication->id }})"
                                            wire:confirm="هل أنت متأكد من الحذف؟" class="visit-action-btn"
                                            style="padding: 0.25rem 0.5rem; color: #dc2626; border-color: #fca5a5;">
                                            حذف
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                                    لا توجد أدوية دائمة مسجلة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    {{-- أسفل معلومات المريض مباشرة --}}

    <div class="mt-4 info-section">
        <div class="section-title flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                زيارات المريض ({{ $patient->visits()->count() }})
            </div>

            {{-- زر محسّن بألوان Tailwind المباشرة --}}
            <a href="{{ route('filament.admin.resources.visits.create', ['patient_id' => $patient->id]) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                زيارة جديدة
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="patient-info-table">
                <thead>
                    <tr>
                        <th>رقم الزيارة</th>
                        <th>التاريخ</th>
                        <th>النوع</th>
                        <th>الشكوى</th>
                        <th>التشخيص</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patient->visits()->latest('visit_date')->limit(5)->get() as $visit)
                    <tr>
                        <td class="font-semibold text-blue-600 dark:text-blue-400">
                            #{{ $visit->visit_number }}
                        </td>
                        <td>{{ $visit->visit_date?->format('Y-m-d') }}</td>
                        <td>
                            <span
                                class="status-badge {{ $visit->visit_type === 'first' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($visit->visit_type === 'followup' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                {{ $visit->visit_type === 'first' ? 'أولى' : ($visit->visit_type === 'followup' ? 'متابعة' : 'طوارئ') }}
                            </span>
                        </td>
                        <td class="text-right">{{ Str::limit($visit->chief_complaint, 40) ?? '-' }}</td>
                        <td class="text-right">{{ Str::limit($visit->diagnosis, 40) ?? '-' }}</td>
                        <td>
                            @if($visit->is_completed)
                            <span
                                class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                مكتملة
                            </span>
                            @else
                            <span
                                class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                قيد المعالجة
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('filament.admin.resources.visits.view', $visit) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 border border-blue-300 hover:border-blue-400 dark:border-blue-700 dark:hover:border-blue-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    عرض
                                </a>
                                <a href="{{ route('filament.admin.resources.visits.edit', $visit) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 border border-orange-300 hover:border-orange-400 dark:border-orange-700 dark:hover:border-orange-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    تعديل
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد زيارات لهذا المريض</p>
                                <a href="{{ route('filament.admin.resources.visits.create', ['patient_id' => $patient->id]) }}"
                                    class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    إضافة أول زيارة
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patient->visits()->count() > 5)
        <div class="p-3 text-center border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <a href="{{ route('filament.admin.resources.visits.index', ['tableFilters[patient_id][value]' => $patient->id]) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                عرض جميع الزيارات ({{ $patient->visits()->count() }})
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @endif
    </div>

    {{-- ==================== معاينات المشفى ==================== --}}
    <div class="mt-4 info-section">
        <div class="section-title flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                معاينات المشفى ({{ $patient->hospitalConsultations()->count() }})
            </div>

            <a href="{{ route('filament.admin.resources.hospital-consultations.create', ['patient_id' => $patient->id]) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                معاينة جديدة
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="patient-info-table">
                <thead>
                    <tr>
                        <th>الرقم المتسلسل</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>المشفى</th>
                        <th>المصدر</th>
                        <th>التشخيص الأولي</th>
                        <th>حالة المتابعة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patient->hospitalConsultations()->latest('consultation_date')->limit(5)->get() as $consultation)
                    <tr>
                        <td class="font-semibold text-green-600 dark:text-green-400">
                            {{ $consultation->sequential_number }}
                        </td>
                        <td>{{ $consultation->consultation_date?->format('Y-m-d') }}</td>
                        <td class="stat-value text-orange">{{ $consultation->day_of_week }}</td>
                        <td>{{ $consultation->hospital?->name_ar ?? '-' }}</td>
                        <td>
                            <span class="status-badge {{ $consultation->source === 'hospital' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : ($consultation->source === 'consultation' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400') }}">
                                {{ $consultation->source === 'hospital' ? 'مشفى' : ($consultation->source === 'consultation' ? 'استشارة' : 'خاص') }}
                            </span>
                        </td>
                        <td class="text-right">{{ Str::limit($consultation->preliminaryDiagnosis?->name_ar, 30) ?? '-' }}</td>
                        <td>
                            @if($consultation->follow_up_status === 'cured')
                            <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">شفاء</span>
                            @elseif($consultation->follow_up_status === 'ongoing')
                            <span class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">مستمر</span>
                            @elseif($consultation->follow_up_status === 'deceased')
                            <span class="status-badge bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">وفاة</span>
                            @else
                            <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('filament.admin.resources.hospital-consultations.view', $consultation) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 border border-blue-300 hover:border-blue-400 dark:border-blue-700 dark:hover:border-blue-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    عرض
                                </a>
                                <a href="{{ route('filament.admin.resources.hospital-consultations.edit', $consultation) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 border border-orange-300 hover:border-orange-400 dark:border-orange-700 dark:hover:border-orange-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    تعديل
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد معاينات مشفى لهذا المريض</p>
                                <a href="{{ route('filament.admin.resources.hospital-consultations.create', ['patient_id' => $patient->id]) }}"
                                    class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    إضافة أول معاينة
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patient->hospitalConsultations()->count() > 5)
        <div class="p-3 text-center border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <a href="{{ route('filament.admin.resources.hospital-consultations.index', ['tableFilters[patient_id][value]' => $patient->id]) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                عرض جميع المعاينات ({{ $patient->hospitalConsultations()->count() }})
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @endif
    </div>

    {{-- ==================== إجراءات التنظير ==================== --}}
    <div class="mt-4 info-section">
        <div class="section-title flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                إجراءات التنظير ({{ $patient->endoscopyProcedures()->count() }})
            </div>

            <a href="{{ route('filament.admin.resources.endoscopy-procedures.create', ['patient_id' => $patient->id]) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إجراء جديد
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="patient-info-table">
                <thead>
                    <tr>
                        <th>الرقم المتسلسل</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>المشفى</th>
                        <th>نوع القبول</th>
                        <th>نوع الإجراء</th>
                        <th>الاستطباب</th>
                        <th>حالة المتابعة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patient->endoscopyProcedures()->latest('procedure_date')->limit(5)->get() as $procedure)
                    <tr>
                        <td class="font-semibold text-purple-600 dark:text-purple-400">
                            {{ $procedure->sequential_number }}
                        </td>
                        <td>{{ $procedure->procedure_date?->format('Y-m-d') }}</td>
                        <td class="stat-value text-orange">{{ $procedure->day_of_week }}</td>
                        <td>{{ $procedure->hospital?->name_ar ?? '-' }}</td>
                        <td>
                            <span class="status-badge {{ $procedure->admission_type === 'internal' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' }}">
                                {{ $procedure->admission_type === 'internal' ? 'داخلي' : 'خارجي' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $procedure->procedure_type === 'upper' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($procedure->procedure_type === 'lower' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400') }}">
                                {{ $procedure->procedure_type === 'upper' ? 'تنظير علوي' : ($procedure->procedure_type === 'lower' ? 'تنظير سفلي' : 'خزعة موجهة') }}
                            </span>
                        </td>
                        <td class="text-right">{{ Str::limit($procedure->indication?->name_ar, 30) ?? '-' }}</td>
                        <td>
                            @if($procedure->follow_up_status === 'completed')
                            <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">انتهى</span>
                            @elseif($procedure->follow_up_status === 'ongoing')
                            <span class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">مستمر</span>
                            @else
                            <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('filament.admin.resources.endoscopy-procedures.view', $procedure) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 border border-blue-300 hover:border-blue-400 dark:border-blue-700 dark:hover:border-blue-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    عرض
                                </a>
                                <a href="{{ route('filament.admin.resources.endoscopy-procedures.edit', $procedure) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 border border-orange-300 hover:border-orange-400 dark:border-orange-700 dark:hover:border-orange-600 rounded-md transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    تعديل
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-8">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد إجراءات تنظير لهذا المريض</p>
                                <a href="{{ route('filament.admin.resources.endoscopy-procedures.create', ['patient_id' => $patient->id]) }}"
                                    class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    إضافة أول إجراء
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patient->endoscopyProcedures()->count() > 5)
        <div class="p-3 text-center border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <a href="{{ route('filament.admin.resources.endoscopy-procedures.index', ['tableFilters[patient_id][value]' => $patient->id]) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300">
                عرض جميع الإجراءات ({{ $patient->endoscopyProcedures()->count() }})
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @endif
    </div>

</x-filament-panels::page>