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
        Schema::table('visit_timelines', function (Blueprint $table) {
            // تحويل الحقول النصية إلى boolean وإضافة حقول الملاحظات
            $table->text('food_triggers_notes')->nullable()->after('food_triggers');
            $table->text('psychological_triggers_notes')->nullable()->after('psychological_triggers');
            $table->text('medication_triggers_notes')->nullable()->after('medication_triggers');
            $table->text('physical_triggers_notes')->nullable()->after('physical_triggers');
            $table->text('stimulant_triggers_notes')->nullable()->after('stimulant_triggers');
            $table->text('smoking_trigger_notes')->nullable()->after('smoking_trigger');
            $table->text('other_triggers_notes')->nullable()->after('other_triggers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_timelines', function (Blueprint $table) {
            $table->dropColumn([
                'food_triggers_notes',
                'psychological_triggers_notes',
                'medication_triggers_notes',
                'physical_triggers_notes',
                'stimulant_triggers_notes',
                'smoking_trigger_notes',
                'other_triggers_notes',
            ]);
        });
    }
};
