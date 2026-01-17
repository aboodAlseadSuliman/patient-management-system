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
        Schema::create('attachment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->comment('اسم نوع المرفق بالعربية');
            $table->string('name_en')->nullable()->comment('اسم نوع المرفق بالإنجليزية');
            $table->string('icon')->default('📎')->comment('أيقونة النوع');
            $table->string('category')->comment('التصنيف: imaging, endoscopy, pathology, other');
            $table->integer('display_order')->default(0)->comment('ترتيب العرض');
            $table->boolean('is_active')->default(true)->comment('فعال؟');
            $table->timestamps();
        });

        // إدراج البيانات الافتراضية
        DB::table('attachment_types')->insert([
            // الأشعة والتصوير الطبي
            ['name_ar' => 'أشعة بسيطة (X-Ray)', 'name_en' => 'X-Ray', 'icon' => '📷', 'category' => 'imaging', 'display_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'إيكو بطني (Ultrasound)', 'name_en' => 'Ultrasound', 'icon' => '🔊', 'category' => 'imaging', 'display_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'طبقي محوري (CT Scan)', 'name_en' => 'CT Scan', 'icon' => '💿', 'category' => 'imaging', 'display_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'رنين مغناطيسي (MRI)', 'name_en' => 'MRI', 'icon' => '🧲', 'category' => 'imaging', 'display_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],

            // التنظير
            ['name_ar' => 'تنظير علوي', 'name_en' => 'Upper Endoscopy', 'icon' => '🔬', 'category' => 'endoscopy', 'display_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تنظير سفلي (Colonoscopy)', 'name_en' => 'Colonoscopy', 'icon' => '🔬', 'category' => 'endoscopy', 'display_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تنظير بالأمواج فوق الصوتية (EUS)', 'name_en' => 'EUS', 'icon' => '🔬', 'category' => 'endoscopy', 'display_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تنظير القنوات الصفراوية (ERCP)', 'name_en' => 'ERCP', 'icon' => '🔬', 'category' => 'endoscopy', 'display_order' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],

            // التشريح المرضي
            ['name_ar' => 'تشريح مرضي - مريء', 'name_en' => 'Pathology - Esophagus', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 9, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - معدة', 'name_en' => 'Pathology - Stomach', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - اثني عشري', 'name_en' => 'Pathology - Duodenum', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 11, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - دقاق', 'name_en' => 'Pathology - Ileum', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 12, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - كولون', 'name_en' => 'Pathology - Colon', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 13, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - كبد', 'name_en' => 'Pathology - Liver', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 14, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشريح مرضي - بنكرياس', 'name_en' => 'Pathology - Pancreas', 'icon' => '🧪', 'category' => 'pathology', 'display_order' => 15, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],

            // أخرى
            ['name_ar' => 'تقرير تحاليل', 'name_en' => 'Lab Report', 'icon' => '📊', 'category' => 'other', 'display_order' => 16, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'مستند طبي', 'name_en' => 'Medical Document', 'icon' => '📄', 'category' => 'other', 'display_order' => 17, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'أخرى', 'name_en' => 'Other', 'icon' => '📎', 'category' => 'other', 'display_order' => 18, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_types');
    }
};
