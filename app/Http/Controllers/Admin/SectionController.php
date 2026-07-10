<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Use withCount to get the number of students per section.
        $sections = Section::with('subject')->withCount('students')->latest()->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $subjects = Subject::all();
        return view('admin.sections.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'max_students' => 'required|integer|min:0',
        ]);
        
        try {
            Section::create($validated);
            return redirect()->route('admin.sections.index')->with('success', __('admin.section_created_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating section: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the section.');
        }
    }

    /**
     * Display the specified resource.
     */
   public function show(Section $section): View
    {
        // ✅ هذا السطر صحيح الآن. يقوم بجلب معرفات المستخدمين (الطلاب)
        // المسجلين حاليًا في هذه الشعبة.
        $enrolledUserIds = $section->students()->pluck('users.id');
        
        // ✅ هذا السطر صحيح الآن. يقوم بجلب جميع المستخدمين
        // الذين لديهم دور "student" وغير مسجلين في الشعبة الحالية.
        $availableStudents = User::where('role', 'student')
                                ->whereNotIn('id', $enrolledUserIds)
                                ->get();

        // تحميل علاقة الطلاب للشعبة.
        $section->load('students');

        return view('admin.sections.show', compact('section', 'availableStudents'));
    }
    /**
     * Add a student to the specified section.
     */
    public function addStudent(Request $request, Section $section): RedirectResponse
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    try {
        if ($section->students()->count() >= $section->max_students) {
            return redirect()->back()->with('error', __('admin.section_is_full'));
        }

        if ($section->students()->where('user_id', $validated['user_id'])->exists()) {
            return redirect()->back()->with('error', __('admin.student_already_enrolled'));
        }

        $section->students()->attach($validated['user_id']);

        // ✅ تم تغيير مسار إعادة التوجيه ليعود إلى صفحة "index"
        return redirect()->route('admin.sections.index')->with('success', __('admin.student_added_successfully'));
    } catch (\Exception $e) {
        Log::error('Error adding student to section: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while adding the student to the section.');
    }
}
/**
     * Remove a student from the specified section.
     */
    public function removeStudent(Section $section, User $student): RedirectResponse
    {
        try {
            $section->students()->detach($student->id);
            return redirect()->route('admin.sections.show', $section)->with('success', __('admin.student_removed_successfully'));
        } catch (\Exception $e) {
            Log::error('Error removing student from section: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while removing the student from the section.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section): View
    {
        $subjects = Subject::all();
        return view('admin.sections.edit', compact('section', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'max_students' => 'required|integer|min:0',
        ]);

        try {
            $section->update($validated);
            return redirect()->route('admin.sections.index')->with('success', __('admin.section_updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating section: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the section.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section): RedirectResponse
    {
        try {
            $section->delete();
            return redirect()->route('admin.sections.index')->with('success', __('admin.section_deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting section: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the section.');
        }
    }
}