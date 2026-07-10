<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'date',
        'status',
    ];

    /**
     * Get the student that owns the attendance record.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}