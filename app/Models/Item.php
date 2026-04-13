<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['name', 'code', 'category_id', 'unit_of_measure', 'unit_cost', 'reorder_level', 'current_stock', 'description', 'specifications', 'is_active'];
    protected $casts    = ['unit_cost' => 'decimal:2', 'current_stock' => 'decimal:2', 'is_active' => 'boolean'];

    public function category(): BelongsTo   { return $this->belongsTo(ItemCategory::class, 'category_id'); }
    public function stockEntries(): HasMany { return $this->hasMany(StockEntry::class); }
    public function purchaseOrderItems(): HasMany { return $this->hasMany(PurchaseOrderItem::class); }
    public function requisitionItems(): HasMany   { return $this->hasMany(RequisitionItem::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }

    public function isLowStock(): bool
    {
        return (float) $this->current_stock <= (float) $this->reorder_level;
    }
}
