<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_attachment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->enum('attachment_type', [
                'x-ray',           // أشعة بسيطة (X-Ray)
                'ultrasound',      // إيكو بطني (Abdominal Ultrasound)
                'ct-scan',         // طبقي محوري (CT Scan)
                'mri',             // رنين مغناطيسي (MRI)
                'endoscopy',       // تنظير
                'lab-report',      // تقرير تحاليل
                'document',        // مستند طبي
                'other'            // أخرى
            ])->comment('نوع المرفق الطبي');
            $table->string('file_path')->comment('مسار الملف في public/medical-attachments');
            $table->string('original_filename')->comment('اسم الملف الأصلي');
            $table->string('mime_type')->nullable()->comment('نوع الملف');
            $table->unsignedBigInteger('file_size')->nullable()->comment('حجم الملف بالبايت');
            $table->text('notes')->nullable()->comment('ملاحظات حول المرفق');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes for better performance
            $table->index('visit_id');
            $table->index('attachment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_attachment_files');
    }
};
