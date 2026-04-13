<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'category', 'priority', 'target_audience', 'target_id', 'is_published', 'published_at', 'expires_at', 'created_by', 'attachment', 'view_count'];
    protected $casts    = ['is_published' => 'boolean', 'published_at' => 'datetime', 'expires_at' => 'datetime'];

    public function createdBy(): BelongsTo { return $this->belongsTo(Admin::class, 'created_by'); }
    public function updatedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'updated_by'); }

    public function scopePublished($query) { return $query->where('is_published', true)->where(function ($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); }); }
    public function scopeDraft($query)     { return $query->where('is_published', false); }
    public function scopeUrgent($query)    { return $query->where('priority', 'urgent'); }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->is_published && !$this->isExpired();
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent'  => 'red',
            'high'    => 'orange',
            'normal'  => 'blue',
            'low'     => 'grey',
            default   => 'grey',
        };
    }
}
