<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    protected $fillable = ['name', 'code', 'days_allowed', 'is_paid', 'accrues_monthly', 'gender_specific', 'requires_document', 'description', 'is_active'];
    protected $casts    = ['is_paid' => 'boolean', 'accrues_monthly' => 'boolean', 'requires_document' => 'boolean', 'is_active' => 'boolean'];

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
