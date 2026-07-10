<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Interfaces\AttendanceRepositoryInterface;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    /**
     * Get all paginated attendance records.
     *
     * @return Paginator
     */
    public function index(): Paginator
    {
        return Attendance::paginate(10);
    }

    /**
     * Store a new attendance record.
     *
     * @param StoreAttendanceRequest $request
     * @return Attendance
     */
    public function store(StoreAttendanceRequest $request): Attendance
    {
        return Attendance::create($request->validated());
    }

    /**
     * Find an attendance record by ID for editing.
     *
     * @param int $id
     * @return Attendance|null
     */
    public function edit(int $id): ?Attendance
    {
        return Attendance::find($id);
    }

    /**
     * Update an existing attendance record.
     *
     * @param UpdateAttendanceRequest $request
     * @param int $id
     * @return Attendance
     */
    public function update(UpdateAttendanceRequest $request, int $id): Attendance
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->validated());
        return $attendance;
    }

    /**
     * Delete an attendance record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $attendance = Attendance::findOrFail($id);
        return $attendance->delete();
    }

    /**
     * Search attendance records with pagination.
     *
     * @param array $filters
     * @return Paginator
     */
    public function search(array $filters): Paginator
    {
        $query = Attendance::query();

        if (isset($filters['search']) && !empty($filters['search'])) {
            $query->whereHas('student', function ($subquery) use ($filters) {
                $subquery->where('name', 'like', "%{$filters['search']}%")
                         ->orWhere('student_id', 'like', "%{$filters['search']}%");
            });
        }
        
        if (isset($filters['date']) && !empty($filters['date'])) {
            $query->where('date', $filters['date']);
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Return a paginated result instead of a collection
        return $query->paginate(15);
    }
}
