<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    protected $fillable = ['po_number', 'supplier_id', 'requisition_id', 'department_id', 'requested_by', 'approved_by', 'status', 'order_date', 'expected_delivery', 'delivery_date', 'total_amount', 'tax_amount', 'grand_total', 'currency', 'exchange_rate', 'payment_terms', 'delivery_address', 'notes', 'approved_at'];
    protected $casts    = ['order_date' => 'date', 'expected_delivery' => 'date', 'delivery_date' => 'date', 'total_amount' => 'decimal:2', 'tax_amount' => 'decimal:2', 'grand_total' => 'decimal:2', 'exchange_rate' => 'decimal:4', 'approved_at' => 'datetime'];

    public function supplier(): BelongsTo     { return $this->belongsTo(Supplier::class); }
    public function requisition(): BelongsTo  { return $this->belongsTo(Requisition::class); }
    public function department(): BelongsTo   { return $this->belongsTo(Department::class); }
    public function requestedBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'requested_by'); }
    public function approvedBy(): BelongsTo   { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function items(): HasMany          { return $this->hasMany(PurchaseOrderItem::class); }

    public function scopeDraft($query)     { return $query->where('status', 'draft'); }
    public function scopePending($query)   { return $query->where('status', 'pending_approval'); }
    public function scopeApproved($query)  { return $query->where('status', 'approved'); }
    public function scopeDelivered($query) { return $query->where('status', 'delivered'); }

    public static function generatePoNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'PO-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function isDraft(): bool    { return $this->status === 'draft'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
}
