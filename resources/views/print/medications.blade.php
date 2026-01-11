<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأدوية الموصوفة - {{ $patient->full_name }}</title>
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
            border-bottom: 3px solid #7c3aed;
        }

        .logo-space {
            min-height: 70px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #64748b;
        }

        .header h1 {
            font-size: 22px;
            color: #5b21b6;
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
            border-right: 4px solid #7c3aed;
        }

        .patient-info h2 {
            font-size: 15px;
            color: #5b21b6;
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

        .medications-section {
            margin-bottom: 20px;
        }

        .medications-section h2 {
            font-size: 16px;
            color: #6d28d9;
            margin-bottom: 12px;
            padding: 8px 12px;
            background: linear-gradient(to left, #f5f3ff, #ffffff);
            border-right: 4px solid #7c3aed;
            border-radius: 4px;
        }

        .medication-item {
            padding: 15px;
            margin-bottom: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            border-right: 3px solid #8b5cf6;
        }

        .medication-header {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #d1d5db;
        }

        .medication-number {
            display: inline-block;
            background: #7c3aed;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 13px;
            margin-left: 6px;
        }

        .medication-name {
            color: #5b21b6;
            font-weight: 600;
        }

        .medication-strength {
            color: #7c3aed;
            font-size: 13px;
        }

        .medication-form {
            color: #6b7280;
            font-size: 13px;
            font-style: italic;
        }

        .medication-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .detail-item {
            background: #ffffff;
            padding: 6px 10px;
            border-radius: 4px;
            border-right: 2px solid #a78bfa;
        }

        .detail-label {
            font-weight: 600;
            color: #6d28d9;
            font-size: 12px;
            display: block;
            margin-bottom: 2px;
        }

        .detail-value {
            color: #4b5563;
            font-size: 13px;
        }

        .medication-notes {
            margin-top: 10px;
            padding: 8px 10px;
            background: #fffbeb;
            border-right: 3px solid #f59e0b;
            border-radius: 4px;
        }

        .medication-notes-label {
            font-weight: 600;
            color: #92400e;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .medication-notes-content {
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

            .medication-item {
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
            background: #7c3aed;
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
            background: #6d28d9;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ طباعة</button>

    <div class="header">
        <div class="logo-space">
            [مساحة مخصصة لشعار وزارة الصحة]
        </div>
        <h1>الأدوية الموصوفة</h1>
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
                <div class="detail-item">
                    <span class="detail-label">💊 الجرعة</span>
                    <span class="detail-value">{{ $medication->pivot->dosage }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->frequency)
                <div class="detail-item">
                    <span class="detail-label">🕐 عدد المرات</span>
                    <span class="detail-value">{{ $medication->pivot->frequency }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->duration)
                <div class="detail-item">
                    <span class="detail-label">📅 المدة</span>
                    <span class="detail-value">{{ $medication->pivot->duration }}</span>
                </div>
                @endif

                @if($medication->pivot && $medication->pivot->instructions)
                <div class="detail-item">
                    <span class="detail-label">⚠️ تعليمات الاستخدام</span>
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
