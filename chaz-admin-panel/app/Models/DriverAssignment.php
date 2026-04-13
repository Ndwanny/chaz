<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverAssignment extends Model
{
    protected $fillable = ['vehicle_id', 'driver_id', 'assigned_by', 'start_date', 'end_date', 'is_current', 'notes'];
    protected $casts    = ['start_date' => 'date', 'end_date' => 'date', 'is_current' => 'boolean'];

    public function vehicle(): BelongsTo    { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo     { return $this->belongsTo(Employee::class, 'driver_id'); }
    public function assignedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'assigned_by'); }

    public function scopeCurrent($query)    { return $query->where('is_current', true); }
}
