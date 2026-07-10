<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;

class CourseRepository implements CourseRepositoryInterface
{
    /**
     * Get all courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Course::with(['teacher', 'subjects', 'students'])->get();
    }

    /**
     * Find a course by its ID.
     *
     * @param int $id
     * @return \App\Models\Course
     */
    public function find($id)
    {
        return Course::with(['teacher', 'subjects', 'students'])->findOrFail($id);
    }

    /**
     * Create a new course.
     *
     * @param array $data
     * @return \App\Models\Course
     */
    public function create(array $data)
    {
        return Course::create($data);
    }

    /**
     * Update a course.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Course
     */
    public function update($id, array $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    /**
     * Delete a course.
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
    }
}
