<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentContact extends Model
{
    use HasFactory;

    protected $table = 'student_contacts';

    protected $fillable = [
        'student_id',
        'title',
        'surname',
        'other_names',
        'address',
        'city',
        'state',
        'phone',
        'email',
        'phone_2',
        'email_2',
        'relationship'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student that owns the contact information.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute()
    {
        return trim($this->other_names . ' ' . $this->surname);
    }

    /**
     * Get the primary contact information.
     */
    public function getPrimaryContactAttribute()
    {
        return [
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }

    /**
     * Get the secondary contact information.
     */
    public function getSecondaryContactAttribute()
    {
        return [
            'phone' => $this->phone_2,
            'email' => $this->email_2,
        ];
    }
}