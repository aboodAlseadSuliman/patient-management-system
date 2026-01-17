<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PathologyRequest extends Model
{
    protected $fillable = [
        'visit_id',
        'patient_id',
        'pathology_type',
        'description',
        'clinical_notes',
        'request_date',
        'expected_result_date',
        'actual_result_date',
        'status',
        'result',
        'attachment_file_id',
    ];

    protected $casts = [
        'request_date' => 'date',
        'expected_result_date' => 'date',
        'actual_result_date' => 'date',
    ];

    /**
     * العلاقة مع الزيارة
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * العلاقة مع المريض
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * العلاقة مع ملف النتيجة
     */
    public function attachmentFile(): BelongsTo
    {
        return $this->belongsTo(VisitAttachmentFile::class, 'attachment_file_id');
    }

    /**
     * الحصول على اسم نوع التشريح بالعربية
     */
    public function getPathologyTypeNameAttribute(): string
    {
        return match($this->pathology_type) {
            'esophagus' => 'تشريح مرضي - مريء',
            'stomach' => 'تشريح مرضي - معدة',
            'duodenum' => 'تشريح مرضي - اثني عشري',
            'ileum' => 'تشريح مرضي - دقاق',
            'colon' => 'تشريح مرضي - كولون',
            'liver' => 'تشريح مرضي - كبد',
            'pancreas' => 'تشريح مرضي - بنكرياس',
            'other' => 'تشريح مرضي - أخرى',
            default => $this->pathology_type,
        };
    }

    /**
     * الحصول على حالة الطلب بالعربية
     */
    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $this->status,
        };
    }

    /**
     * Scope للطلبات المعلقة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope للطلبات قيد المعالجة
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope للطلبات القريبة (خلال أسبوعين)
     */
    public function scopeUpcoming($query, int $days = 14)
    {
        return $query->whereIn('status', ['pending', 'in_progress'])
            ->whereNotNull('expected_result_date')
            ->where('expected_result_date', '<=', now()->addDays($days))
            ->orderBy('expected_result_date');
    }

    /**
     * Scope للطلبات المتأخرة
     */
    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress'])
            ->whereNotNull('expected_result_date')
            ->where('expected_result_date', '<', now())
            ->orderBy('expected_result_date');
    }
}
