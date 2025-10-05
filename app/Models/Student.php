<?php

// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use App\Notifications\StudentEmailVerification;
use App\Notifications\StudentPasswordReset;

class Student extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'username', 'password', 'title', 'lname', 'fname', 'mname', 
        'gender', 'dob', 'nationality', 'state', 'lga_name', 'city', 'religion', 
        'marital_status', 'address', 'phone', 'email', 'passport', 'signature', 
        'hobbies', 'status', 'email_verified_at', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    /**
     * Automatically hash password when setting (only if not already hashed)
     */
    public function setPasswordAttribute($password)
    {
        // Only hash if the password is not already hashed
        if (!empty($password)) {
            // Check if password is already hashed (bcrypt hashes are 60 chars and start with $2y$)
            if (strlen($password) === 60 && str_starts_with($password, '$2y$')) {
                $this->attributes['password'] = $password;
            } else {
                $this->attributes['password'] = Hash::make($password);
            }
        }
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new StudentEmailVerification);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StudentPasswordReset($token));
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Get the email address that should be used for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Get the name that should be used for display.
     */
    public function getDisplayNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->surname);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->surname);
    }

    /**
     * Get the initials for the student.
     */
    public function getInitialsAttribute()
    {
        $firstInitial = $this->first_name ? strtoupper(substr($this->first_name, 0, 1)) : '';
        $lastInitial = $this->surname ? strtoupper(substr($this->surname, 0, 1)) : '';
        return $firstInitial . $lastInitial;
    }

    /**
     * Get the passport photo URL or null if not available.
     */
    public function getPassportUrlAttribute()
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
                \Log::error('Error processing passport image for student ' . $this->id . ': ' . $e->getMessage());
            }
        }
        return null;
    }

    public function studentTrans()
    {
        return $this->hasMany(StudentTrans::class);
    }

    // Define the relationship with the 'StudentAcademic' model
    public function studentAcademic()
    {
        return $this->hasOne(StudentAcademic::class);
    }

    // Define the relationship with the 'StudentContact' model
    public function studentContact()
    {
        return $this->hasOne(StudentContact::class);
    }

    // Define the relationship with the 'StudentMedical' model
    public function studentMedical()
    {
        return $this->hasOne(StudentMedical::class);
    }
}
