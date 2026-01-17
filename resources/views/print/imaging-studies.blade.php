<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب أشعة - {{ $patient->full_name }}</title>
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
            border-bottom: 3px solid #10b981;
        }

        .logo-space {
            min-height: 70px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 22px;
            color: #065f46;
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
            border-right: 4px solid #10b981;
        }

        .patient-info h2 {
            font-size: 15px;
            color: #065f46;
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
            color: #2563eb;
            margin-bottom: 12px;
            padding: 8px 12px;
            background: linear-gradient(to left, #eff6ff, #ffffff);
            border-right: 4px solid #3b82f6;
            border-radius: 4px;
        }

        .imaging-list {
            counter-reset: imaging-counter;
        }

        .imaging-item {
            counter-increment: imaging-counter;
            padding: 10px 35px 10px 12px;
            margin-bottom: 6px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            position: relative;
        }

        .imaging-item::before {
            content: counter(imaging-counter);
            position: absolute;
            right: 8px;
            top: 8px;
            background: #3b82f6;
            color: white;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            text-align: center;
            line-height: 26px;
            font-weight: bold;
            font-size: 13px;
        }

        .imaging-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .imaging-icon {
            font-size: 16px;
            margin-left: 4px;
        }

        .imaging-name-en {
            color: #6b7280;
            font-size: 12px;
            font-style: italic;
            margin-top: 2px;
        }

        .notes-section {
            margin-top: 8px;
            padding: 10px;
            background: #fffbeb;
            border: 1px dashed #f59e0b;
            border-radius: 6px;
        }

        .notes-section h3 {
            font-size: 12px;
            color: #b45309;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .notes-content {
            color: #78350f;
            line-height: 1.6;
            font-size: 12px;
            white-space: pre-wrap;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
            background: #f9fafb;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 10px;
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
            background: #3b82f6;
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
            background: #2563eb;
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ طباعة</button>

    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار المركز الطبي]
        </div>
        <h1>طلب أشعة وتصوير طبي</h1>
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
        <h2>الأشعة المطلوبة ({{ $imagingStudies->count() }} {{ $imagingStudies->count() == 1 ? 'أشعة' : 'أشعة' }})</h2>

        @if($imagingStudies->count() > 0)
            <div class="imaging-list">
                @foreach($imagingStudies as $imaging)
                    <div class="imaging-item">
                        <div class="imaging-name">
                            @if($imaging->icon)
                                <span class="imaging-icon">{{ $imaging->icon }}</span>
                            @endif
                            {{ $imaging->name_ar }}
                        </div>
                        @if($imaging->name_en)
                            <div class="imaging-name-en">{{ $imaging->name_en }}</div>
                        @endif

                        @if($imaging->notes)
                            <div class="notes-section">
                                <h3>
                                    <span>📋</span>
                                    <span>ملاحظات وتعليمات</span>
                                </h3>
                                <div class="notes-content">{{ $imaging->notes }}</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>لا توجد أشعة مطلوبة</h3>
                <p style="font-size: 12px; margin-top: 5px;">لم يتم طلب أي أشعة لهذه الزيارة</p>
            </div>
        @endif
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
