<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['exp_number', 'category_id', 'department_id', 'budget_id', 'employee_id', 'submitted_by', 'approved_by', 'title', 'description', 'amount', 'currency', 'exchange_rate', 'amount_zmw', 'expense_date', 'payment_method', 'receipt_path', 'status', 'approved_at', 'paid_at', 'rejection_reason', 'notes'];
    protected $casts    = ['amount' => 'decimal:2', 'amount_zmw' => 'decimal:2', 'exchange_rate' => 'decimal:4', 'expense_date' => 'date', 'approved_at' => 'datetime', 'paid_at' => 'datetime'];

    public function category(): BelongsTo    { return $this->belongsTo(ExpenseCategory::class, 'category_id'); }
    public function department(): BelongsTo  { return $this->belongsTo(Department::class); }
    public function budget(): BelongsTo      { return $this->belongsTo(Budget::class); }
    public function employee(): BelongsTo    { return $this->belongsTo(Employee::class); }
    public function submittedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'submitted_by'); }
    public function approvedBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'approved_by'); }

    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeApproved($query)  { return $query->where('status', 'approved'); }
    public function scopePaid($query)      { return $query->where('status', 'paid'); }
    public function scopeRejected($query)  { return $query->where('status', 'rejected'); }

    public static function generateExpNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'EXP-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isPaid(): bool     { return $this->status === 'paid'; }
}
