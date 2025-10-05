<?php

// app/Models/PaymentTransaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'student_trans_id', 
        'rrr', 
        'amount', 
        'transaction_status', 
        'payment_method',
        'transaction_reference',
        'payment_date',
        'payment_response',
        'notes'
    ];

    protected $casts = [
        'payment_response' => 'array',
        'payment_date' => 'datetime'
    ];

    public function studentTrans()
    {
        return $this->belongsTo(StudentTrans::class);
    }
}

