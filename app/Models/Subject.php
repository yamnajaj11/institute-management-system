<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * العلاقة مع الاختبارات.
     */
    public function tests()
    {
        return $this->hasMany(Test::class, 'subject_id');
    }

    /**
     * Accessor to format the final mark for display.
     *
     * @param  string  $value
     * @return string
     */
    public function getFinalMarkAttribute($value)
    {
        // يزيل الأصفار الزائدة والفواصل العشرية إذا كانت العلامة رقمًا صحيحًا
        return rtrim(rtrim($value, '0'), '.');
    }
    public function sections()
    {
            return $this->hasMany(Section::class);
    }
}
