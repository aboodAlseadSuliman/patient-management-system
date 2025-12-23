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
        Schema::create('imaging_studies', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('abbreviation')->nullable();
            $table->enum('type', ['x-ray', 'ct', 'mri', 'ultrasound', 'doppler', 'other'])->default('x-ray');
            $table->string('body_part')->nullable();
            $table->text('description')->nullable();
            $table->integer('usage_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول الربط
        Schema::create('visit_imaging_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('imaging_study_id')->constrained()->cascadeOnDelete();
            $table->text('findings')->nullable();
            $table->text('impression')->nullable();
            $table->date('study_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imaging_studies');
        Schema::dropIfExists('visit_imaging_studies');
    }
};
