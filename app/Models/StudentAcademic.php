<?php

// app/Models/StudentAcademic.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAcademic extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'student_academics';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'student_id', 'mode_of_entry', 'mode_of_study', 'matric_no', 'program_id',
        'level', 'entry_session_id', 'semester', 'first_semester_load', 'second_semester_load',
        'program_type', 'TC', 'TGP', 'status'
    ];

    // If you're not using the default timestamps, you can disable it
    public $timestamps = true;

    // Optionally, if you want to specify the date format for timestamps
    protected $dateFormat = 'Y-m-d H:i:s';

    // Relationships (If any)
    // public function student()
    // {
    //     return $this->belongsTo(Student::class, 'student_id');
    // }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    // Relationship with Program model
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    // Additional methods or accessors/mutators can be added here
}
