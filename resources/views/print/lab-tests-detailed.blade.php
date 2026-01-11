<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحاليل المطلوبة - {{ $patient->full_name }}</title>
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
            border-bottom: 3px solid #2563eb;
        }

        .logo-space {
            min-height: 70px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 22px;
            color: #1e3a8a;
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
            border-right: 4px solid #2563eb;
        }

        .patient-info h2 {
            font-size: 15px;
            color: #1e3a8a;
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

        .tests-section {
            margin-bottom: 20px;
        }

        .tests-section h2 {
            font-size: 16px;
            color: #1e40af;
            margin-bottom: 12px;
            padding: 8px 12px;
            background: linear-gradient(to left, #eff6ff, #ffffff);
            border-right: 4px solid #2563eb;
            border-radius: 4px;
        }

        .test-list {
            counter-reset: test-counter;
        }

        .test-item {
            counter-increment: test-counter;
            padding: 10px 35px 10px 12px;
            margin-bottom: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            border-right: 3px solid #3b82f6;
            position: relative;
        }

        .test-item::before {
            content: counter(test-counter);
            position: absolute;
            right: 8px;
            top: 10px;
            background: #2563eb;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-weight: bold;
            font-size: 12px;
        }

        .test-header {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            /* margin-right: 25px; */
        }

        .test-abbr {
            color: #2563eb;
            font-weight: 500;
        }

        .test-name-en {
            color: #6b7280;
            font-size: 13px;
            font-style: italic;
            margin-top: 2px;
        }

        .test-notes {
            margin-top: 8px;
            padding: 8px 10px;
            background: #fffbeb;
            border-right: 3px solid #f59e0b;
            border-radius: 4px;
        }

        .test-notes-label {
            font-weight: 600;
            color: #92400e;
            font-size: 13px;
        }

        .test-notes-content {
            color: #78350f;
            margin-top: 3px;
            font-size: 13px;
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

            .test-item {
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
            background: #2563eb;
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
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ طباعة</button>

    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار وزارة الصحة]
        </div>
        <h1>التحاليل المخبرية المطلوبة (تفصيلية)</h1>
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

    <div class="tests-section">
        <h2>التحاليل المطلوبة ({{ $labTests->count() }} {{ $labTests->count() == 1 ? 'تحليل' : 'تحاليل' }})</h2>

        <div class="test-list">
            @foreach($labTests as $index => $labTest)
            <div class="test-item">
                <div class="test-header">
                    {{ $labTest->name_ar }}
                @if($labTest->abbreviation)
                    <span class="test-abbr">({{ $labTest->abbreviation }})</span>
                @endif
            </div>
            @if($labTest->name_en)
                <div class="test-name-en">{{ $labTest->name_en }}</div>
            @endif

            @if($labTest->pivot && $labTest->pivot->notes)
            <div class="test-notes">
                <div class="test-notes-label">📋 التعليمات والملاحظات:</div>
                <div class="test-notes-content">{{ $labTest->pivot->notes }}</div>
            </div>
            @endif
            </div>
            @endforeach
        </div>
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
