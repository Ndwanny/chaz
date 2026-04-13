<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripLog extends Model
{
    protected $fillable = ['trip_number', 'vehicle_id', 'driver_id', 'created_by', 'authorized_by', 'purpose', 'destination', 'departure_location', 'departure_date', 'departure_time', 'return_date', 'return_time', 'starting_odometer', 'ending_odometer', 'distance_km', 'fuel_used', 'passenger_count', 'status', 'notes'];
    protected $casts    = ['departure_date' => 'date', 'return_date' => 'date'];

    public function vehicle(): BelongsTo    { return $this->belongsTo(Vehicle::class); }
    public function driver(): BelongsTo     { return $this->belongsTo(Employee::class, 'driver_id'); }
    public function createdBy(): BelongsTo  { return $this->belongsTo(Admin::class, 'created_by'); }
    public function authorizedBy(): BelongsTo { return $this->belongsTo(Admin::class, 'authorized_by'); }

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
        if ($this->starting_odometer && $this->ending_odometer) {
            return (float) ($this->ending_odometer - $this->starting_odometer);
        }
        return (float) ($this->distance_km ?? 0);
    }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isOngoing(): bool   { return $this->status === 'ongoing'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }
}
