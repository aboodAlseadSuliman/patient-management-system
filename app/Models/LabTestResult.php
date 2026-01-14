<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'lab_test_id',
        'attachment_file_id',
        'test_date',
        'result_value',
        'reference_range',
        'unit',
        'is_normal',
        'previous_value',
        'previous_test_date',
        'notes',
    ];

    protected $casts = [
        'test_date' => 'date',
        'previous_test_date' => 'date',
        'is_normal' => 'boolean',
    ];

    /**
     * العلاقة مع الزيارة
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * العلاقة مع التحليل
     */
    public function labTest(): BelongsTo
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * العلاقة مع ملف المرفق (اختياري)
     */
    public function attachmentFile(): BelongsTo
    {
        return $this->belongsTo(VisitAttachmentFile::class, 'attachment_file_id');
    }

    /**
     * الحصول على الحالة (طبيعي/غير طبيعي/غير محدد)
     */
    public function getStatusAttribute(): string
    {
        if ($this->is_normal === null) {
            return 'غير محدد';
        }
        return $this->is_normal ? 'طبيعي' : 'غير طبيعي';
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->is_normal === null) {
            return 'gray';
        }
        return $this->is_normal ? 'success' : 'danger';
    }

    /**
     * الحصول على الفرق بين القيمة الحالية والسابقة
     */
    public function getValueDifferenceAttribute(): ?string
    {
        if (!$this->previous_value || !$this->result_value) {
            return null;
        }

        // محاولة تحويل القيم لأرقام للمقارنة
        if (is_numeric($this->result_value) && is_numeric($this->previous_value)) {
            $diff = floatval($this->result_value) - floatval($this->previous_value);
            $symbol = $diff > 0 ? '↑' : ($diff < 0 ? '↓' : '→');
            return $symbol . ' ' . abs($diff);
        }

        return null;
    }

    /**
     * الحصول على النتيجة مع الوحدة
     */
    public function getFormattedResultAttribute(): string
    {
        if (!$this->result_value) {
            return '-';
        }
        return $this->result_value . ($this->unit ? ' ' . $this->unit : '');
    }
}
