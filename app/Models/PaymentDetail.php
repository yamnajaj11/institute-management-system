<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_id',
        'amount',
        'payment_date',
    ];

    /**
     * Get the payment that owns the payment detail.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
