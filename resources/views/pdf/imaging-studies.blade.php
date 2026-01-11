<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الأشعة المطلوبة - {{ $patient->full_name }}</title>
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
            border-bottom: 2px solid #f97316;
        }

        .logo-space {
            min-height: 50px;
            margin-bottom: 8px;
            background: #fff7ed;
            border-radius: 5px;
            text-align: center;
            padding: 15px;
            font-size: 10px;
            color: #6b7280;
        }

        .header h1 {
            font-size: 18px;
            color: #c2410c;
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
            border-right: 3px solid #f97316;
        }

        .patient-info h2 {
            font-size: 13px;
            color: #c2410c;
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

        .imaging-section h2 {
            font-size: 14px;
            color: #ea580c;
            margin-bottom: 10px;
            padding: 6px 10px;
            background: #fff7ed;
            border-right: 3px solid #f97316;
            border-radius: 3px;
        }

        .imaging-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            border-right: 2px solid #fb923c;
            page-break-inside: avoid;
        }

        .imaging-header {
            font-size: 13px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px dashed #d1d5db;
        }

        .imaging-number {
            display: inline-block;
            background: #f97316;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 11px;
            margin-left: 5px;
        }

        .imaging-name {
            color: #c2410c;
        }

        .imaging-type {
            color: #ea580c;
            font-size: 11px;
            background: #ffedd5;
            padding: 1px 6px;
            border-radius: 3px;
        }

        .imaging-body-part {
            color: #6b7280;
            font-size: 11px;
            font-style: italic;
        }

        .imaging-notes {
            margin-top: 8px;
            padding: 6px 8px;
            background: #fffbeb;
            border-right: 2px solid #f59e0b;
            border-radius: 3px;
        }

        .imaging-notes-label {
            font-weight: bold;
            color: #92400e;
            font-size: 11px;
            margin-bottom: 3px;
        }

        .imaging-notes-content {
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
        <h1>الأشعة المطلوبة</h1>
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

    <div class="imaging-section">
        <h2>الأشعة المطلوبة ({{ $imagingStudies->count() }} {{ $imagingStudies->count() == 1 ? 'فحص' : ($imagingStudies->count() == 2 ? 'فحصان' : 'فحوصات') }})</h2>

        @foreach($imagingStudies as $index => $imaging)
        <div class="imaging-item">
            <div class="imaging-header">
                <span class="imaging-number">{{ $index + 1 }}</span>
                <span class="imaging-name">{{ $imaging->name_ar }}</span>

                @php
                    $types = [
                        'x-ray' => 'أشعة عادية',
                        'ct' => 'أشعة مقطعية',
                        'mri' => 'رنين مغناطيسي',
                        'ultrasound' => 'إيكو/سونار',
                        'doppler' => 'دوبلر',
                        'other' => 'أخرى',
                    ];
                @endphp
                <span class="imaging-type">{{ $types[$imaging->type] ?? $imaging->type }}</span>

                @if($imaging->body_part)
                    <span class="imaging-body-part">- {{ $imaging->body_part }}</span>
                @endif

                @if($imaging->abbreviation)
                    <span class="imaging-body-part">({{ $imaging->abbreviation }})</span>
                @endif
            </div>

            @if($imaging->pivot && $imaging->pivot->notes)
            <div class="imaging-notes">
                <div class="imaging-notes-label">📋 ملاحظات وتعليمات:</div>
                <div class="imaging-notes-content">{{ $imaging->pivot->notes }}</div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</body>
</html>
