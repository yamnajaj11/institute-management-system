<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseRepo;

    public function __construct(CourseRepositoryInterface $courseRepo)
    {
        $this->courseRepo = $courseRepo;
    }

    /**
     * Display a listing of the courses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $courses = $this->courseRepo->all();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // تم إزالة الحاجة لجلب المعلمين من المتحكم
        $subjects = Subject::all();
        return view('admin.courses.create', compact('subjects'));
    }

    /**
     * Store a newly created course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $course = $this->courseRepo->create($validated);
        
        if (isset($validated['subjects'])) {
            $course->subjects()->sync($validated['subjects']);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $course = $this->courseRepo->find($id);
        $teachers = User::where('role', 'teacher')->get();
        $subjects = Subject::all();
        return view('admin.courses.edit', compact('course', 'teachers', 'subjects'));
    }

    /**
     * Update the specified course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $course = $this->courseRepo->update($id, $validated);

        if (isset($validated['subjects'])) {
            $course->subjects()->sync($validated['subjects']);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->courseRepo->delete($id);

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }
}
