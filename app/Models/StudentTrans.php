<?php

// app/Models/StudentTrans.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrans extends Model
{
    use HasFactory;

    protected $table = 'student_trans';

    protected $fillable = [
        'student_id', 'email', 'phone', 'application_type', 'payment_status', 
        'application_status', 'category', 'type', 'destination', 'courier',
        'institution_name', 'ref_no', 'institutional_phone', 'institutional_email',
        'number_of_copies', 'delivery_address', 'purpose', 'total_amount'
    ];

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the type attribute (maps application_type to type for view compatibility)
     */
    public function getTypeAttribute()
    {
        return $this->application_type ?? 'official';
    }

    /**
     * Get the status attribute (maps application_status to status for view compatibility)
     */
    public function getStatusAttribute()
    {
        return $this->application_status ?? 'pending';
    }

    /**
     * Get the payment relationship (returns the latest payment transaction)
     */
    public function getPaymentAttribute()
    {
        return $this->paymentTransactions()->latest()->first();
    }
}
