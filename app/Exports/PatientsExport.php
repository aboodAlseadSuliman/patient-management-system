<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Patient::with('referringDoctor')->get();
    }

    public function headings(): array
    {
        return [
            'رقم الملف',
            'رقم الهوية الوطنية',
            'الاسم الكامل',
            'الاسم الأول',
            'اسم الأب',
            'اسم العائلة',
            'الجنس',
            'تاريخ الميلاد',
            'سنة الميلاد',
            'رقم الهاتف',
            'البلد',
            'المحافظة',
            'الحي',
            'المهنة',
            'الطبيب المحول',
            'نشط',
            'ملاحظات',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }

    public function map($patient): array
    {
        return [
            $patient->file_number,
            $patient->national_id,
            $patient->full_name,
            $patient->first_name,
            $patient->father_name,
            $patient->last_name,
            $patient->gender === 'male' ? 'ذكر' : ($patient->gender === 'female' ? 'أنثى' : ''),
            $patient->date_of_birth?->format('Y-m-d'),
            $patient->birth_year,
            $patient->phone,
            $patient->country,
            $patient->province,
            $patient->neighborhood,
            $patient->occupation,
            $patient->referringDoctor?->name,
            $patient->is_active ? 'نعم' : 'لا',
            $patient->notes,
            $patient->created_at?->format('Y-m-d H:i'),
            $patient->updated_at?->format('Y-m-d H:i'),
        ];
    }
}
