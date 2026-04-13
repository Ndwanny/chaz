<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollRun extends Model
{
    protected $fillable = ['payroll_period_id', 'run_by', 'approved_by', 'status', 'total_gross', 'total_deductions', 'total_net', 'employee_count', 'run_at', 'approved_at', 'notes'];
    protected $casts    = ['total_gross' => 'decimal:2', 'total_deductions' => 'decimal:2', 'total_net' => 'decimal:2', 'run_at' => 'datetime', 'approved_at' => 'datetime'];

    public function payrollPeriod(): BelongsTo { return $this->belongsTo(PayrollPeriod::class); }
    public function runBy(): BelongsTo         { return $this->belongsTo(Admin::class, 'run_by'); }
    public function approvedBy(): BelongsTo    { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function payslips(): HasMany        { return $this->hasMany(Payslip::class); }

    public function scopeDraft($query)    { return $query->where('status', 'draft'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopePaid($query)     { return $query->where('status', 'paid'); }

    public function isDraft(): bool    { return $this->status === 'draft'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isPaid(): bool     { return $this->status === 'paid'; }
}
