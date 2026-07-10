<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'name', 'test_date'];

    /**
     * العلاقة مع المادة.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * العلاقة مع العلامات.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class, 'test_id');
    }

    /**
     * تحميل البيانات مع المادة.
     */
    public static function withSubject()
    {
        return self::with('subject');
    }
}
