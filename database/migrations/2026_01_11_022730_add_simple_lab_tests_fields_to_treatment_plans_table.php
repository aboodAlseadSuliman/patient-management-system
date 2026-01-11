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
        Schema::table('visit_treatment_plans', function (Blueprint $table) {
            $table->string('lab_tests_input_method', 20)->default('detailed')->after('requested_lab_tests');
            $table->text('lab_tests_simple_notes')->nullable()->after('lab_tests_input_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_treatment_plans', function (Blueprint $table) {
            $table->dropColumn(['lab_tests_input_method', 'lab_tests_simple_notes']);
        });
    }
};
