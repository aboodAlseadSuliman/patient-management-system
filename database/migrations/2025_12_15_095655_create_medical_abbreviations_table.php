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
        Schema::create('medical_abbreviations', function (Blueprint $table) {
            $table->id();

            $table->string('abbreviation', 50)->unique();
            $table->string('full_text');

            $table->enum('category', [
                'symptom',
                'diagnosis',
                'medication',
                'procedure',
                'examination',
                'general'
            ])->default('general');

            $table->enum('language', ['ar', 'en', 'both'])->default('ar');
            $table->integer('usage_count')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_system')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('abbreviation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_abbreviations');
    }
};
