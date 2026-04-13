<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionItem extends Model
{
    protected $fillable = ['requisition_id', 'item_id', 'description', 'quantity', 'unit', 'estimated_unit_price', 'estimated_total', 'notes'];
    protected $casts    = ['quantity' => 'decimal:2', 'estimated_unit_price' => 'decimal:2', 'estimated_total' => 'decimal:2'];

    public function requisition(): BelongsTo { return $this->belongsTo(Requisition::class); }
    public function item(): BelongsTo        { return $this->belongsTo(Item::class); }
}
