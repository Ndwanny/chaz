<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleCategory extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function vehicles(): HasMany { return $this->hasMany(Vehicle::class, 'category_id'); }

    public function scopeActive($query) { return $query->where('is_active', true); }
}
