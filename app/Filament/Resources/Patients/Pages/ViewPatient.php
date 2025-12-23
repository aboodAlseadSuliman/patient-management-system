<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;


use App\Models\ChronicDisease;
use App\Models\Medication;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected string $view = 'filament.resources.patients.view-patient'; // ⭐ بدون static

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('تعديل'),
            Actions\DeleteAction::make()
                ->label('حذف'),
        ];
    }

    public function getTitle(): string
    {
        return "عرض المريض: {$this->record->full_name}";
    }

    // ==================== الأمراض المزمنة ====================

    /**
     * إضافة مرض مزمن
     */
    public function addChronicDiseaseAction(): Action
    {
        return Action::make('addChronicDisease')
            ->label('إضافة مرض مزمن')
            ->icon('heroicon-o-plus-circle')
            ->modal()
            ->form([
                Select::make('chronic_disease_id')
                    ->label('المرض المزمن')
                    ->options(ChronicDisease::active()->pluck('name_ar', 'id'))
                    ->searchable()
                    ->required()
                    ->createOptionUsing(function (array $data): int {
                        $disease = ChronicDisease::create([
                            'name_ar' => $data['name_ar'],
                            'name_en' => null,
                            'is_active' => true,
                        ]);
                        return $disease->id;
                    })
                    ->createOptionForm([
                        TextInput::make('name_ar')
                            ->label('اسم المرض')
                            ->required(),
                    ]),

                DatePicker::make('diagnosis_date')
                    ->label('تاريخ التشخيص')
                    ->default(now()),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3),

                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),
            ])
            ->action(function (array $data) {
                // ✅ التحقق من عدم وجود المرض بالفعل
                $exists = $this->record->chronicDiseases()
                    ->where('chronic_disease_id', $data['chronic_disease_id'])
                    ->exists();

                if ($exists) {
                    Notification::make()
                        ->title('هذا المرض مسجل بالفعل للمريض!')
                        ->warning()
                        ->send();
                    return;
                }

                // إضافة المرض
                $this->record->chronicDiseases()->attach($data['chronic_disease_id'], [
                    'diagnosis_date' => $data['diagnosis_date'] ?? now(),
                    'notes' => $data['notes'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                ]);

                Notification::make()
                    ->title('تم إضافة المرض المزمن بنجاح')
                    ->success()
                    ->send();
            });
    }

    /**
     * حذف مرض مزمن
     */
    public function deleteChronicDisease($chronicDiseaseId): void
    {
        $this->record->chronicDiseases()->detach($chronicDiseaseId);

        Notification::make()
            ->title('تم حذف المرض المزمن بنجاح')
            ->success()
            ->send();

        $this->redirect(route('filament.admin.resources.patients.view', ['record' => $this->record]));
    }

    // ==================== الأدوية الدائمة ====================

    /**
     * إضافة دواء دائم
     */
    public function addPermanentMedicationAction(): Action
    {
        return Action::make('addPermanentMedication')
            ->label('إضافة دواء دائم')
            ->icon('heroicon-o-plus-circle')
            ->modal()
            ->form([
                Select::make('medication_id')
                    ->label('الدواء')
                    ->options(function () {
                        return Medication::active()
                            ->get()
                            ->mapWithKeys(function ($med) {
                                $label = $med->name_ar;
                                if ($med->strength) {
                                    $label .= " ({$med->strength})";
                                }
                                return [$med->id => $label];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->createOptionUsing(function (array $data): int {
                        $medication = Medication::create([
                            'name_ar' => $data['name_ar'],
                            'name_en' => null,
                            'dosage_form' => 'tablet',
                            'is_active' => true,
                        ]);
                        return $medication->id;
                    })
                    ->createOptionForm([
                        TextInput::make('name_ar')
                            ->label('اسم الدواء')
                            ->required(),
                    ]),

                TextInput::make('dosage')
                    ->label('الجرعة')
                    ->placeholder('مثال: 500mg')
                    ->required(),

                TextInput::make('frequency')
                    ->label('التكرار')
                    ->placeholder('مثال: مرتين يومياً')
                    ->required(),

                Select::make('route')
                    ->label('طريقة الإعطاء')
                    ->options([
                        'oral' => 'فموي',
                        'injection' => 'حقن',
                        'topical' => 'موضعي',
                        'inhalation' => 'استنشاق',
                        'rectal' => 'شرجي',
                        'sublingual' => 'تحت اللسان',
                        'transdermal' => 'عبر الجلد',
                        'other' => 'أخرى',
                    ])
                    ->default('oral'),

                DatePicker::make('start_date')
                    ->label('تاريخ البدء')
                    ->default(now()),

                DatePicker::make('end_date')
                    ->label('تاريخ الانتهاء (اختياري)'),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(2),

                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),
            ])
            ->action(function (array $data) {
                // ✅ التحقق من عدم وجود الدواء بالفعل
                $exists = $this->record->permanentMedications()
                    ->where('medication_id', $data['medication_id'])
                    ->exists();

                if ($exists) {
                    Notification::make()
                        ->title('هذا الدواء مسجل بالفعل للمريض!')
                        ->warning()
                        ->send();
                    return;
                }

                // إضافة الدواء
                $this->record->permanentMedications()->attach($data['medication_id'], [
                    'dosage' => $data['dosage'],
                    'frequency' => $data['frequency'],
                    'route' => $data['route'] ?? 'oral',
                    'start_date' => $data['start_date'] ?? now(),
                    'end_date' => $data['end_date'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                ]);

                Notification::make()
                    ->title('تم إضافة الدواء الدائم بنجاح')
                    ->success()
                    ->send();
            });
    }

    /**
     * حذف دواء دائم
     */
    public function deletePermanentMedication($medicationId): void
    {
        $this->record->permanentMedications()->detach($medicationId);

        Notification::make()
            ->title('تم حذف الدواء الدائم بنجاح')
            ->success()
            ->send();

        $this->redirect(route('filament.admin.resources.patients.view', ['record' => $this->record]));
    }
}
