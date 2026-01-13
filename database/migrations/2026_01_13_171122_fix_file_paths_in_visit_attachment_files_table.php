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
        // إزالة البادئة medical-attachments/ من جميع المسارات المحفوظة
        DB::table('visit_attachment_files')
            ->where('file_path', 'like', 'medical-attachments/%')
            ->orderBy('id')
            ->each(function ($file) {
                $newPath = str_replace('medical-attachments/', '', $file->file_path);
                DB::table('visit_attachment_files')
                    ->where('id', $file->id)
                    ->update(['file_path' => $newPath]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة إضافة البادئة medical-attachments/ للمسارات
        DB::table('visit_attachment_files')
            ->whereNotNull('file_path')
            ->where('file_path', '!=', '')
            ->where('file_path', 'not like', 'medical-attachments/%')
            ->orderBy('id')
            ->each(function ($file) {
                $newPath = 'medical-attachments/' . $file->file_path;
                DB::table('visit_attachment_files')
                    ->where('id', $file->id)
                    ->update(['file_path' => $newPath]);
            });
    }
};
