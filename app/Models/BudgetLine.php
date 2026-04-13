<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetLine extends Model
{
    protected $fillable = ['budget_id', 'account_code', 'description', 'budgeted_amount', 'spent_amount', 'q1_budget', 'q2_budget', 'q3_budget', 'q4_budget', 'notes'];
    protected $casts    = ['budgeted_amount' => 'decimal:2', 'spent_amount' => 'decimal:2', 'q1_budget' => 'decimal:2', 'q2_budget' => 'decimal:2', 'q3_budget' => 'decimal:2', 'q4_budget' => 'decimal:2'];

    public function budget(): BelongsTo  { return $this->belongsTo(Budget::class); }
    public function expenses(): HasMany  { return $this->hasMany(Expense::class); }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->budgeted_amount - $this->spent_amount);
    }

    public function getUtilizationAttribute(): float
    {
        if (!$this->budgeted_amount) return 0;
        return round(($this->spent_amount / $this->budgeted_amount) * 100, 1);
    }
}
