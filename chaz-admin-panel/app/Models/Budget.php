<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = ['budget_period_id', 'department_id', 'title', 'total_allocated', 'total_spent', 'total_committed', 'status', 'approved_by', 'approved_at', 'notes'];
    protected $casts    = ['total_allocated' => 'decimal:2', 'total_spent' => 'decimal:2', 'total_committed' => 'decimal:2', 'approved_at' => 'datetime'];

    public function budgetPeriod(): BelongsTo { return $this->belongsTo(BudgetPeriod::class); }
    public function department(): BelongsTo   { return $this->belongsTo(Department::class); }
    public function approvedBy(): BelongsTo   { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function lines(): HasMany          { return $this->hasMany(BudgetLine::class); }
    public function expenses(): HasMany       { return $this->hasMany(Expense::class); }

    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeDraft($query)    { return $query->where('status', 'draft'); }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->total_allocated - $this->total_spent - $this->total_committed);
    }

    public function getUtilizationAttribute(): float
    {
        if ($this->total_allocated == 0) return 0;
        return round(($this->total_spent / $this->total_allocated) * 100, 1);
    }

    public function isOverBudget(): bool
    {
        return $this->total_spent > $this->total_allocated;
    }
}
