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
        Schema::create('chronic_diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->comment('الاسم بالعربية');
            $table->string('name_en')->nullable();
            $table->string('abbreviation', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('icd_code', 20)->nullable()->comment('كود التصنيف الدولي');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('name_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chronic_diseases');
    }
};
