<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'role_id', 'department_id', 'staff_id', 'phone', 'avatar', 'is_active', 'two_fa_enabled', 'last_password_change', 'last_login_at'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['is_active' => 'boolean', 'two_fa_enabled' => 'boolean', 'last_password_change' => 'datetime', 'last_login_at' => 'datetime'];

    // Legacy helper (backward compat)
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin' || ($this->role_id && $this->roleModel && $this->roleModel->slug === 'super_admin');
    }

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

    // Alias — compatible with Authenticatable's can() signature
    public function can($ability, $arguments = []): bool
    {
        if (is_string($ability)) return $this->hasPermission($ability);
        return parent::can($ability, $arguments);
    }

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
