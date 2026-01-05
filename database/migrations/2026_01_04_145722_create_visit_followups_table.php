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
        Schema::create('visit_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // الواجهة السادسة: المتابعة

            // 1. التشخيص المبدئي - 18 خيار
            $table->boolean('ulcers_for_study')->default(false)->comment('قلاعات للدراسة');
            $table->boolean('dysphagia_for_study')->default(false)->comment('عسر بلع للدراسة');
            $table->boolean('suspected_gerd')->default(false)->comment('شك قلس مريئي');
            $table->boolean('dyspepsia_for_study')->default(false)->comment('عسر هضم للدراسة');
            $table->boolean('anemia_for_study')->default(false)->comment('فقر دم للدراسة');
            $table->boolean('gi_bleeding_for_study')->default(false)->comment('نزف هضمي للدراسة');
            $table->boolean('suspected_malabsorption')->default(false)->comment('شك سوء امتصاص');
            $table->boolean('suspected_ibd')->default(false)->comment('شك داء معوي التهابي');
            $table->boolean('ibs_for_study')->default(false)->comment('تشنج كولون للدراسة');
            $table->boolean('chronic_diarrhea_for_study')->default(false)->comment('إسهال مزمن للدراسة');
            $table->boolean('suspected_intestinal_obstruction')->default(false)->comment('شك انسداد أمعاء');
            $table->boolean('suspected_acute_abdomen')->default(false)->comment('شك بطن حاد');
            $table->boolean('ascites_for_study')->default(false)->comment('حبن للدراسة');
            $table->boolean('elevated_liver_enzymes_for_study')->default(false)->comment('ارتفاع خمائر كبد للدراسة');
            $table->boolean('hepatitis_for_study')->default(false)->comment('التهاب كبد للدراسة');
            $table->boolean('suspected_cirrhosis')->default(false)->comment('شك تشمع كبد');
            $table->boolean('liver_masses_for_study')->default(false)->comment('كتل كبد للدراسة');
            $table->boolean('biliary_obstruction_for_study')->default(false)->comment('انسداد صفراوي للدراسة');

            // 2. التشخيص النهائي
            $table->text('final_diagnosis')->nullable()->comment('التشخيص النهائي');

            // 3. الأمراض المزمنة - 4 حقول
            $table->text('chronic_esophagus_stomach')->nullable()->comment('المريء والمعدة');
            $table->text('chronic_intestines_colon')->nullable()->comment('الأمعاء والكولون');
            $table->text('chronic_liver')->nullable()->comment('الكبد');
            $table->text('chronic_biliary_pancreas')->nullable()->comment('الطرق الصفراوية والبنكرياس');

            // 4. المراجعة
            $table->boolean('followup_required')->default(false)->comment('مطلوبة/غير مطلوبة');
            $table->string('followup_period')->nullable()->comment('بعد: أيام/أسبوع/أسبوعين/شهر/شهرين/3 أشهر/6 أشهر');

            // 5. الحالة النهائية
            $table->string('final_status')->nullable()->comment('شفاء/تحسن/قيد العلاج/وفاة');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_followups');
    }
};
