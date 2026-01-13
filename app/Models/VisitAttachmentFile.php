<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitAttachmentFile extends Model
{
    protected $fillable = [
        'visit_id',
        'attachment_type',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
        'notes',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * العلاقة مع الزيارة
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * العلاقة مع المستخدم الذي رفع الملف
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * الحصول على رابط الملف الكامل
     */
    public function getFileUrlAttribute(): string
    {
        return asset('medical-attachments/' . $this->file_path);
    }

    /**
     * الحصول على حجم الملف المنسق
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'غير معروف';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * الحصول على اسم نوع المرفق بالعربية
     */
    public function getAttachmentTypeNameAttribute(): string
    {
        return match($this->attachment_type) {
            'x-ray' => 'أشعة بسيطة (X-Ray)',
            'ultrasound' => 'إيكو بطني (Ultrasound)',
            'ct-scan' => 'طبقي محوري (CT Scan)',
            'mri' => 'رنين مغناطيسي (MRI)',
            'endoscopy' => 'تنظير',
            'lab-report' => 'تقرير تحاليل',
            'document' => 'مستند طبي',
            'other' => 'أخرى',
            default => $this->attachment_type,
        };
    }

    /**
     * حذف الملف من القرص عند حذف السجل
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            $fullPath = public_path('medical-attachments/' . $attachment->file_path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        });
    }
}
