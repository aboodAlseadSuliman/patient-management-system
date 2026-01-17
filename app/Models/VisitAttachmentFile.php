<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitAttachmentFile extends Model
{
    protected $fillable = [
        'visit_id',
        'attachment_type_id',
        'attachment_type',
        'attachment_name',
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
     * العلاقة مع نوع المرفق
     */
    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(AttachmentType::class);
    }

    /**
     * العلاقة مع نتائج التحاليل (العلاقة العكسية)
     */
    public function labTestResults(): HasMany
    {
        return $this->hasMany(LabTestResult::class, 'attachment_file_id');
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
        // إذا كان هناك علاقة مع جدول attachment_types، استخدمها
        if ($this->attachmentType) {
            return $this->attachmentType->full_name;
        }

        // للتوافق مع البيانات القديمة
        return match($this->attachment_type) {
            'medical-referral' => 'إحالة طبية',
            'x-ray' => 'أشعة بسيطة (X-Ray)',
            'ultrasound' => 'إيكو بطني (Ultrasound)',
            'ct-scan' => 'طبقي محوري (CT Scan)',
            'mri' => 'رنين مغناطيسي (MRI)',
            'upper-endoscopy' => 'تنظير علوي',
            'colonoscopy' => 'تنظير سفلي (Colonoscopy)',
            'eus' => 'تنظير بالأمواج فوق الصوتية (EUS)',
            'ercp' => 'تنظير القنوات الصفراوية (ERCP)',
            'pathology-esophagus' => 'تشريح مرضي - مريء',
            'pathology-stomach' => 'تشريح مرضي - معدة',
            'pathology-duodenum' => 'تشريح مرضي - اثني عشري',
            'pathology-ileum' => 'تشريح مرضي - دقاق',
            'pathology-colon' => 'تشريح مرضي - كولون',
            'pathology-liver' => 'تشريح مرضي - كبد',
            'pathology-pancreas' => 'تشريح مرضي - بنكرياس',
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
