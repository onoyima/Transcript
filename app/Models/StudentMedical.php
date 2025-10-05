<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMedical extends Model
{
    use HasFactory;

    protected $table = 'student_medicals';

    protected $fillable = [
        'student_id',
        'physical',
        'blood_group',
        'condition',
        'allergies',
        'genotype'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student that owns the medical information.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the medical summary attribute.
     */
    public function getMedicalSummaryAttribute()
    {
        $summary = [];
        
        if ($this->blood_group) {
            $summary[] = "Blood Group: {$this->blood_group}";
        }
        
        if ($this->genotype) {
            $summary[] = "Genotype: {$this->genotype}";
        }
        
        if ($this->condition) {
            $summary[] = "Condition: {$this->condition}";
        }
        
        if ($this->allergies) {
            $summary[] = "Allergies: {$this->allergies}";
        }
        
        return implode(' | ', $summary);
    }

    /**
     * Check if student has any medical conditions.
     */
    public function hasConditionsAttribute()
    {
        return !empty($this->condition) || !empty($this->allergies);
    }
}