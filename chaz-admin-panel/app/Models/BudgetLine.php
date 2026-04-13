<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetLine extends Model
{
    protected $fillable = ['budget_id', 'account_code', 'description', 'allocated_amount', 'spent_amount', 'committed_amount', 'notes'];
    protected $casts    = ['allocated_amount' => 'decimal:2', 'spent_amount' => 'decimal:2', 'committed_amount' => 'decimal:2'];

    public function budget(): BelongsTo { return $this->belongsTo(Budget::class); }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->allocated_amount - $this->spent_amount - $this->committed_amount);
    }

    public function getUtilizationAttribute(): float
    {
        if ($this->allocated_amount == 0) return 0;
        return round(($this->spent_amount / $this->allocated_amount) * 100, 1);
    }
}
