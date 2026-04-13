<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Requisition extends Model
{
    protected $fillable = ['req_number', 'department_id', 'requested_by', 'approved_by', 'status', 'priority', 'required_by', 'purpose', 'notes', 'approved_at', 'rejected_reason'];
    protected $casts    = ['required_by' => 'date', 'approved_at' => 'datetime'];

    public function department(): BelongsTo   { return $this->belongsTo(Department::class); }
    public function requestedBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'requested_by'); }
    public function approvedBy(): BelongsTo   { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function items(): HasMany          { return $this->hasMany(RequisitionItem::class); }
    public function purchaseOrder(): HasOne   { return $this->hasOne(PurchaseOrder::class); }

    public function scopePending($query)  { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }

    public static function generateReqNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'REQ-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
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

    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
}
