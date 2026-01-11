<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة التحاليل المطلوبة - {{ $patient->full_name }}</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            font-size: 15px;
            line-height: 1.8;
            color: #1a202c;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 18px;
            border-bottom: 3px solid #10b981;
        }

        .logo-space {
            min-height: 75px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 26px;
            color: #065f46;
            margin-bottom: 6px;
        }

        .header p {
            font-size: 13px;
            color: #6b7280;
        }

        .patient-info {
            background: #f9fafb;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-right: 4px solid #10b981;
        }

        .patient-info h2 {
            font-size: 16px;
            color: #065f46;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #d1d5db;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .info-item {
            display: flex;
            gap: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            min-width: 100px;
        }

        .info-value {
            color: #6b7280;
        }

        .tests-section {
            margin-bottom: 25px;
        }

        .tests-section h2 {
            font-size: 18px;
            color: #059669;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: linear-gradient(to left, #ecfdf5, #ffffff);
            border-right: 4px solid #10b981;
            border-radius: 4px;
        }

        .test-list {
            counter-reset: test-counter;
        }

        .test-item {
            counter-increment: test-counter;
            padding: 12px 15px;
            margin-bottom: 8px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            position: relative;
        }

        .test-item::before {
            content: counter(test-counter);
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            background: #10b981;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 13px;
        }

        .test-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-right: 35px;
        }

        .test-abbr {
            color: #059669;
            font-weight: 500;
        }

        .test-name-en {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
        }

        .notes-section {
            margin-top: 25px;
            padding: 15px;
            background: #fffbeb;
            border: 2px dashed #f59e0b;
            border-radius: 8px;
        }

        .notes-section h3 {
            font-size: 16px;
            color: #b45309;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notes-content {
            color: #78350f;
            line-height: 1.7;
            font-size: 14px;
            white-space: pre-wrap;
        }

        .footer {
            margin-top: 35px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }

        .checkbox-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 15px;
        }

        .checkbox {
            width: 16px;
            height: 16px;
            border: 2px solid #10b981;
            display: inline-block;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار وزارة الصحة]
        </div>
        <h1>قائمة التحاليل المخبرية المطلوبة</h1>
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
            @foreach($labTests as $labTest)
            <div class="test-item">
                <div class="test-name">
                    {{ $labTest->name_ar }}
                    @if($labTest->abbreviation)
                        <span class="test-abbr">({{ $labTest->abbreviation }})</span>
                    @endif
                </div>
                @if($labTest->name_en)
                    <div class="test-name-en">{{ $labTest->name_en }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    @if($visit->treatmentPlan && $visit->treatmentPlan->lab_tests_simple_notes)
    <div class="notes-section">
        <h3>
            <span>📋</span>
            <span>الملاحظات والتعليمات العامة</span>
        </h3>
        <div class="notes-content">{{ $visit->treatmentPlan->lab_tests_simple_notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p>تم إنشاء هذا المستند تلقائياً من نظام إدارة المرضى</p>
        <p>{{ config('app.name') }}</p>
    </div>
</body>
</html>
