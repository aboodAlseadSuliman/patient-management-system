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
        Schema::table('patients', function (Blueprint $table) {
            // إضافة حقول الاسم المنفصلة
            $table->string('first_name')->nullable()->after('full_name')->comment('الاسم الأول');
            $table->string('father_name')->nullable()->after('first_name')->comment('اسم الأب');
            $table->string('last_name')->nullable()->after('father_name')->comment('اسم العائلة');

            // إضافة حقول العنوان الجديدة
            $table->string('country')->nullable()->after('area')->comment('البلد للمغترب');
            $table->string('province')->nullable()->after('country')->comment('المحافظة');
            $table->string('neighborhood')->nullable()->after('province')->comment('الحي/القرية');

            // إضافة حقول إضافية
            $table->integer('birth_year')->nullable()->after('date_of_birth')->comment('سنة الميلاد');
            $table->string('occupation')->nullable()->after('neighborhood')->comment('المهنة');
            $table->string('referring_doctor')->nullable()->after('occupation')->comment('الطبيب المحول');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'father_name',
                'last_name',
                'country',
                'province',
                'neighborhood',
                'birth_year',
                'occupation',
                'referring_doctor'
            ]);
        });
    }
};
