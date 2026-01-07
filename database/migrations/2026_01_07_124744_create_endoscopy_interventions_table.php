<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('endoscopy_interventions', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('abbreviation', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // إضافة البيانات الأولية
        DB::table('endoscopy_interventions')->insert([
            ['name_ar' => 'استخراج جسم أجنبي', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'انحشار لقمة طعامية', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'توسيع مريء بالشمعات', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'توسيع بالبالون', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'استئصال بوليب', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'حقن أدرينالين', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تخثير أرغون', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'كليبس إرقاء', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تفميم معدة', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'بالون تنحيف', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'رد انفتال سين', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'ربط دوالي مريء', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تصليب دوالي معدة', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('endoscopy_interventions');
    }
};
