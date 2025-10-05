<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TranscriptRole extends Model
{
    use HasFactory;

    protected $table = 'transcript_roles';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the permissions for this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(TranscriptPermission::class, 'transcript_role_permissions', 'role_id', 'permission_id');
    }

    /**
     * Get the staff members with this role.
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'transcript_staff_roles', 'role_id', 'staff_id')
                    ->withPivot(['assigned_at', 'assigned_by', 'is_active'])
                    ->withTimestamps();
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Assign permission to role.
     */
    public function assignPermission(Permission $permission): void
    {
        if (!$this->hasPermission($permission->name)) {
            $this->permissions()->attach($permission);
        }
    }

    /**
     * Remove permission from role.
     */
    public function removePermission(Permission $permission): void
    {
        $this->permissions()->detach($permission);
    }

    /**
     * Scope for active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get role by name.
     */
    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }
}