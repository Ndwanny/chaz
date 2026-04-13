<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryComponent extends Model
{
    protected $fillable = ['name', 'code', 'type', 'calculation_type', 'value', 'is_taxable', 'is_mandatory', 'applies_to', 'description', 'is_active', 'sort_order'];
    protected $casts    = ['value' => 'decimal:4', 'is_taxable' => 'boolean', 'is_mandatory' => 'boolean', 'is_active' => 'boolean'];

    public function payslipItems(): HasMany { return $this->hasMany(PayslipItem::class); }

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('sort_order'); }
    public function scopeAllowances($query) { return $query->where('type', 'allowance'); }
    public function scopeDeductions($query) { return $query->where('type', 'deduction'); }
    public function scopeTax($query)        { return $query->where('type', 'tax'); }

    /**
     * Calculate the component amount based on basic salary.
     */
    public function calculate(float $basicSalary): float
    {
        if ($this->calculation_type === 'percentage') {
            return round($basicSalary * ($this->value / 100), 2);
        }
        return round((float) $this->value, 2);
    }
}
