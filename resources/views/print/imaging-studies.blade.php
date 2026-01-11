<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأشعة المطلوبة - {{ $patient->full_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #1a202c;
            padding: 20px;
            background: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f97316;
        }

        .logo-space {
            min-height: 70px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 22px;
            color: #c2410c;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            color: #6b7280;
        }

        .patient-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-right: 4px solid #f97316;
        }

        .patient-info h2 {
            font-size: 15px;
            color: #c2410c;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #d1d5db;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .info-item {
            display: flex;
            gap: 6px;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            min-width: 90px;
        }

        .info-value {
            color: #6b7280;
        }

        .imaging-section {
            margin-bottom: 20px;
        }

        .imaging-section h2 {
            font-size: 16px;
            color: #ea580c;
            margin-bottom: 12px;
            padding: 8px 12px;
            background: linear-gradient(to left, #fff7ed, #ffffff);
            border-right: 4px solid #f97316;
            border-radius: 4px;
        }

        .imaging-item {
            padding: 15px;
            margin-bottom: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            border-right: 3px solid #fb923c;
        }

        .imaging-header {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #d1d5db;
        }

        .imaging-number {
            display: inline-block;
            background: #f97316;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 13px;
            margin-left: 6px;
        }

        .imaging-name {
            color: #c2410c;
            font-weight: 600;
        }

        .imaging-type {
            color: #ea580c;
            font-size: 13px;
            background: #ffedd5;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin: 0 4px;
        }

        .imaging-body-part {
            color: #6b7280;
            font-size: 13px;
            font-style: italic;
        }

        .imaging-notes {
            margin-top: 10px;
            padding: 8px 10px;
            background: #fffbeb;
            border-right: 3px solid #f59e0b;
            border-radius: 4px;
        }

        .imaging-notes-label {
            font-weight: 600;
            color: #92400e;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .imaging-notes-content {
            color: #78350f;
            font-size: 13px;
            line-height: 1.5;
        }

        /* أنماط الطباعة */
        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .header {
                page-break-after: avoid;
            }

            .imaging-item {
                page-break-inside: avoid;
            }

            @page {
                margin: 1.5cm;
            }
        }

        /* زر الطباعة */
        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 12px 24px;
            background: #f97316;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .print-button:hover {
            background: #ea580c;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ طباعة</button>

    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار وزارة الصحة]
        </div>
        <h1>الأشعة المطلوبة</h1>
        <p>{{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }} - {{ now()->format('h:i A') }}</p>
    </div>

    <div class="patient-info">
        <h2>معلومات المريض</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">الاسم الكامل:</span>
                <span class="info-value">{{ $patient->full_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">رقم الملف:</span>
                <span class="info-value">{{ $patient->file_number }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">رقم الهاتف:</span>
                <span class="info-value">{{ $patient->phone_number }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">تاريخ الزيارة:</span>
                <span class="info-value">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->locale('ar')->isoFormat('D MMMM YYYY') : 'غير محدد' }}</span>
            </div>
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

    <script>
        // فتح نافذة الطباعة تلقائياً عند تحميل الصفحة
        window.onload = function() {
            // الانتظار قليلاً للتأكد من تحميل كل شيء
            setTimeout(function() {
                // window.print();
            }, 500);
        };
    </script>
</body>
</html>
