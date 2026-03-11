<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Avoid requiring doctrine/dbal by using a raw statement.
        DB::statement('ALTER TABLE patients MODIFY date_of_birth DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE patients MODIFY date_of_birth DATE NOT NULL');
    }
};
