<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الأدوية الموصوفة - {{ $patient->full_name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1a202c;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #7c3aed;
        }

        .logo-space {
            min-height: 50px;
            margin-bottom: 8px;
            background: #f5f3ff;
            border-radius: 5px;
            text-align: center;
            padding: 15px;
            font-size: 10px;
            color: #6b7280;
        }

        .header h1 {
            font-size: 18px;
            color: #5b21b6;
            margin: 8px 0;
        }

        .header p {
            font-size: 11px;
            color: #6b7280;
        }

        .patient-info {
            background: #f9fafb;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-right: 3px solid #7c3aed;
        }

        .patient-info h2 {
            font-size: 13px;
            color: #5b21b6;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #d1d5db;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
            display: inline-block;
            width: 100px;
        }

        .info-value {
            color: #6b7280;
        }

        .medications-section h2 {
            font-size: 14px;
            color: #6d28d9;
            margin-bottom: 10px;
            padding: 6px 10px;
            background: #f5f3ff;
            border-right: 3px solid #7c3aed;
            border-radius: 3px;
        }

        .medication-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            border-right: 2px solid #8b5cf6;
            page-break-inside: avoid;
        }

        .medication-header {
            font-size: 13px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px dashed #d1d5db;
        }

        .medication-number {
            display: inline-block;
            background: #7c3aed;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 11px;
            margin-left: 5px;
        }

        .medication-name {
            color: #5b21b6;
        }

        .medication-strength {
            color: #7c3aed;
            font-size: 11px;
        }

        .medication-form {
            color: #6b7280;
            font-size: 11px;
            font-style: italic;
        }

        .medication-details {
            margin-top: 6px;
        }

        .detail-row {
            background: #ffffff;
            padding: 4px 8px;
            margin-bottom: 3px;
            border-radius: 3px;
            border-right: 2px solid #a78bfa;
        }

        .detail-label {
            font-weight: bold;
            color: #6d28d9;
            font-size: 11px;
            display: inline-block;
            min-width: 100px;
        }

        .detail-value {
            color: #4b5563;
            font-size: 11px;
        }

        .medication-notes {
            margin-top: 8px;
            padding: 6px 8px;
            background: #fffbeb;
            border-right: 2px solid #f59e0b;
            border-radius: 3px;
        }

        .medication-notes-label {
            font-weight: bold;
            color: #92400e;
            font-size: 11px;
            margin-bottom: 3px;
        }

        .medication-notes-content {
            color: #78350f;
            font-size: 11px;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار وزارة الصحة]
        </div>
        <h1>الأدوية الموصوفة</h1>
        <p>تاريخ الطباعة: {{ now()->locale('ar')->isoFormat('D MMMM YYYY - h:mm A') }}</p>
    </div>

    <div class="patient-info">
        <h2>معلومات المريض</h2>
        <div class="info-row">
            <span class="info-label">الاسم الكامل:</span>
            <span class="info-value">{{ $patient->full_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">رقم الملف:</span>
            <span class="info-value">{{ $patient->file_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">رقم الهاتف:</span>
            <span class="info-value">{{ $patient->phone_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">تاريخ الزيارة:</span>
            <span class="info-value">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->locale('ar')->isoFormat('D MMMM YYYY') : 'غير محدد' }}</span>
        </div>
    </div>

    <div class="medications-section">
        <h2>الأدوية الموصوفة ({{ $medications->count() }} {{ $medications->count() == 1 ? 'دواء' : ($medications->count() == 2 ? 'دواءان' : 'أدوية') }})</h2>

        @foreach($medications as $index => $medication)
        <div class="medication-item">
            <div class="medication-header">
                <span class="medication-number">{{ $index + 1 }}</span>
                <span class="medication-name">{{ $medication->name_ar }}</span>
                @if($medication->strength)
                    <span class="medication-strength">({{ $medication->strength }})</span>
                @endif
                @if($medication->dosage_form)
                    <span class="medication-form">
                        -
                        @php
                            $forms = [
                                'tablet' => 'حبوب',
                                'capsule' => 'كبسولات',
                                'syrup' => 'شراب',
                                'injection' => 'حقن',
                                'cream' => 'كريم',
                                'ointment' => 'مرهم',
                                'drops' => 'قطرة',
                                'spray' => 'رذاذ',
                                'inhaler' => 'بخاخ',
                                'suppository' => 'تحاميل',
                                'patch' => 'لصقة',
                                'other' => 'أخرى',
                            ];
                        @endphp
                        {{ $forms[$medication->dosage_form] ?? $medication->dosage_form }}
                    </span>
                @endif
            </div>

            <div class="medication-details">
                @if($medication->pivot && $medication->pivot->dosage)
                <div class="detail-row">
                    <span class="detail-label">💊 الجرعة:</span>
                    <span class="detail-value">{{ $medication->pivot->dosage }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->frequency)
                <div class="detail-row">
                    <span class="detail-label">🕐 عدد المرات:</span>
                    <span class="detail-value">{{ $medication->pivot->frequency }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->duration)
                <div class="detail-row">
                    <span class="detail-label">📅 المدة:</span>
                    <span class="detail-value">{{ $medication->pivot->duration }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->instructions)
                <div class="detail-row">
                    <span class="detail-label">⚠️ تعليمات الاستخدام:</span>
                    <span class="detail-value">{{ $medication->pivot->instructions }}</span>
                </div>
                @endif
            </div>

            @if($medication->pivot && $medication->pivot->notes)
            <div class="medication-notes">
                <div class="medication-notes-label">📋 ملاحظات إضافية:</div>
                <div class="medication-notes-content">{{ $medication->pivot->notes }}</div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</body>
</html>
