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
        Schema::create('visit_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // المربع الثاني: الخط الزمني
            $table->string('onset')->nullable()->comment('البدء - حاد/مزمن/مفاجئ');
            $table->string('frequency')->nullable()->comment('التكرار - نوبي/متكرر/مستمر');
            $table->string('evolution')->nullable()->comment('التطور - تفاقم/ثابت/تراجع');

            // المربع الثالث: العوامل المحرضة
            $table->text('food_triggers')->nullable()->comment('محرضات غذائية');
            $table->text('psychological_triggers')->nullable()->comment('محرضات نفسية');
            $table->text('medication_triggers')->nullable()->comment('محرضات دوائية');
            $table->text('physical_triggers')->nullable()->comment('محرضات فيزيائية');
            $table->text('stimulant_triggers')->nullable()->comment('منبهات');
            $table->boolean('smoking_trigger')->default(false)->comment('تدخين');
            $table->text('other_triggers')->nullable()->comment('محرضات أخرى');

            // المربع الرابع: عوامل الخطورة
            $table->boolean('loss_of_appetite')->default(false)->comment('نقص شهية');
            $table->string('weight_loss_amount')->nullable()->comment('كمية نقص الوزن');
            $table->string('gi_bleeding')->nullable()->comment('نزف هضمي - زفتي/دموي/خفي');
            $table->boolean('night_symptoms')->default(false)->comment('أعراض ليلية');
            $table->boolean('recent_symptoms')->default(false)->comment('أعراض حديثة');
            $table->boolean('recurrent_ulcers')->default(false)->comment('قلاعات متكررة');
            $table->boolean('dysphagia_risk')->default(false)->comment('عسر بلع');
            $table->boolean('recurrent_vomiting')->default(false)->comment('إقياء متكرر');
            $table->boolean('bowel_habit_change_risk')->default(false)->comment('تغير عادات معوية');
            $table->text('family_history')->nullable()->comment('قصة عائلية');
            $table->text('other_risk_factors')->nullable()->comment('عوامل خطورة أخرى');

            // المربع الخامس: التاريخ المرضي
            $table->text('medical_conditions')->nullable()->comment('الحالات المرضية');
            $table->text('current_medications')->nullable()->comment('الأدوية المستخدمة');
            $table->text('previous_surgeries')->nullable()->comment('الجراحات السابقة');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_timelines');
    }
};
