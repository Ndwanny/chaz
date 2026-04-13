<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    protected $fillable = ['name', 'code', 'location', 'department_id', 'manager_id', 'capacity', 'is_active', 'description'];
    protected $casts    = ['is_active' => 'boolean'];

    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function manager(): BelongsTo    { return $this->belongsTo(Admin::class, 'manager_id'); }
    public function stockEntries(): HasMany { return $this->hasMany(StockEntry::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }
}
