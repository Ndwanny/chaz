<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetPeriod extends Model
{
    protected $fillable = ['name', 'financial_year', 'start_date', 'end_date', 'is_active', 'is_locked', 'description'];
    protected $casts    = ['start_date' => 'date', 'end_date' => 'date', 'is_active' => 'boolean', 'is_locked' => 'boolean'];

    public function budgets(): HasMany { return $this->hasMany(Budget::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }

    public function isActive(): bool { return (bool) $this->is_active; }

    public function getTotalBudgetAttribute(): float
    {
        return (float) $this->budgets()->sum('total_budget');
    }

    public function getTotalSpentAttribute(): float
    {
        return (float) $this->budgets()->sum('total_spent');
    }
}
