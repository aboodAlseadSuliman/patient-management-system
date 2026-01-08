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
        Schema::create('biopsy_locations', function (Blueprint $table) {
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
        DB::table('biopsy_locations')->insert([
            ['name_ar' => 'مريء', 'name_en' => 'Esophagus', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'معدة', 'name_en' => 'Stomach', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'اثني عشري', 'name_en' => 'Duodenum', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'كولون', 'name_en' => 'Colon', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'دقاق', 'name_en' => 'Ileum', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'كبد', 'name_en' => 'Liver', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'بنكرياس', 'name_en' => 'Pancreas', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // جدول pivot لأماكن الخزعات
        Schema::create('procedure_biopsy_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procedure_id')->constrained('endoscopy_procedures')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('biopsy_locations')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['procedure_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_biopsy_locations');
        Schema::dropIfExists('biopsy_locations');
    }
};
