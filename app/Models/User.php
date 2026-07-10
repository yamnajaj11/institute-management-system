<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // تعريف الأدوار
    const ROLE_ADMIN = 'admin';
    const ROLE_STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'student_id',
        'password',
        'role',
        'father_name',
        'mother_name',
        'gender',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * هل المستخدم لديه صلاحيات المدير؟
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * هل المستخدم طالب؟
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    /**
     * استرجاع جميع المدفوعات التابعة للمستخدم.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id');
    }
    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id');
    }

    public function finalExamMarks(): HasMany
    {
        return $this->hasMany(Mark::class, 'student_id')->whereHas('test', function ($query) {
            $query->where('name', 'final_exam');
        });
    }

    /**
     * استرجاع جميع الدورات التي يدرسها الطالب.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')->withTimestamps();
    }
    public function sections()
{
    return $this->belongsToMany(Section::class);
}
}