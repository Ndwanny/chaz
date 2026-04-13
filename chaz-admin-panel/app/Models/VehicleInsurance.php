<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleInsurance extends Model
{
    protected $fillable = ['vehicle_id', 'insurer', 'policy_number', 'insurance_type', 'start_date', 'expiry_date', 'premium_amount', 'coverage_amount', 'status', 'document_path', 'notes'];
    protected $casts    = ['start_date' => 'date', 'expiry_date' => 'date', 'premium_amount' => 'decimal:2', 'coverage_amount' => 'decimal:2'];

    public function vehicle(): BelongsTo { return $this->belongsTo(Vehicle::class); }

    public function scopeActive($query)  { return $query->where('status', 'active'); }
    public function scopeExpired($query) { return $query->where('status', 'expired'); }

    public function getDaysToExpiryAttribute(): int
    {
        return (int) now()->diffInDays($this->expiry_date, false);
    }

    public function isExpiringSoon(): bool
    {
        return $this->days_to_expiry <= 30 && $this->days_to_expiry >= 0;
    }

    public function isExpired(): bool { return $this->expiry_date->isPast(); }
    public function isActive(): bool  { return $this->status === 'active' && !$this->isExpired(); }
}
