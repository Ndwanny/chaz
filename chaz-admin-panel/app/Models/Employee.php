<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id', 'staff_number', 'first_name', 'last_name', 'other_names',
        'gender', 'date_of_birth', 'national_id', 'nrc_number', 'department_id',
        'designation', 'employment_type', 'contract_start_date', 'contract_end_date',
        'salary_grade_id', 'basic_salary', 'bank_name', 'bank_account', 'bank_branch',
        'napsa_number', 'tpin', 'medical_aid_provider', 'medical_aid_number',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
        'address', 'province', 'district', 'photo', 'status', 'hired_at', 'terminated_at', 'notes',
    ];

    protected $casts = [
        'date_of_birth'       => 'date',
        'contract_start_date' => 'date',
        'contract_end_date'   => 'date',
        'hired_at'            => 'date',
        'terminated_at'       => 'date',
        'basic_salary'        => 'decimal:2',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function salaryGrade(): BelongsTo
    {
        return $this->belongsTo(SalaryGrade::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function performanceReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function employeeSalaries(): HasMany
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function currentSalary(): HasOne
    {
        return $this->hasOne(EmployeeSalary::class)->where('is_current', true)->latest();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public static function generateStaffNumber(): string
    {
        $last = static::withTrashed()->orderByDesc('id')->first();
        $seq  = $last ? ($last->id + 1) : 1;
        return 'CHAZ-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
