<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayslipItem extends Model
{
    protected $fillable = ['payslip_id', 'salary_component_id', 'item_type', 'name', 'calculation_type', 'rate', 'amount'];
    protected $casts    = ['rate' => 'decimal:4', 'amount' => 'decimal:2'];

    public function payslip(): BelongsTo          { return $this->belongsTo(Payslip::class); }
    public function salaryComponent(): BelongsTo  { return $this->belongsTo(SalaryComponent::class); }

    public function isAllowance(): bool { return $this->item_type === 'allowance'; }
    public function isDeduction(): bool { return $this->item_type === 'deduction'; }
    public function isTax(): bool       { return $this->item_type === 'tax'; }
}
