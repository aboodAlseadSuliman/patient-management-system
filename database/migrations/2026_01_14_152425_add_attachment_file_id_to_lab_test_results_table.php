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
        Schema::table('lab_test_results', function (Blueprint $table) {
            $table->foreignId('attachment_file_id')
                ->nullable()
                ->after('lab_test_id')
                ->constrained('visit_attachment_files')
                ->nullOnDelete()
                ->comment('ربط نتيجة التحليل بملف المرفق (اختياري)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_test_results', function (Blueprint $table) {
            $table->dropForeign(['attachment_file_id']);
            $table->dropColumn('attachment_file_id');
        });
    }
};
