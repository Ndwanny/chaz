<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['expense_number', 'expense_category_id', 'employee_id', 'department_id', 'budget_line_id', 'description', 'amount', 'expense_date', 'receipt_number', 'receipt_document', 'payment_method', 'status', 'approved_by', 'approved_at', 'paid_by', 'paid_at', 'rejection_reason', 'notes', 'created_by'];
    protected $casts    = ['amount' => 'decimal:2', 'expense_date' => 'date', 'approved_at' => 'datetime', 'paid_at' => 'datetime'];

    public function category(): BelongsTo   { return $this->belongsTo(ExpenseCategory::class, 'expense_category_id'); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function budgetLine(): BelongsTo { return $this->belongsTo(BudgetLine::class); }
    public function employee(): BelongsTo   { return $this->belongsTo(Employee::class); }
    public function createdBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'created_by'); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function paidBy(): BelongsTo     { return $this->belongsTo(Admin::class, 'paid_by'); }

    public function scopePending($query)  { return $query->where('status', 'submitted'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopePaid($query)     { return $query->where('status', 'paid'); }
    public function scopeRejected($query) { return $query->where('status', 'rejected'); }

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
