<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحاليل المطلوبة - {{ $patient->full_name }}</title>
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
            font-size: 14px;
            line-height: 1.8;
            color: #1a202c;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }

        .logo-space {
            min-height: 80px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 24px;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 13px;
            color: #64748b;
        }

        .patient-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }

        .patient-info h2 {
            font-size: 16px;
            color: #1e3a8a;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3b82f6;
        }

        .patient-info table {
            width: 100%;
            font-size: 13px;
        }

        .patient-info td {
            padding: 6px 0;
        }

        .patient-info td:first-child {
            font-weight: bold;
            color: #475569;
            width: 30%;
        }

        .lab-tests {
            margin-top: 30px;
        }

        .lab-tests h2 {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 20px;
            padding: 10px;
            background: #eff6ff;
            border-right: 4px solid #3b82f6;
        }

        .test-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 18px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .test-number {
            display: inline-block;
            background: #3b82f6;
            color: white;
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
            margin-left: 12px;
            vertical-align: middle;
        }

        .test-name {
            font-size: 17px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 6px;
            display: inline-block;
            vertical-align: middle;
        }

        .test-abbreviation {
            color: #3b82f6;
            font-weight: bold;
            font-size: 14px;
            margin-right: 6px;
        }

        .test-english {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
            font-style: italic;
            direction: ltr;
            text-align: left;
            padding-right: 44px;
        }

        .test-notes {
            background: #fefce8;
            border-right: 3px solid #eab308;
            padding: 12px;
            margin-top: 12px;
            border-radius: 4px;
        }

        .test-notes-label {
            font-weight: bold;
            color: #a16207;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .test-notes-content {
            color: #713f12;
            font-size: 14px;
            line-height: 2;
            white-space: pre-wrap;
            font-weight: 500;
        }

        .no-notes {
            color: #94a3b8;
            font-style: italic;
            font-size: 12px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 11px;
            color: #64748b;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Header with Logo Space -->
    <div class="header">
        <div class="logo-space">
            مساحة مخصصة لشعار وزارة الصحة أو العيادة
        </div>
        <h1>التحاليل المخبرية المطلوبة</h1>
        <p>تاريخ الإصدار: {{ now()->locale('ar')->translatedFormat('l، j F Y') }}</p>
    </div>

    <!-- Patient Information -->
    <div class="patient-info">
        <h2>معلومات المريض</h2>
        <table>
            <tr>
                <td>الاسم الكامل:</td>
                <td>{{ $patient->full_name }}</td>
            </tr>
            <tr>
                <td>رقم الملف:</td>
                <td>{{ $patient->file_number }}</td>
            </tr>
            <tr>
                <td>رقم الهاتف:</td>
                <td>{{ $patient->phone ?? 'غير محدد' }}</td>
            </tr>
            <tr>
                <td>تاريخ الزيارة:</td>
                <td>{{ $visit->visit_date?->locale('ar')->translatedFormat('j F Y') ?? 'غير محدد' }}</td>
            </tr>
        </table>
    </div>

    <!-- Lab Tests List -->
    <div class="lab-tests">
        <h2>قائمة التحاليل المطلوبة ({{ $labTests->count() }} تحليل)</h2>

        @foreach($labTests as $index => $labTest)
        <div class="test-item">
            <div style="margin-bottom: 8px;">
                <span class="test-number">{{ $index + 1 }}</span>
                <span class="test-name">{{ $labTest->name_ar }}</span>
                @if($labTest->abbreviation)
                <span class="test-abbreviation">({{ $labTest->abbreviation }})</span>
                @endif
            </div>

            @if($labTest->name_en)
            <div class="test-english">{{ $labTest->name_en }}</div>
            @endif

            @if($labTest->pivot && $labTest->pivot->notes)
            <div class="test-notes">
                <div class="test-notes-label">📋 التعليمات والملاحظات:</div>
                <div class="test-notes-content">{{ $labTest->pivot->notes }}</div>
            </div>
            @else
            <div class="test-notes" style="background: #f8fafc; border-right-color: #cbd5e1;">
                <div class="no-notes">لا توجد تعليمات خاصة</div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>تم إنشاء هذا التقرير بواسطة نظام إدارة العيادة</p>
        <p>{{ config('app.name') }} - {{ now()->year }}</p>
    </div>
</body>

</html>