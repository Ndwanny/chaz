<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemCategory extends Model
{
    protected $fillable = ['name', 'code', 'parent_id', 'description', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function parent(): BelongsTo    { return $this->belongsTo(ItemCategory::class, 'parent_id'); }
    public function children(): HasMany    { return $this->hasMany(ItemCategory::class, 'parent_id'); }
    public function items(): HasMany       { return $this->hasMany(Item::class, 'category_id'); }

    public function scopeActive($query)    { return $query->where('is_active', true); }
    public function scopeRoots($query)     { return $query->whereNull('parent_id'); }
}
