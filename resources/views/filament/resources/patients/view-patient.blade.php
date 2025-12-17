<x-filament-panels::page>
    @php
    $patient = $this->record;
    @endphp

    {{-- Header Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- رقم الملف --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">رقم الملف</p>
                    <p class="text-2xl font-bold mt-1">{{ $patient->file_number }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-identification class="w-6 h-6" />
                </div>
            </div>
        </div>

        {{-- الجنس --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">الجنس</p>
                    <p class="text-2xl font-bold mt-1">
                        {{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-user class="w-6 h-6" />
                </div>
            </div>
        </div>

        {{-- العمر --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">العمر</p>
                    <p class="text-2xl font-bold mt-1">{{ $patient->age_display }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-calendar class="w-6 h-6" />
                </div>
            </div>
        </div>

        {{-- عدد الزيارات --}}
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">عدد الزيارات</p>
                    <p class="text-2xl font-bold mt-1">{{ $patient->visits()->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-calendar-days class="w-6 h-6" />
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Right Column - Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- معلومات المريض --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-heroicon-o-user-circle class="w-5 h-5 ml-2 text-blue-500" />
                        معلومات المريض
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الاسم الكامل</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                                {{ $patient->full_name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم الهوية</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                {{ $patient->national_id ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الميلاد</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                {{ $patient->date_of_birth?->format('Y-m-d') ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الحالة</dt>
                            <dd class="mt-1">
                                @if($patient->is_active)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <x-heroicon-s-check-circle class="w-4 h-4 ml-1" />
                                    نشط
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    <x-heroicon-s-x-circle class="w-4 h-4 ml-1" />
                                    غير نشط
                                </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- معلومات الاتصال --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-heroicon-o-phone class="w-5 h-5 ml-2 text-green-500" />
                        معلومات الاتصال
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم الجوال</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white flex items-center">
                                <x-heroicon-o-device-phone-mobile class="w-4 h-4 ml-2 text-green-500" />
                                {{ $patient->phone ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم بديل</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white flex items-center">
                                <x-heroicon-o-phone class="w-4 h-4 ml-2 text-blue-500" />
                                {{ $patient->alternative_phone ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">المدينة</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white flex items-center">
                                <x-heroicon-o-map-pin class="w-4 h-4 ml-2 text-red-500" />
                                {{ $patient->city ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">المنطقة / الحي</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                {{ $patient->area ?? '-' }}
                            </dd>
                        </div>

                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">العنوان الكامل</dt>
                            <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                {{ $patient->address ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- الملاحظات --}}
            @if($patient->notes)
            <div
                class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg shadow-sm border border-yellow-200 dark:border-yellow-800">
                <div class="p-6 border-b border-yellow-200 dark:border-yellow-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-heroicon-o-document-text class="w-5 h-5 ml-2 text-yellow-500" />
                        ملاحظات عامة
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $patient->notes }}
                    </p>
                </div>
            </div>
            @endif
        </div>

        {{-- Left Column - Sidebar --}}
        <div class="space-y-6">
            {{-- معلومات النظام --}}
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-heroicon-o-information-circle class="w-5 h-5 ml-2 text-gray-500" />
                        معلومات النظام
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">أنشأه</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $patient->creator?->name ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإنشاء</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $patient->created_at?->format('Y-m-d H:i') ?? '-' }}
                        </dd>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">آخر تحديث بواسطة</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $patient->updater?->name ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ التحديث</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $patient->updated_at?->format('Y-m-d H:i') ?? '-' }}
                        </dd>
                    </div>
                </div>
            </div>

            {{-- إحصائيات سريعة --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-heroicon-o-chart-bar class="w-5 h-5 ml-2 text-blue-500" />
                        إحصائيات سريعة
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">إجمالي الزيارات</span>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            {{ $patient->visits()->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">آخر زيارة</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $patient->visits()->latest('visit_date')->first()?->visit_date?->format('Y-m-d') ?? 'لا توجد' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">الأمراض المزمنة</span>
                        <span class="text-lg font-bold text-orange-600 dark:text-orange-400">
                            {{ $patient->activeChronicDiseases()->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">الأدوية الدائمة</span>
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">
                            {{ $patient->activePermanentMedications()->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>