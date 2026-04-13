<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryGrade extends Model
{
    protected $fillable = ['code', 'name', 'min_salary', 'max_salary', 'basic_salary', 'description', 'is_active'];
    protected $casts    = ['min_salary' => 'decimal:2', 'max_salary' => 'decimal:2', 'basic_salary' => 'decimal:2', 'is_active' => 'boolean'];

    public function employees(): HasMany { return $this->hasMany(Employee::class); }
    public function employeeSalaries(): HasMany { return $this->hasMany(EmployeeSalary::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }
}
