<?php

// app/Models/Staff.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'fname', 'lname', 'mname', 'maiden_name', 'dob', 'title',
        'nationality', 'state', 'lga_name', 'address', 'city', 'religion',
        'phone', 'email', 'marital_status', 'gender', 'passport', 'signature', 
        'username', 'password', 'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Get the roles assigned to this staff member.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(TranscriptRole::class, 'transcript_staff_roles', 'staff_id', 'role_id')
                    ->withPivot(['assigned_at', 'assigned_by', 'is_active'])
                    ->withTimestamps();
    }

    /**
     * Get active roles for this staff member.
     */
    public function activeRoles(): BelongsToMany
    {
        return $this->roles()->wherePivot('is_active', true);
    }

    /**
     * Check if staff has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->activeRoles()->where('name', $roleName)->exists();
    }

    /**
     * Check if staff has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->activeRoles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if staff has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->activeRoles()
                    ->with('permissions')
                    ->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->where('name', $permission)
                    ->where('is_active', true)
                    ->isNotEmpty();
    }

    /**
     * Assign a role to this staff member.
     */
    public function assignRole($role, $assignedBy = null): void
    {
        // Handle both Role objects and role name strings
        if (is_string($role)) {
            $roleObject = TranscriptRole::where('name', $role)->first();
            if (!$roleObject) {
                throw new \InvalidArgumentException("Role '{$role}' not found.");
            }
            $role = $roleObject;
        }

        if (!$this->hasRole($role->name)) {
            $this->roles()->attach($role, [
                'assigned_at' => now(),
                'assigned_by' => is_object($assignedBy) ? $assignedBy->id : $assignedBy,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Remove a role from this staff member.
     */
    public function removeRole($role): void
    {
        // Handle both Role objects and role name strings
        if (is_string($role)) {
            $roleObject = TranscriptRole::where('name', $role)->first();
            if (!$roleObject) {
                throw new \InvalidArgumentException("Role '{$role}' not found.");
            }
            $role = $roleObject;
        }

        $this->roles()->detach($role);
    }

    /**
     * Get staff's full name.
     */
    public function getFullNameAttribute(): string
    {
        $names = array_filter([
            $this->fname,
            $this->middle_name,
            $this->lname
        ]);
        
        return implode(' ', $names);
    }

    /**
     * Get staff's initials.
     */
    public function getInitialsAttribute(): string
    {
        $firstInitial = $this->fname ? strtoupper(substr($this->fname, 0, 1)) : '';
        $lastInitial = $this->lname ? strtoupper(substr($this->lname, 0, 1)) : '';
        
        return $firstInitial . $lastInitial;
    }

    /**
     * Get staff's passport photo URL.
     */
    public function getPassportUrlAttribute(): ?string
    {
        if ($this->passport) {
            try {
                // If passport is stored as blob data, convert to base64 data URL
                if (is_resource($this->passport)) {
                    // Handle blob resource
                    $blobData = stream_get_contents($this->passport);
                    if ($blobData !== false && !empty($blobData)) {
                        return 'data:image/jpeg;base64,' . base64_encode($blobData);
                    }
                } elseif (is_string($this->passport)) {
                    // If it's already a data URL, return as is
                    if (str_starts_with($this->passport, 'data:')) {
                        return $this->passport;
                    }
                    
                    // Check if it's base64 encoded data (common JPEG base64 starts with /9j/)
                    if (base64_decode($this->passport, true) !== false) {
                        return 'data:image/jpeg;base64,' . $this->passport;
                    }
                    
                    // If it's a file path (but not base64), return asset URL
                    if ((str_contains($this->passport, '/') || str_contains($this->passport, '\\')) 
                        && !str_starts_with($this->passport, '/9j/')) {
                        return asset('storage/' . $this->passport);
                    }
                    
                    // Otherwise, treat as binary data and encode it
                    if (!empty($this->passport)) {
                        return 'data:image/jpeg;base64,' . base64_encode($this->passport);
                    }
                }
            } catch (\Exception $e) {
                // Log error and return null
                \Log::error('Error processing passport image for staff ' . $this->id . ': ' . $e->getMessage());
            }
        }
        return null;
    }

    /**
     * Get staff's display name (first name + surname).
     */
    public function getDisplayNameAttribute(): string
    {
        return trim($this->fname . ' ' . $this->lname);
    }

    /**
     * Get all permissions for this staff member.
     */
    public function getAllPermissions()
    {
        return $this->activeRoles()
                    ->with('permissions')
                    ->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->where('is_active', true)
                    ->unique('name');
    }

    /**
     * Set the password attribute.
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Scope for active staff.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
