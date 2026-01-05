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
        Schema::create('visit_complaint_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // المربع الأول: الشكاية الرئيسية
            $table->text('chief_complaint')->nullable()->comment('الشكاية الرئيسية');
            $table->text('complaint_characteristics')->nullable()->comment('مواصفات الشكاية');
            $table->text('associated_symptoms')->nullable()->comment('الأعراض المرافقة');

            // القائمة - المريء
            $table->boolean('oral_thrush')->default(false)->comment('قلاع فموي');
            $table->boolean('bad_breath')->default(false)->comment('رائحة الفم');
            $table->boolean('mouth_breathing')->default(false)->comment('تنفس من الفم');
            $table->boolean('snoring')->default(false)->comment('شخير');
            $table->boolean('dental_lesions')->default(false)->comment('آفات سنية');
            $table->boolean('globus')->default(false)->comment('لقمة');
            $table->string('dysphagia')->nullable()->comment('عسر بلع - للجوامد/للسوائل');
            $table->boolean('odynophagia')->default(false)->comment('بلع مؤلم');
            $table->boolean('hiccup')->default(false)->comment('فواق');
            $table->boolean('esophageal_reflux')->default(false)->comment('قلس مريئي');

            // المعدة
            $table->string('dyspepsia')->nullable()->comment('عسر الهضم - قرحي/خزلي');
            $table->string('vomiting')->nullable()->comment('إقياء - انسدادي قريب/بعيد/دهليزي/عصبي/آخر');
            $table->boolean('melena')->default(false)->comment('تغوط زفتي');
            $table->string('anemia')->nullable()->comment('فقر دم - نقص الحديد/B12/آخر');

            // الأمعاء والكولون
            $table->boolean('growth_failure')->default(false)->comment('ضعف نمو');
            $table->string('abdominal_pain')->nullable()->comment('ألم بطني - بنكرياسي/إقفاري/بولي/نسائي/صفراوي/قلبي/جداري');
            $table->string('colon_spasm')->nullable()->comment('تشنج كولون - مع إمساك/إسهال/تناوب');
            $table->boolean('bloating_gas')->default(false)->comment('نفخة وغازات');
            $table->boolean('constipation')->default(false)->comment('إمساك');
            $table->string('diarrhea')->nullable()->comment('إسهال - دهني/التهابي/مخاطي/مدمى');
            $table->boolean('bowel_habit_change')->default(false)->comment('تغير عادات معوية');

            // المستقيم والشرج
            $table->boolean('difficult_defecation')->default(false)->comment('صعوبة تبرز');
            $table->boolean('tenesmus')->default(false)->comment('زحير');
            $table->string('rectal_bleeding')->nullable()->comment('نزف مستقيمي - مع البراز/بعد التبرز');
            $table->string('incontinence')->nullable()->comment('عدم استمساك - عصبي/إلحاحي/بالإفاضة');
            $table->boolean('anal_pain')->default(false)->comment('ألم شرجي');
            $table->boolean('anal_itching')->default(false)->comment('حكة شرجية');

            // الكبد والطرق الصفراوية
            $table->boolean('ascites')->default(false)->comment('حبن');
            $table->boolean('elevated_liver_enzymes')->default(false)->comment('ارتفاع إنزيمات الكبد');
            $table->string('hepatitis')->nullable()->comment('التهاب كبد - يرقاني/لا يرقاني');
            $table->string('jaundice')->nullable()->comment('يرقان - انحلالي/كبدي/ركودي');
            $table->string('fatty_liver')->nullable()->comment('تشحم كبد - كحولي/لا كحولي');
            $table->boolean('liver_cirrhosis')->default(false)->comment('تشمع كبد');
            $table->string('liver_masses')->nullable()->comment('كتل كبدية - كيسية/صلبة');

            // الأعضاء الأخرى
            $table->string('cough')->nullable()->comment('سعال - جاف/مع قشع');
            $table->string('dyspnea')->nullable()->comment('زلة تنفسية - جهدية/اضطجاعية');
            $table->string('chest_pain')->nullable()->comment('ألم صدري - خناقي/جنبي/مريئي/جداري');
            $table->boolean('hemoptysis')->default(false)->comment('نفث دموي');
            $table->string('dizziness')->nullable()->comment('دوار - قلبي وعائي/عصبي/دهليزي');
            $table->boolean('tremor')->default(false)->comment('رجفان');
            $table->boolean('mental_confusion')->default(false)->comment('تخليط ذهني');
            $table->boolean('dysuria')->default(false)->comment('عسر تبول');
            $table->boolean('hematuria')->default(false)->comment('بيلة دموية');
            $table->string('skin_rash')->nullable()->comment('طفح جلدي - شروي/حويصلي/حطاطي/فرفريات/آخر');
            $table->boolean('itching')->default(false)->comment('حكة');
            $table->string('joint_pain')->nullable()->comment('آلام مفصلية - مركزية/محيطية');
            $table->string('fever')->nullable()->comment('حمى - نهارية/ليلية');
            $table->boolean('fatigue')->default(false)->comment('تعب ووهن');
            $table->string('weight_loss')->nullable()->comment('نقص وزن - إرادي/لا إرادي');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_complaint_symptoms');
    }
};
