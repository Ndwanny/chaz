<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $fillable = ['name', 'email', 'password', 'role', 'role_id', 'department_id', 'staff_id', 'phone', 'avatar', 'is_active', 'two_fa_enabled', 'last_password_change'];
    protected $hidden   = ['password'];
    protected $casts    = ['is_active' => 'boolean', 'two_fa_enabled' => 'boolean', 'last_password_change' => 'datetime'];

    // Relationships
    public function roleModel(): BelongsTo     { return $this->belongsTo(Role::class, 'role_id'); }
    public function department(): BelongsTo    { return $this->belongsTo(Department::class); }
    public function auditLogs(): HasMany       { return $this->hasMany(AuditLog::class); }
    public function announcements(): HasMany   { return $this->hasMany(Announcement::class, 'created_by'); }

    // Permission check using session (fast, no DB hit per request)
    public function hasPermission(string $slug): bool
    {
        $permissions = session('admin_permissions', []);
        if (in_array('super_admin', $permissions)) return true;
        return in_array($slug, $permissions);
    }

    // Alias
    public function can(string $slug): bool { return $this->hasPermission($slug); }

    // Load permissions from DB (called once on login)
    public function loadPermissions(): array
    {
        if (!$this->role_id) return [];
        return $this->roleModel
            ->permissions()
            ->pluck('slug')
            ->toArray();
    }

    public function scopeActive($query)  { return $query->where('is_active', true); }

    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }
}
