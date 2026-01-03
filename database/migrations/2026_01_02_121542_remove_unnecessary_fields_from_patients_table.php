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
            $table->dropColumn([
                'alternative_phone',
                'address',
                'city',
                'area'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('alternative_phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('area', 100)->nullable();
        });
    }
};
