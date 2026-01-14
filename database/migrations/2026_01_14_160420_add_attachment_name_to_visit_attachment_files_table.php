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
        Schema::table('visit_attachment_files', function (Blueprint $table) {
            $table->string('attachment_name')->nullable()->after('attachment_type')->comment('اسم وصفي للمرفق (اختياري)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_attachment_files', function (Blueprint $table) {
            $table->dropColumn('attachment_name');
        });
    }
};
