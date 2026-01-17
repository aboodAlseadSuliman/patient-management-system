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
        Schema::table('visit_followups', function (Blueprint $table) {
            // إضافة عمود next_visit_date بعد followup_period
            $table->date('next_visit_date')->nullable()->after('followup_period')->comment('تاريخ الزيارة القادمة المحدد');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_followups', function (Blueprint $table) {
            $table->dropColumn('next_visit_date');
        });
    }
};
