<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mark;
use App\Models\Test;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FinalExamMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $marks = Mark::with(['student', 'test.subject'])
            ->where('is_final_exam', true)
            ->get();

        return view('admin.final_exam_marks.index', compact('marks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subject::all();
        $students = User::where('role', 'student')
            ->with(['finalExamMarks.test.subject'])
            ->get();

        return view('admin.final_exam_marks.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'test_id' => 'required|exists:tests,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);

        Mark::create([
            'student_id' => $request->student_id,
            'test_id' => $request->test_id,
            'mark' => $request->mark,
            'is_final_exam' => true,
        ]);

        return redirect()->route('admin.final_exam_marks.index')->with('success', 'تم إضافة العلامة النهائية بنجاح');
    }
    
    /**
     * Store or update bulk final exam marks in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkStore(Request $request)
    {
        // Validate the incoming marks
        $request->validate([
            'marks' => 'required|array',
            'marks.*.*' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            $submittedMarks = $request->input('marks');

            foreach ($submittedMarks as $studentId => $subjects) {
                // Find the student
                $student = User::find($studentId);
                if (!$student) {
                    continue;
                }

                foreach ($subjects as $subjectId => $mark) {
                    // Skip if mark is null or empty
                    if ($mark === null || $mark === '') {
                        continue;
                    }

                    // Find the test for the subject, or create it if it doesn't exist
                    $test = Test::firstOrCreate(
                        ['subject_id' => $subjectId, 'name' => 'final_exam'],
                        ['test_date' => now()]
                    );

                    // Use updateOrCreate to handle both new and existing marks
                    Mark::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'test_id' => $test->id,
                            'is_final_exam' => true
                        ],
                        [
                            'mark' => $mark
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()->route('admin.final_exam_marks.index')->with('success', 'تم حفظ جميع العلامات بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء حفظ العلامات. يرجى المحاولة مرة أخرى.'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $mark = Mark::findOrFail($id);
        $subjects = Subject::all();
        $students = User::where('role', 'student')->get();
        // تم إزالة fetching $tests
        // تم تعديل fetching $subjects to be able to use it in the view as a replacement for tests.

        return view('admin.final_exam_marks.edit', compact('mark', 'subjects', 'students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // تم تعديل validation لاستخدام subject_id بدلاً من test_id
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'mark' => 'required|numeric|min:0|max:100',
        ]);

        $mark = Mark::findOrFail($id);
        
        // Find the test for the subject, or create it if it doesn't exist
        $test = Test::firstOrCreate(
            ['subject_id' => $request->subject_id, 'name' => 'final_exam'],
            ['test_date' => now()]
        );

        $mark->update([
            'student_id' => $request->student_id,
            'test_id' => $test->id,
            'mark' => $request->mark,
        ]);

        return redirect()->route('admin.final_exam_marks.index')->with('success', 'تم تحديث العلامة النهائية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $mark = Mark::findOrFail($id);
        $mark->delete();

        return redirect()->route('admin.final_exam_marks.index')->with('success', 'تم حذف العلامة النهائية بنجاح.');
    }
}
