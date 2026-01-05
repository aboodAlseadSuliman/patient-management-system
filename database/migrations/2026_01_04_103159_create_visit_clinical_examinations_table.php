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
        Schema::create('visit_clinical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // الواجهة الرابعة: الفحص السريري

            // 1. العلامات الحيوية
            $table->string('blood_pressure')->nullable()->comment('الضغط الشرياني');
            $table->integer('pulse')->nullable()->comment('النبض');
            $table->decimal('temperature', 4, 2)->nullable()->comment('الحرارة');
            $table->integer('oxygen_saturation')->nullable()->comment('الأكسجة');

            // 2. الفحص السريري
            $table->decimal('weight', 5, 2)->nullable()->comment('الوزن');
            $table->text('head_neck_exam')->nullable()->comment('الرأس والعنق');
            $table->text('heart_chest_exam')->nullable()->comment('القلب والصدر');
            $table->text('abdomen_pelvis_exam')->nullable()->comment('البطن والحوض');
            $table->text('extremities_exam')->nullable()->comment('الأطراف');
            $table->text('rectal_exam')->nullable()->comment('المس الشرجي');

            // 3. إيكو البطن
            $table->text('liver_echo')->nullable()->comment('الكبد');
            $table->text('gallbladder_echo')->nullable()->comment('المرارة');
            $table->text('bile_ducts_echo')->nullable()->comment('الطرق الصفراوية');
            $table->text('pancreas_echo')->nullable()->comment('البنكرياس');
            $table->text('spleen_echo')->nullable()->comment('الطحال');
            $table->text('stomach_echo')->nullable()->comment('المعدة');
            $table->text('intestines_echo')->nullable()->comment('الأمعاء');
            $table->text('abdominal_cavity_echo')->nullable()->comment('جوف البطن');
            $table->text('kidneys_echo')->nullable()->comment('الكليتين');
            $table->text('uterus_appendages_echo')->nullable()->comment('الرحم والملحقات');
            $table->text('prostate_echo')->nullable()->comment('البروستات');
            $table->text('other_echo')->nullable()->comment('أخرى');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_clinical_examinations');
    }
};
