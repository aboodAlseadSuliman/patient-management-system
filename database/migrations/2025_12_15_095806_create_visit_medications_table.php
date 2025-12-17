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
        Schema::create('visit_medications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medication_id')->nullable()->constrained()->nullOnDelete();

            $table->string('medication_text')->nullable();

            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->string('duration')->nullable();

            $table->enum('route', [
                'oral',
                'injection',
                'topical',
                'inhalation',
                'rectal',
                'sublingual',
                'transdermal',
                'other'
            ])->default('oral');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('visit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_medications');
    }
};
