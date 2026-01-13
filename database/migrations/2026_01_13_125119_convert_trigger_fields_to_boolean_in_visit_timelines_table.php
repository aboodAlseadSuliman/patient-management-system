<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // نقل البيانات القديمة من الحقول النصية إلى حقول الملاحظات الجديدة
        DB::table('visit_timelines')
            ->whereNotNull('food_triggers')
            ->where('food_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['food_triggers_notes' => $timeline->food_triggers]);
            });

        DB::table('visit_timelines')
            ->whereNotNull('psychological_triggers')
            ->where('psychological_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['psychological_triggers_notes' => $timeline->psychological_triggers]);
            });

        DB::table('visit_timelines')
            ->whereNotNull('medication_triggers')
            ->where('medication_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['medication_triggers_notes' => $timeline->medication_triggers]);
            });

        DB::table('visit_timelines')
            ->whereNotNull('physical_triggers')
            ->where('physical_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['physical_triggers_notes' => $timeline->physical_triggers]);
            });

        DB::table('visit_timelines')
            ->whereNotNull('stimulant_triggers')
            ->where('stimulant_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['stimulant_triggers_notes' => $timeline->stimulant_triggers]);
            });

        DB::table('visit_timelines')
            ->whereNotNull('other_triggers')
            ->where('other_triggers', '!=', '')
            ->orderBy('id')
            ->each(function ($timeline) {
                DB::table('visit_timelines')
                    ->where('id', $timeline->id)
                    ->update(['other_triggers_notes' => $timeline->other_triggers]);
            });

        // جعل جميع القيم null قبل التحويل
        DB::table('visit_timelines')->update([
            'food_triggers' => null,
            'psychological_triggers' => null,
            'medication_triggers' => null,
            'physical_triggers' => null,
            'stimulant_triggers' => null,
            'other_triggers' => null,
        ]);

        // الآن تحويل الحقول إلى boolean
        Schema::table('visit_timelines', function (Blueprint $table) {
            $table->boolean('food_triggers')->nullable()->default(false)->change();
            $table->boolean('psychological_triggers')->nullable()->default(false)->change();
            $table->boolean('medication_triggers')->nullable()->default(false)->change();
            $table->boolean('physical_triggers')->nullable()->default(false)->change();
            $table->boolean('stimulant_triggers')->nullable()->default(false)->change();
            $table->boolean('other_triggers')->nullable()->default(false)->change();
        });

        // تحديث القيم: إذا كان هناك ملاحظات، اجعل الـ checkbox = true
        DB::table('visit_timelines')
            ->whereNotNull('food_triggers_notes')
            ->where('food_triggers_notes', '!=', '')
            ->update(['food_triggers' => true]);

        DB::table('visit_timelines')
            ->whereNotNull('psychological_triggers_notes')
            ->where('psychological_triggers_notes', '!=', '')
            ->update(['psychological_triggers' => true]);

        DB::table('visit_timelines')
            ->whereNotNull('medication_triggers_notes')
            ->where('medication_triggers_notes', '!=', '')
            ->update(['medication_triggers' => true]);

        DB::table('visit_timelines')
            ->whereNotNull('physical_triggers_notes')
            ->where('physical_triggers_notes', '!=', '')
            ->update(['physical_triggers' => true]);

        DB::table('visit_timelines')
            ->whereNotNull('stimulant_triggers_notes')
            ->where('stimulant_triggers_notes', '!=', '')
            ->update(['stimulant_triggers' => true]);

        DB::table('visit_timelines')
            ->whereNotNull('other_triggers_notes')
            ->where('other_triggers_notes', '!=', '')
            ->update(['other_triggers' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_timelines', function (Blueprint $table) {
            $table->text('food_triggers')->nullable()->change();
            $table->text('psychological_triggers')->nullable()->change();
            $table->text('medication_triggers')->nullable()->change();
            $table->text('physical_triggers')->nullable()->change();
            $table->text('stimulant_triggers')->nullable()->change();
            $table->text('other_triggers')->nullable()->change();
        });
    }
};
