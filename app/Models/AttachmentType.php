<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttachmentType extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'icon',
        'category',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * الحصول على المرفقات من هذا النوع
     */
    public function attachmentFiles(): HasMany
    {
        return $this->hasMany(VisitAttachmentFile::class);
    }

    /**
     * Scope للأنواع الفعالة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للترتيب حسب display_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope للتصفية حسب التصنيف
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * الحصول على الاسم الكامل مع الأيقونة
     */
    public function getFullNameAttribute(): string
    {
        return $this->icon . ' ' . $this->name_ar;
    }
}
