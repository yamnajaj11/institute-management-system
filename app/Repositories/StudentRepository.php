<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreStudentRequest;

class StudentRepository implements StudentRepositoryInterface
{
    /**
     * Get all students.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return User::where('role', 'student')->get();
    }

    /**
     * Store a new student.
     *
     * @param StoreStudentRequest $request
     * @return User
     */
    public function store(StoreStudentRequest $request): User
    {
        $data = $request->validated();
        // التحقق من وجود كلمة مرور وتشفيرها
        $data['password'] = Hash::make($data['password']);
        
        // تحديد الدور كطالب
        $data['role'] = 'student';
        
        // إنشاء المستخدم بكافة البيانات التي تم التحقق من صحتها
        return User::create($data);
    }

    /**
     * Find a student by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function edit(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Update a student by ID.
     *
     * @param StoreStudentRequest $request
     * @param int $id
     * @return User
     */
    public function update(StoreStudentRequest $request, int $id): User
    {
        $user = User::find($id);
        $data = $request->validated();

        // Check if password is being updated and hash it
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);
        return $user;
    }

    /**
     * Delete a student by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return User::destroy($id);
    }
     public function search(array $filters): Collection
    {
        $query = User::where('role', 'student');

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('student_id', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['gender']) && $filters['gender'] !== '') {
            $query->where('gender', $filters['gender']);
        }
        
        return $query->get();
    }
}
