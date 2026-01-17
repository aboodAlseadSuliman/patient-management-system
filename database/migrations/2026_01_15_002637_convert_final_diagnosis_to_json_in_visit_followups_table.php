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
        // تحويل البيانات الموجودة من text إلى JSON array
        $followups = DB::table('visit_followups')->whereNotNull('final_diagnosis')->get();

        foreach ($followups as $followup) {
            if (!empty($followup->final_diagnosis)) {
                // تحويل النص إلى مصفوفة تحتوي على عنصر واحد
                DB::table('visit_followups')
                    ->where('id', $followup->id)
                    ->update([
                        'final_diagnosis' => json_encode([$followup->final_diagnosis])
                    ]);
            }
        }

        // تغيير نوع الحقل من text إلى json
        Schema::table('visit_followups', function (Blueprint $table) {
            $table->json('final_diagnosis')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_followups', function (Blueprint $table) {
            $table->text('final_diagnosis')->nullable()->change();
        });
    }
};
