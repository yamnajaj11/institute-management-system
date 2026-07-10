<?php

namespace App\Models;

use App\Models\PaymentDetail; // هذا هو السطر المفقود
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'student_id',
        'total_amount',
        'paid_amount',
        'remaining_amount', // تمت إضافته
        'due_date',         // تمت إضافته
        'notes',
        'payment_date',
        'status',
    ];

    
       protected $casts = [
        'due_date' => 'datetime',
        'payment_date' => 'datetime',
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
        public function details()
    {
         return $this->hasMany(PaymentDetail::class);
    }
}
