<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    protected $fillable = ['registration', 'make', 'model', 'year', 'color', 'category_id', 'department_id', 'chassis_number', 'engine_number', 'fuel_type', 'engine_capacity', 'seating_capacity', 'purchase_date', 'purchase_price', 'current_mileage', 'status', 'assigned_driver_id', 'notes', 'image'];
    protected $casts    = ['purchase_date' => 'date', 'purchase_price' => 'decimal:2', 'is_active' => 'boolean'];

    public function category(): BelongsTo          { return $this->belongsTo(VehicleCategory::class, 'category_id'); }
    public function department(): BelongsTo        { return $this->belongsTo(Department::class); }
    public function assignedDriver(): BelongsTo    { return $this->belongsTo(Employee::class, 'assigned_driver_id'); }
    public function insurances(): HasMany          { return $this->hasMany(VehicleInsurance::class); }
    public function fuelLogs(): HasMany            { return $this->hasMany(FuelLog::class); }
    public function maintenanceRecords(): HasMany  { return $this->hasMany(MaintenanceRecord::class); }
    public function tripLogs(): HasMany            { return $this->hasMany(TripLog::class); }
    public function driverAssignments(): HasMany   { return $this->hasMany(DriverAssignment::class); }
    public function currentInsurance(): HasOne     { return $this->hasOne(VehicleInsurance::class)->where('status', 'active')->latest('expiry_date'); }

    public function scopeActive($query)     { return $query->where('status', 'active'); }
    public function scopeAvailable($query)  { return $query->where('status', 'available'); }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->year} {$this->make} {$this->model} ({$this->registration})";
    }

    public function isAvailable(): bool { return $this->status === 'available'; }
    public function isActive(): bool    { return in_array($this->status, ['active', 'available']); }
}
