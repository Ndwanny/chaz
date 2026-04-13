<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollPeriod extends Model
{
    protected $fillable = ['year', 'month', 'name', 'start_date', 'end_date', 'status', 'notes'];
    protected $casts    = ['start_date' => 'date', 'end_date' => 'date'];

    public function payrollRuns(): HasMany { return $this->hasMany(PayrollRun::class); }

    public function scopeOpen($query)   { return $query->where('status', 'open'); }
    public function scopeClosed($query) { return $query->where('status', 'closed'); }

    public function getMonthNameAttribute(): string
    {
        return \Carbon\Carbon::create($this->year, $this->month)->format('F Y');
    }

    public function isOpen(): bool   { return $this->status === 'open'; }
    public function isClosed(): bool { return $this->status === 'closed'; }
}
