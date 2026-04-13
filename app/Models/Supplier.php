<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = ['name', 'code', 'contact_person', 'email', 'phone', 'address', 'city', 'country', 'tpin', 'registration_number', 'bank_name', 'bank_account', 'bank_branch', 'payment_terms', 'rating', 'is_active', 'notes'];
    protected $casts    = ['is_active' => 'boolean', 'rating' => 'decimal:1'];

    public function purchaseOrders(): HasMany { return $this->hasMany(PurchaseOrder::class); }
    public function items(): HasMany          { return $this->hasMany(Item::class); }

    public function scopeActive($query)       { return $query->where('is_active', true); }

    public function getRatingLabelAttribute(): string
    {
        return match(true) {
            $this->rating >= 4.5 => 'Excellent',
            $this->rating >= 3.5 => 'Good',
            $this->rating >= 2.5 => 'Average',
            $this->rating >= 1.5 => 'Poor',
            default              => 'Unrated',
        };
    }
}
