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
                                <th> العمر </th>
                                <th> الجنس </th>
                                <th>تاريخ الميلاد</th>
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
                                <td class="stat-value text-green">
                                    {{ $patient->age_display }}
                                </td>
                                <td class="stat-value text-orange"> {{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}

                                </td>

                                <td>{{ $patient->date_of_birth?->format('Y-m-d') ?? '-' }}</td>
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
                                <th>رقم بديل</th>
                                <th>المدينة</th>
                                <th>المنطقة</th>
                                <th>العنوان</th>
                                <th>أنشأه</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                            <tr>
                                <td>{{ $patient->phone ?? '-' }}</td>
                                <td>{{ $patient->alternative_phone ?? '-' }}</td>
                                <td>{{ $patient->city ?? '-' }}</td>
                                <td>{{ $patient->area ?? '-' }}</td>
                                <td>{{ $patient->address ?? '-' }}</td>
                                <td>{{ $patient->creator?->name ?? '-' }}</td>
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
                                <td class="stat-value text-orange"> {{ $patient->activeChronicDiseases()->count() }}
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


    </div>

    {{-- مساحة للمحتوى الإضافي --}}
    <div class="mt-4 info-section p-4">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">مساحة لمعلومات إضافية</h3>
        <p class="text-xs text-gray-500">هنا يمكنك إضافة الزيارات، الأدوية، أو أي محتوى آخر...</p>
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

</x-filament-panels::page>