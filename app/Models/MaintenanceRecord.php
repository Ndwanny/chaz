<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    protected $fillable = ['vehicle_id', 'maintenance_type', 'description', 'workshop', 'start_date', 'end_date', 'next_service_date', 'mileage_at_service', 'next_service_mileage', 'cost', 'invoice_number', 'status', 'created_by', 'notes'];
    protected $casts    = ['start_date' => 'date', 'end_date' => 'date', 'next_service_date' => 'date', 'cost' => 'decimal:2'];

    public function vehicle(): BelongsTo   { return $this->belongsTo(Vehicle::class); }
    public function createdBy(): BelongsTo { return $this->belongsTo(Admin::class, 'created_by'); }

    public function scopePending($query)    { return $query->where('status', 'pending'); }
    public function scopeCompleted($query)  { return $query->where('status', 'completed'); }
    public function scopeScheduled($query)  { return $query->where('status', 'scheduled'); }

    public function getTypeLabelAttribute(): string
    {
        return match($this->maintenance_type) {
            'preventive'  => 'Preventive Maintenance',
            'corrective'  => 'Corrective Maintenance',
            'inspection'  => 'Vehicle Inspection',
            'tyres'       => 'Tyre Service',
            'oil_change'  => 'Oil Change',
            'service'     => 'Full Service',
            default       => ucfirst($this->maintenance_type),
        };
    }

    public function isDue(): bool
    {
        if ($this->next_service_date && $this->next_service_date->isPast()) return true;
        return false;
    }
}
