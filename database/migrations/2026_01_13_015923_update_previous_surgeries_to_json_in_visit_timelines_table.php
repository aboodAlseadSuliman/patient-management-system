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
        // تحويل البيانات القديمة من text إلى json
        DB::table('visit_timelines')
            ->whereNotNull('previous_surgeries')
            ->orderBy('id')
            ->each(function ($timeline) {
                // إذا كانت البيانات نص بسيط، حولها إلى array فارغ
                if (!empty($timeline->previous_surgeries) && !is_array(json_decode($timeline->previous_surgeries, true))) {
                    DB::table('visit_timelines')
                        ->where('id', $timeline->id)
                        ->update(['previous_surgeries' => json_encode([])]);
                }
            });

        // تغيير نوع الحقل إلى json
        Schema::table('visit_timelines', function (Blueprint $table) {
            $table->json('previous_surgeries')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_timelines', function (Blueprint $table) {
            $table->text('previous_surgeries')->nullable()->change();
        });
    }
};
