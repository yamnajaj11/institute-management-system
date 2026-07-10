<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'max_students',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'section_user', 'section_id', 'user_id');
    }
}