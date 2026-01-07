<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('abbreviation', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // إضافة البيانات الأولية
        DB::table('hospitals')->insert([
            ['name_ar' => 'الهلال الأحمر', 'abbreviation' => 'RED_CRESCENT', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'باب السباع', 'abbreviation' => 'BAB_SIBAA', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'البر', 'abbreviation' => 'AL_BIR', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'الكندي', 'abbreviation' => 'AL_KINDI', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'الرازي', 'abbreviation' => 'AL_RAZI', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'الأمين', 'abbreviation' => 'AL_AMEEN', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
