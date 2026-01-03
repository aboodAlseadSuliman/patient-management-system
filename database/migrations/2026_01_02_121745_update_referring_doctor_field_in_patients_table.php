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
            // حذف الحقل القديم
            $table->dropColumn('referring_doctor');

            // إضافة foreign key للطبيب المحول
            $table->foreignId('referring_doctor_id')
                ->nullable()
                ->after('occupation')
                ->constrained('referring_doctors')
                ->nullOnDelete()
                ->comment('الطبيب المحول');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['referring_doctor_id']);
            $table->dropColumn('referring_doctor_id');

            // إرجاع الحقل القديم
            $table->string('referring_doctor')->nullable()->comment('الطبيب المحول');
        });
    }
};
