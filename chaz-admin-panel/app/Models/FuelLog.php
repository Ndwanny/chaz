<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelLog extends Model
{
    protected $fillable = ['vehicle_id', 'driver_id', 'date', 'fuel_type', 'quantity', 'unit_price', 'total_cost', 'mileage_before', 'mileage_after', 'fuel_efficiency', 'station', 'receipt_number', 'trip_id', 'notes', 'recorded_by'];
    protected $casts    = ['date' => 'date', 'quantity' => 'decimal:2', 'unit_price' => 'decimal:2', 'total_cost' => 'decimal:2', 'fuel_efficiency' => 'decimal:2'];

    public function vehicle(): BelongsTo    { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo     { return $this->belongsTo(Employee::class, 'driver_id'); }
    public function trip(): BelongsTo       { return $this->belongsTo(TripLog::class, 'trip_id'); }
    public function recordedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'recorded_by'); }

    public function calculateEfficiency(): float
    {
        if ($this->mileage_before && $this->mileage_after && $this->quantity > 0) {
            return round(($this->mileage_after - $this->mileage_before) / $this->quantity, 2);
        }
        return 0;
    }
}
