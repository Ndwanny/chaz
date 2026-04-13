<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends Model
{
    protected $fillable = ['employee_id', 'salary_grade_id', 'basic_salary', 'effective_date', 'end_date', 'is_current', 'notes', 'approved_by'];
    protected $casts    = ['basic_salary' => 'decimal:2', 'effective_date' => 'date', 'end_date' => 'date', 'is_current' => 'boolean'];

    public function employee(): BelongsTo    { return $this->belongsTo(Employee::class); }
    public function salaryGrade(): BelongsTo { return $this->belongsTo(SalaryGrade::class); }
    public function approvedBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'approved_by'); }

    public function scopeCurrent($query) { return $query->where('is_current', true); }
}
