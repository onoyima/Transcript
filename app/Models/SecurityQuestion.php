<?php

// app/Models/SecurityQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    use HasFactory;

    protected $table = 'security_questions';

    protected $fillable = [
        'student_id', 'question', 'answer'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

