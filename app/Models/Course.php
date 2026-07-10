<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
      
        'teacher_id',
    ];

    /**
     * Get the teacher that owns the course.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * The students that are enrolled in the course.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')->withTimestamps()->withPivot('status');
    }

    /**
     * The subjects that belong to the course.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subject', 'course_id', 'subject_id')->withTimestamps();
    }
}