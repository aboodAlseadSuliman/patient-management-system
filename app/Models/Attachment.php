<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'title',
        'description',
        'category',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    // ==================== Relationships ====================

    public function attachable()
    {
        return $this->morphTo();
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ==================== Accessors ====================

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $size = $this->file_size;

        if ($size < 1024) {
            return $size . ' KB';
        }

        return round($size / 1024, 2) . ' MB';
    }

    public function getIsImageAttribute(): bool
    {
        return in_array($this->file_type, ['image', 'png', 'jpg', 'jpeg', 'gif']);
    }

    // ==================== Boot ====================

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            if (Storage::exists($attachment->file_path)) {
                Storage::delete($attachment->file_path);
            }
        });
    }
}
