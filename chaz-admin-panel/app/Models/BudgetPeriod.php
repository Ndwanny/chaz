<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetPeriod extends Model
{
    protected $fillable = ['name', 'fiscal_year', 'start_date', 'end_date', 'status', 'notes'];
    protected $casts    = ['start_date' => 'date', 'end_date' => 'date'];

    public function budgets(): HasMany { return $this->hasMany(Budget::class); }

    public function scopeActive($query) { return $query->where('status', 'active'); }
    public function scopeClosed($query) { return $query->where('status', 'closed'); }

    public function isActive(): bool { return $this->status === 'active'; }

    public function getTotalAllocatedAttribute(): float
    {
        return (float) $this->budgets()->sum('total_allocated');
    }

    public function getTotalSpentAttribute(): float
    {
        return (float) $this->budgets()->sum('total_spent');
    }
}
