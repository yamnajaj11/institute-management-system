<?php

namespace App\Interfaces;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

interface AttendanceRepositoryInterface
{
    /**
     * Get all paginated attendance records.
     *
     * @return Paginator
     */
    public function index(): Paginator;

    /**
     * Store a new attendance record.
     *
     * @param StoreAttendanceRequest $request
     * @return Attendance
     */
    public function store(StoreAttendanceRequest $request): Attendance;

    /**
     * Find an attendance record by ID for editing.
     *
     * @param int $id
     * @return Attendance|null
     */
    public function edit(int $id): ?Attendance;

    /**
     * Update an existing attendance record.
     *
     * @param UpdateAttendanceRequest $request
     * @param int $id
     * @return Attendance
     */
    public function update(UpdateAttendanceRequest $request, int $id): Attendance;

    /**
     * Delete an attendance record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Search attendance records with pagination.
     *
     * @param array $filters
     * @return Paginator
     */
    public function search(array $filters): Paginator;
}
