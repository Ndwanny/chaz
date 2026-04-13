<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public    $timestamps  = false;
    protected $fillable    = ['admin_id', 'action', 'model_type', 'model_id', 'old_values', 'new_values', 'ip_address', 'user_agent', 'url', 'created_at'];
    protected $casts       = ['old_values' => 'array', 'new_values' => 'array', 'created_at' => 'datetime'];

    public function admin(): BelongsTo { return $this->belongsTo(Admin::class); }

    public function scopeForModel($query, string $type, int $id)
    {
        return $query->where('model_type', $type)->where('model_id', $id);
    }

    public function scopeByAdmin($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    public static function record(string $action, string $modelType = null, int $modelId = null, array $old = [], array $new = []): void
    {
        static::create([
            'admin_id'   => session('admin_id'),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->fullUrl(),
            'created_at' => now(),
        ]);
    }
}
