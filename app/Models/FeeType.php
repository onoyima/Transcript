<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'amount','descriptions', 'provider', 'delivery_code', 'gender_code',
        'provider_code', 'status', 'category', 'college_id', 'installment',
        'percentage'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
