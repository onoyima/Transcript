<?php

// app/Models/Program.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'name', 'code', 'degree', 'masters', 'academic_department_id', 'duration', 'status'
    ];

    // Define a relationship with StudentAcademic (program assigned to a student)
    public function studentAcademics()
    {
        return $this->hasMany(StudentAcademic::class, 'program_id');
    }
}
