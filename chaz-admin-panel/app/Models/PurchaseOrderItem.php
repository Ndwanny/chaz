<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    protected $fillable = ['purchase_order_id', 'item_id', 'description', 'quantity', 'unit', 'unit_price', 'discount', 'tax_rate', 'total_price', 'quantity_received', 'notes'];
    protected $casts    = ['quantity' => 'decimal:2', 'unit_price' => 'decimal:2', 'discount' => 'decimal:2', 'tax_rate' => 'decimal:2', 'total_price' => 'decimal:2', 'quantity_received' => 'decimal:2'];

    public function purchaseOrder(): BelongsTo { return $this->belongsTo(PurchaseOrder::class); }
    public function item(): BelongsTo          { return $this->belongsTo(Item::class); }

    public function getPendingQuantityAttribute(): float
    {
        return (float) ($this->quantity - $this->quantity_received);
    }

    public function isFullyReceived(): bool
    {
        return $this->quantity_received >= $this->quantity;
    }
}
