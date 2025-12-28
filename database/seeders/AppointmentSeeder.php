<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // التأكد من وجود مرضى وأنواع مواعيد
        if (Patient::count() === 0) {
            $this->command->warn('لا يوجد مرضى! قم بتشغيل PatientSeeder أولاً.');
            return;
        }

        if (AppointmentType::count() === 0) {
            $this->command->warn('لا يوجد أنواع مواعيد! قم بتشغيل AppointmentTypeSeeder أولاً.');
            return;
        }

        $patients = Patient::all();
        $appointmentTypes = AppointmentType::all();
        $userId = 1; // افترض أن المستخدم الأول هو الطبيب

        // ==================== مواعيد الأسبوع الماضي (مكتملة) ====================
        $this->createCompletedAppointments($patients, $appointmentTypes, $userId);

        // ==================== مواعيد هذا الأسبوع ====================
        $this->createThisWeekAppointments($patients, $appointmentTypes, $userId);

        // ==================== مواعيد الأسبوع القادم ====================
        $this->createUpcomingAppointments($patients, $appointmentTypes, $userId);

        // ==================== مواعيد ملغية/لم يحضر ====================
        $this->createCancelledAppointments($patients, $appointmentTypes, $userId);

        $this->command->info('✅ تم إنشاء مواعيد تجريبية بنجاح!');
    }

    /**
     * مواعيد مكتملة من الأسبوع الماضي
     */
    private function createCompletedAppointments($patients, $appointmentTypes, $userId): void
    {
        $appointments = [
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->subDays(6),
                'time' => '09:00',
                'status' => 'completed',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'فحص دوري',
                'doctor_notes' => 'الحالة مستقرة، يُنصح بالمتابعة بعد شهر',
                'fee' => 200,
                'payment_status' => 'paid',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'hospital')->first(),
                'date' => Carbon::now()->subDays(5),
                'time' => '10:30',
                'status' => 'completed',
                'priority' => 'urgent',
                'duration' => 60,
                'location' => 'غرفة 201',
                'reason' => 'ألم في البطن',
                'doctor_notes' => 'تم إجراء فحوصات، النتائج سليمة',
                'fee' => 500,
                'payment_status' => 'paid',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'endoscopy')->first(),
                'date' => Carbon::now()->subDays(4),
                'time' => '08:00',
                'status' => 'completed',
                'priority' => 'normal',
                'duration' => 45,
                'location' => 'قسم التنظير',
                'reason' => 'تنظير معدة',
                'doctor_notes' => 'لا توجد قرحة، الوضع طبيعي',
                'fee' => 800,
                'payment_status' => 'paid',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->subDays(3),
                'time' => '14:00',
                'status' => 'completed',
                'priority' => 'normal',
                'duration' => 20,
                'reason' => 'متابعة ضغط الدم',
                'doctor_notes' => 'الضغط منضبط، الاستمرار على العلاج',
                'fee' => 150,
                'payment_status' => 'paid',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->subDays(2),
                'time' => '11:00',
                'status' => 'completed',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'صداع مزمن',
                'doctor_notes' => 'تم وصف علاج، المتابعة بعد أسبوعين',
                'fee' => 200,
                'payment_status' => 'paid',
            ],
        ];

        foreach ($appointments as $apt) {
            Appointment::create([
                'patient_id' => $apt['patient']->id,
                'appointment_type_id' => $apt['type']->id,
                'appointment_date' => $apt['date'],
                'appointment_time' => $apt['time'],
                'duration' => $apt['duration'],
                'status' => $apt['status'],
                'priority' => $apt['priority'],
                'location' => $apt['location'] ?? null,
                'reason' => $apt['reason'],
                'notes' => $apt['notes'] ?? null,
                'doctor_notes' => $apt['doctor_notes'] ?? null,
                'fee' => $apt['fee'] ?? null,
                'payment_status' => $apt['payment_status'] ?? 'pending',
                'reminder_sent' => true,
                'reminder_sent_at' => Carbon::parse($apt['date'])->subDay(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }

    /**
     * مواعيد هذا الأسبوع
     */
    private function createThisWeekAppointments($patients, $appointmentTypes, $userId): void
    {
        $appointments = [
            // اليوم
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::today(),
                'time' => '09:00',
                'status' => 'confirmed',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'فحص دوري',
                'fee' => 200,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::today(),
                'time' => '10:00',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'استشارة طبية',
                'fee' => 200,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'hospital')->first(),
                'date' => Carbon::today(),
                'time' => '11:30',
                'status' => 'confirmed',
                'priority' => 'urgent',
                'duration' => 60,
                'location' => 'غرفة 105',
                'reason' => 'ألم في الصدر',
                'fee' => 500,
            ],

            // غداً
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::tomorrow(),
                'time' => '09:30',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'متابعة سكري',
                'fee' => 200,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'endoscopy')->first(),
                'date' => Carbon::tomorrow(),
                'time' => '08:00',
                'status' => 'confirmed',
                'priority' => 'normal',
                'duration' => 45,
                'location' => 'قسم التنظير',
                'reason' => 'تنظير قولون',
                'fee' => 900,
            ],

            // بعد يومين
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->addDays(2),
                'time' => '14:00',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 20,
                'reason' => 'متابعة ضغط',
                'fee' => 150,
            ],
        ];

        foreach ($appointments as $apt) {
            Appointment::create([
                'patient_id' => $apt['patient']->id,
                'appointment_type_id' => $apt['type']->id,
                'appointment_date' => $apt['date'],
                'appointment_time' => $apt['time'],
                'duration' => $apt['duration'],
                'status' => $apt['status'],
                'priority' => $apt['priority'],
                'location' => $apt['location'] ?? null,
                'reason' => $apt['reason'],
                'notes' => $apt['notes'] ?? null,
                'fee' => $apt['fee'] ?? null,
                'payment_status' => 'pending',
                'reminder_sent' => false,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }

    /**
     * مواعيد الأسبوع القادم
     */
    private function createUpcomingAppointments($patients, $appointmentTypes, $userId): void
    {
        $appointments = [
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->addDays(5),
                'time' => '10:00',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'كشف عام',
                'fee' => 200,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'hospital')->first(),
                'date' => Carbon::now()->addDays(7),
                'time' => '09:00',
                'status' => 'scheduled',
                'priority' => 'urgent',
                'duration' => 60,
                'location' => 'غرفة 302',
                'reason' => 'عملية جراحية صغرى',
                'fee' => 1500,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->addDays(10),
                'time' => '11:00',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'متابعة علاج',
                'fee' => 200,
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->firstWhere('slug', 'followup') ?? $appointmentTypes->first(),
                'date' => Carbon::now()->addDays(14),
                'time' => '15:00',
                'status' => 'scheduled',
                'priority' => 'normal',
                'duration' => 15,
                'reason' => 'متابعة دورية',
                'fee' => 100,
            ],
        ];

        foreach ($appointments as $apt) {
            Appointment::create([
                'patient_id' => $apt['patient']->id,
                'appointment_type_id' => $apt['type']->id,
                'appointment_date' => $apt['date'],
                'appointment_time' => $apt['time'],
                'duration' => $apt['duration'],
                'status' => $apt['status'],
                'priority' => $apt['priority'],
                'location' => $apt['location'] ?? null,
                'reason' => $apt['reason'],
                'fee' => $apt['fee'] ?? null,
                'payment_status' => 'pending',
                'reminder_sent' => false,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }

    /**
     * مواعيد ملغية أو لم يحضر
     */
    private function createCancelledAppointments($patients, $appointmentTypes, $userId): void
    {
        $appointments = [
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->subDays(3),
                'time' => '16:00',
                'status' => 'cancelled',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'فحص عام',
                'notes' => 'ألغى المريض الموعد',
                'fee' => 200,
                'payment_status' => 'pending',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'clinic')->first(),
                'date' => Carbon::now()->subDays(2),
                'time' => '10:30',
                'status' => 'no_show',
                'priority' => 'normal',
                'duration' => 30,
                'reason' => 'استشارة',
                'notes' => 'لم يحضر المريض',
                'fee' => 200,
                'payment_status' => 'pending',
            ],
            [
                'patient' => $patients->random(),
                'type' => $appointmentTypes->where('slug', 'hospital')->first(),
                'date' => Carbon::now()->subDays(1),
                'time' => '14:00',
                'status' => 'rescheduled',
                'priority' => 'urgent',
                'duration' => 60,
                'location' => 'غرفة 210',
                'reason' => 'عملية جراحية',
                'notes' => 'تم تأجيل الموعد لظروف طارئة',
                'fee' => 1000,
                'payment_status' => 'pending',
            ],
        ];

        foreach ($appointments as $apt) {
            Appointment::create([
                'patient_id' => $apt['patient']->id,
                'appointment_type_id' => $apt['type']->id,
                'appointment_date' => $apt['date'],
                'appointment_time' => $apt['time'],
                'duration' => $apt['duration'],
                'status' => $apt['status'],
                'priority' => $apt['priority'],
                'location' => $apt['location'] ?? null,
                'reason' => $apt['reason'],
                'notes' => $apt['notes'] ?? null,
                'fee' => $apt['fee'] ?? null,
                'payment_status' => $apt['payment_status'] ?? 'pending',
                'reminder_sent' => true,
                'reminder_sent_at' => Carbon::parse($apt['date'])->subDay(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }
}
