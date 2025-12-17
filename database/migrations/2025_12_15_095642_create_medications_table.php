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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();

            $table->string('name_ar')->comment('الاسم بالعربية');
            $table->string('name_en')->nullable();
            $table->string('generic_name')->nullable()->comment('الاسم العلمي');
            $table->string('brand_name')->nullable()->comment('الاسم التجاري');
            $table->string('abbreviation', 50)->nullable();

            $table->enum('dosage_form', [
                'tablet',
                'capsule',
                'syrup',
                'injection',
                'cream',
                'ointment',
                'drops',
                'spray',
                'inhaler',
                'suppository',
                'patch',
                'other'
            ])->default('tablet');

            $table->string('strength', 50)->nullable()->comment('التركيز');
            $table->string('manufacturer')->nullable();
            $table->text('description')->nullable();
            $table->string('common_dosage')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('contraindications')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('name_ar');
            $table->index('generic_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
