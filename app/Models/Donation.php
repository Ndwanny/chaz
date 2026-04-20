<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'reference',
        'lenco_reference',
        'collection_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'message',
        'amount',
        'currency',
        'fund',
        'payment_method',
        'mobile_network',
        'status',
        'reason_for_failure',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // ── Accessors ────────────────────────────────────────────────────────────

    public function getDonorNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'mobile_money' => 'Mobile Money',
            'card'         => 'Card',
            default        => ucfirst($this->payment_method),
        };
    }

    public function getNetworkLabelAttribute(): ?string
    {
        return match($this->mobile_network) {
            'mtn'    => 'MTN Mobile Money',
            'airtel' => 'Airtel Money',
            'zamtel' => 'Zamtel Kwacha',
            default  => $this->mobile_network,
        };
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
