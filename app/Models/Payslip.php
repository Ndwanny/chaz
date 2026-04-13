<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payslip extends Model
{
    protected $fillable = ['payroll_run_id', 'payroll_period_id', 'employee_id', 'basic_salary', 'total_allowances', 'total_deductions', 'total_tax', 'net_pay', 'working_days', 'days_worked', 'leave_days_deducted', 'status', 'issued_at'];
    protected $casts    = [
        'basic_salary'    => 'decimal:2', 'total_allowances' => 'decimal:2',
        'total_deductions'=> 'decimal:2', 'total_tax'        => 'decimal:2',
        'net_pay'         => 'decimal:2', 'issued_at'        => 'datetime',
    ];

    public function payrollRun(): BelongsTo { return $this->belongsTo(PayrollRun::class); }
    public function employee(): BelongsTo   { return $this->belongsTo(Employee::class); }
    public function items(): HasMany        { return $this->hasMany(PayslipItem::class); }
    public function allowances(): HasMany   { return $this->hasMany(PayslipItem::class)->where('item_type', 'allowance'); }
    public function deductions(): HasMany   { return $this->hasMany(PayslipItem::class)->where('item_type', 'deduction'); }
    public function taxes(): HasMany        { return $this->hasMany(PayslipItem::class)->where('item_type', 'tax'); }

    public function scopeIssued($query)  { return $query->where('status', 'issued'); }
    public function scopeDraft($query)   { return $query->where('status', 'draft'); }

    public function isPaid(): bool { return in_array($this->status, ['paid', 'issued']); }
}
