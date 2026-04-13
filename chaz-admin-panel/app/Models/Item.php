<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['name', 'code', 'sku', 'category_id', 'supplier_id', 'unit', 'unit_price', 'reorder_level', 'reorder_quantity', 'description', 'is_active'];
    protected $casts    = ['unit_price' => 'decimal:2', 'is_active' => 'boolean'];

    public function category(): BelongsTo   { return $this->belongsTo(ItemCategory::class, 'category_id'); }
    public function supplier(): BelongsTo   { return $this->belongsTo(Supplier::class); }
    public function stockEntries(): HasMany { return $this->hasMany(StockEntry::class); }
    public function purchaseOrderItems(): HasMany { return $this->hasMany(PurchaseOrderItem::class); }
    public function requisitionItems(): HasMany   { return $this->hasMany(RequisitionItem::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }

    public function getCurrentStockAttribute(): float
    {
        $in  = $this->stockEntries()->where('entry_type', 'in')->sum('quantity');
        $out = $this->stockEntries()->where('entry_type', 'out')->sum('quantity');
        return (float) ($in - $out);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->reorder_level;
    }
}
