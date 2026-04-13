<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = ['budget_period_id', 'department_id', 'prepared_by', 'approved_by', 'total_budget', 'total_spent', 'status', 'approved_at', 'notes'];
    protected $casts    = ['total_budget' => 'decimal:2', 'total_spent' => 'decimal:2', 'approved_at' => 'datetime'];

    public function budgetPeriod(): BelongsTo { return $this->belongsTo(BudgetPeriod::class); }
    public function department(): BelongsTo   { return $this->belongsTo(Department::class); }
    public function preparedBy(): BelongsTo   { return $this->belongsTo(Admin::class, 'prepared_by'); }
    public function approvedBy(): BelongsTo   { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function lines(): HasMany          { return $this->hasMany(BudgetLine::class); }

    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeDraft($query)    { return $query->where('status', 'draft'); }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->total_budget - $this->total_spent);
    }

    public function getUtilizationAttribute(): float
    {
        if (!$this->total_budget) return 0;
        return round(($this->total_spent / $this->total_budget) * 100, 1);
    }

    public function isOverBudget(): bool
    {
        return $this->total_spent > $this->total_budget;
    }
}
