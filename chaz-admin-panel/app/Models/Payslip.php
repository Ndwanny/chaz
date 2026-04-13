<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payslip extends Model
{
    protected $fillable = ['payroll_run_id', 'employee_id', 'basic_salary', 'total_allowances', 'gross_salary', 'total_deductions', 'net_salary', 'paye', 'napsa_employee', 'napsa_employer', 'nhima_employee', 'nhima_employer', 'status', 'paid_at', 'payment_method', 'payment_reference'];
    protected $casts    = [
        'basic_salary'     => 'decimal:2', 'total_allowances'  => 'decimal:2',
        'gross_salary'     => 'decimal:2', 'total_deductions'  => 'decimal:2',
        'net_salary'       => 'decimal:2', 'paye'              => 'decimal:2',
        'napsa_employee'   => 'decimal:2', 'napsa_employer'    => 'decimal:2',
        'nhima_employee'   => 'decimal:2', 'nhima_employer'    => 'decimal:2',
        'paid_at'          => 'datetime',
    ];

    public function payrollRun(): BelongsTo { return $this->belongsTo(PayrollRun::class); }
    public function employee(): BelongsTo   { return $this->belongsTo(Employee::class); }
    public function items(): HasMany        { return $this->hasMany(PayslipItem::class); }
    public function allowances(): HasMany   { return $this->hasMany(PayslipItem::class)->where('item_type', 'allowance'); }
    public function deductions(): HasMany   { return $this->hasMany(PayslipItem::class)->where('item_type', 'deduction'); }

    public function scopePaid($query)    { return $query->where('status', 'paid'); }
    public function scopePending($query) { return $query->where('status', 'pending'); }

    public function isPaid(): bool { return $this->status === 'paid'; }
}
