<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockEntry extends Model
{
    protected $fillable = ['item_id', 'warehouse_id', 'entry_type', 'quantity', 'unit_cost', 'total_cost', 'reference_type', 'reference_id', 'batch_number', 'expiry_date', 'notes', 'created_by'];
    protected $casts    = ['unit_cost' => 'decimal:2', 'total_cost' => 'decimal:2', 'expiry_date' => 'date', 'quantity' => 'decimal:2'];

    public function item(): BelongsTo      { return $this->belongsTo(Item::class); }
    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function createdBy(): BelongsTo { return $this->belongsTo(Admin::class, 'created_by'); }

    public function scopeIn($query)        { return $query->where('entry_type', 'in'); }
    public function scopeOut($query)       { return $query->where('entry_type', 'out'); }
    public function scopeAdjustment($query){ return $query->where('entry_type', 'adjustment'); }
}
