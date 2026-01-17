<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // الخطوة 1: إضافة حقل attachment_type_id إلى visit_imaging_studies
        Schema::table('visit_imaging_studies', function (Blueprint $table) {
            $table->foreignId('attachment_type_id')->nullable()->after('imaging_study_id')->constrained('attachment_types')->nullOnDelete();
        });

        // الخطوة 2: نقل البيانات من imaging_studies إلى attachment_types وتحديث visit_imaging_studies
        $this->migrateImagingData();

        // الخطوة 3: حذف العمود القديم imaging_study_id
        Schema::table('visit_imaging_studies', function (Blueprint $table) {
            $table->dropForeign(['imaging_study_id']);
            $table->dropColumn('imaging_study_id');
        });

        // الخطوة 4: حذف جدول imaging_studies
        Schema::dropIfExists('imaging_studies');

        // الخطوة 5: حذف جدول attachments المهمل
        Schema::dropIfExists('attachments');
    }

    /**
     * نقل البيانات من imaging_studies إلى attachment_types
     */
    protected function migrateImagingData(): void
    {
        $imagingStudies = DB::table('imaging_studies')->get();

        foreach ($imagingStudies as $imaging) {
            // التحقق من وجود النوع في attachment_types
            $existingType = DB::table('attachment_types')
                ->where('name_ar', $imaging->name_ar)
                ->orWhere('name_en', $imaging->name_en)
                ->first();

            if ($existingType) {
                // إذا كان موجوداً، نربط visit_imaging_studies به
                DB::table('visit_imaging_studies')
                    ->where('imaging_study_id', $imaging->id)
                    ->update(['attachment_type_id' => $existingType->id]);
            } else {
                // إذا لم يكن موجوداً، ننشئ سجلاً جديداً
                $maxOrder = DB::table('attachment_types')->max('display_order') ?? 0;

                $newTypeId = DB::table('attachment_types')->insertGetId([
                    'name_ar' => $imaging->name_ar ?? $this->getArabicName($imaging->type),
                    'name_en' => $imaging->name_en ?? ucfirst(str_replace('-', ' ', $imaging->type)),
                    'icon' => $this->getIconForType($imaging->type),
                    'category' => 'imaging',
                    'display_order' => $maxOrder + 1,
                    'is_active' => $imaging->is_active ?? true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ربط visit_imaging_studies بالنوع الجديد
                DB::table('visit_imaging_studies')
                    ->where('imaging_study_id', $imaging->id)
                    ->update(['attachment_type_id' => $newTypeId]);
            }
        }
    }

    /**
     * الحصول على الاسم العربي بناءً على النوع
     */
    protected function getArabicName(string $type): string
    {
        return match($type) {
            'x-ray' => 'أشعة بسيطة (X-Ray)',
            'ultrasound' => 'إيكو بطني (Ultrasound)',
            'ct' => 'طبقي محوري (CT Scan)',
            'mri' => 'رنين مغناطيسي (MRI)',
            'doppler' => 'دوبلر (Doppler)',
            default => 'تصوير طبي',
        };
    }

    /**
     * الحصول على الأيقونة المناسبة
     */
    protected function getIconForType(string $type): string
    {
        return match($type) {
            'x-ray' => '📷',
            'ultrasound' => '🩺',
            'ct' => '🔬',
            'mri' => '🧲',
            'doppler' => '💓',
            default => '🏥',
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة إنشاء جدول imaging_studies
        Schema::create('imaging_studies', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('abbreviation')->nullable();
            $table->enum('type', ['x-ray', 'ct', 'mri', 'ultrasound', 'doppler', 'other'])->default('other');
            $table->string('body_part')->nullable();
            $table->text('description')->nullable();
            $table->integer('usage_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // إعادة imaging_study_id إلى visit_imaging_studies
        Schema::table('visit_imaging_studies', function (Blueprint $table) {
            $table->foreignId('imaging_study_id')->nullable()->after('visit_id')->constrained('imaging_studies')->cascadeOnDelete();
        });

        // حذف attachment_type_id
        Schema::table('visit_imaging_studies', function (Blueprint $table) {
            $table->dropForeign(['attachment_type_id']);
            $table->dropColumn('attachment_type_id');
        });

        // إعادة جدول attachments
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type');
            $table->unsignedBigInteger('attachable_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 50)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->integer('file_size')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('category', ['xray', 'lab_report', 'prescription', 'medical_report', 'scan', 'other'])->default('other');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id']);
        });
    }
};
