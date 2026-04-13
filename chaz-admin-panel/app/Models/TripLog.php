<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripLog extends Model
{
    protected $fillable = ['trip_number', 'vehicle_id', 'driver_id', 'requested_by', 'approved_by', 'purpose', 'destination', 'departure_location', 'departure_datetime', 'return_datetime', 'actual_departure', 'actual_return', 'start_mileage', 'end_mileage', 'distance_covered', 'passengers', 'status', 'notes', 'approved_at'];
    protected $casts    = ['departure_datetime' => 'datetime', 'return_datetime' => 'datetime', 'actual_departure' => 'datetime', 'actual_return' => 'datetime', 'approved_at' => 'datetime', 'passengers' => 'array'];

    public function vehicle(): BelongsTo    { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo     { return $this->belongsTo(Employee::class, 'driver_id'); }
    public function requestedBy(): BelongsTo{ return $this->belongsTo(Admin::class, 'requested_by'); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'approved_by'); }
    public function fuelLogs(): HasMany     { return $this->hasMany(FuelLog::class, 'trip_id'); }

    public function scopePending($query)    { return $query->where('status', 'pending'); }
    public function scopeApproved($query)   { return $query->where('status', 'approved'); }
    public function scopeOngoing($query)    { return $query->where('status', 'ongoing'); }
    public function scopeCompleted($query)  { return $query->where('status', 'completed'); }

    public static function generateTripNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'TRIP-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getDistanceAttribute(): float
    {
        if ($this->start_mileage && $this->end_mileage) {
            return (float) ($this->end_mileage - $this->start_mileage);
        }
        return (float) ($this->distance_covered ?? 0);
    }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isOngoing(): bool   { return $this->status === 'ongoing'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }
}
