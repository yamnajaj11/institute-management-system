<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'test_id',
        'mark',
        'is_final_exam',
    ];

    /**
     * Get the student that owns the mark.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the test that owns the mark.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Accessor to format the mark for display.
     *
     * @param  string  $value
     * @return string
     */
    public function getMarkAttribute($value)
    {
        // يزيل الأصفار الزائدة والفواصل العشرية إذا كانت العلامة رقمًا صحيحًا
        return rtrim(rtrim($value, '0'), '.');
    }
}
