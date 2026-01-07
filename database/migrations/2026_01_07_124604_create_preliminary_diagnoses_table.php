<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preliminary_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('abbreviation', 50)->nullable();
            $table->string('category', 100)->nullable(); // هضمي/كبدي/بنكرياس
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // إضافة البيانات الأولية
        DB::table('preliminary_diagnoses')->insert([
            ['name_ar' => 'نزف هضمي', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'فقر دم للدراسة', 'category' => 'hematology', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'خزل معوي', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'التهاب أمعاء حاد', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'هجمة داء معوي التهابي', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'انسداد أمعاء', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'بطن حاد', 'category' => 'digestive', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'التهاب بنكرياس', 'category' => 'pancreas', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'يرقان انسدادي', 'category' => 'liver', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تشمع كبد', 'category' => 'liver', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'التهاب كبد للدراسة', 'category' => 'liver', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'بزل حبن', 'category' => 'liver', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('preliminary_diagnoses');
    }
};
