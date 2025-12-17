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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            // Polymorphic
            $table->string('attachable_type');
            $table->unsignedBigInteger('attachable_id');

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 50);
            $table->string('mime_type', 100);
            $table->integer('file_size');

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->enum('category', [
                'xray',
                'lab_report',
                'prescription',
                'medical_report',
                'scan',
                'other'
            ])->default('other');

            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
