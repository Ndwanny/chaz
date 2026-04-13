<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelLog extends Model
{
    protected $fillable = ['vehicle_id', 'driver_id', 'log_date', 'litres', 'unit_cost', 'total_cost', 'odometer_reading', 'fuel_station', 'receipt_number', 'notes', 'created_by'];
    protected $casts    = ['log_date' => 'date', 'litres' => 'decimal:2', 'unit_cost' => 'decimal:2', 'total_cost' => 'decimal:2'];

    public function vehicle(): BelongsTo { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo  { return $this->belongsTo(Employee::class, 'driver_id'); }
    public function createdBy(): BelongsTo { return $this->belongsTo(Admin::class, 'created_by'); }
}
