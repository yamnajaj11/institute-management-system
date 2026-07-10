<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MarkRepositoryInterface;
use App\Models\User;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class MarkController extends Controller
{
    protected $markRepo;

    public function __construct(MarkRepositoryInterface $markRepo)
    {
        $this->markRepo = $markRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
  public function index(Request $request): View
{
    // ابدأ بجلب كل العلامات
    $marks = $this->markRepo->all()->where('is_final_exam', false);;

    // إذا كان هناك طلب فلترة حسب الاختبار
    if ($request->filled('test_id') && $request->test_id !== 'all') {
        $marks = $marks->where('test_id', $request->test_id);
    }
    
    // جلب كل الاختبارات لعرضها في قائمة الفلترة
    $tests = Test::all();

    return view('admin.marks.index', compact('marks', 'tests'));
}
    /**
     * Show the form for selecting a subject.
     *
     * @return View
     */
    public function selectSubject(): View
    {
        $subjects = Subject::all();
        return view('admin.marks.select_subject', compact('subjects'));
    }

    /**
     * Show the form for selecting a test based on the subject.
     *
     * @param  Request  $request
     * @param  int  $subjectId
     * @return View|JsonResponse|RedirectResponse
     */
    public function selectTest(Request $request, int $subjectId)
    {
        // Get only the regular tests (not the final exam)
        $tests = Test::where('subject_id', $subjectId)
                     ->where('name', '!=', 'final_exam')
                     ->get();

        if ($tests->isEmpty()) {
            session()->flash('warning', 'لا توجد اختبارات مرتبطة بهذه المادة');
            return redirect()->route('admin.marks.selectSubject');
        }

        if ($request->ajax()) {
            return response()->json($tests);
        }
        
        return view('admin.marks.select_test', compact('tests', 'subjectId'));
    }

    /**
     * Show the form for entering marks after selecting subject and test.
     *
     * @param  int  $subjectId
     * @param  int  $testId
     * @return View
     */
    public function addMarks(int $subjectId, int $testId): View
    {
        $students = User::where('role', 'student')->get();
        $subject = Subject::findOrFail($subjectId);
        $test = Test::findOrFail($testId);

        return view('admin.marks.add_marks', compact('students', 'subject', 'test', 'subjectId', 'testId'));
    }

    /**
     * Store or update a mark.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subjectId' => 'required|exists:subjects,id',
            'testId' => 'required|exists:tests,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->marks as $studentId => $mark) {
            $this->markRepo->createOrUpdate([
                'student_id' => $studentId,
                'test_id' => $validated['testId'],
                'mark' => $mark,
            ]);
        }

        return redirect()->route('admin.marks.index')->with('success', 'تم حفظ العلامات بنجاح');
    }

    /**
     * Display a student's marks.
     *
     * @param  int  $studentId
     * @return View
     */
    public function showStudentMarks(int $studentId): View
    {
        $marks = $this->markRepo->getByStudent($studentId);
        return view('admin.marks.student_marks', compact('marks'));
    }

    /**
     * Delete a mark.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->markRepo->delete($id);
        return redirect()->back()->with('success', 'تم حذف العلامة بنجاح');
    }

    /**
     * Show the page for selecting a subject for bulk mark entry.
     *
     * @return View
     */
    public function selectSubjectForBulkMarks(): View
    {
        $subjects = Subject::all();
        return view('admin.marks.select_subject_for_bulk', compact('subjects'));
    }

    /**
     * Show the page for adding bulk marks for a subject.
     *
     * @param  int  $subjectId
     * @return View
     */
    public function addBulkMarks(int $subjectId): View
    {
        $subject = Subject::findOrFail($subjectId);
        $students = User::where('role', 'student')->get();
        // Get only the regular tests (not the final exam)
        $tests = Test::where('subject_id', $subjectId)
                     ->where('name', '!=', 'final_exam')
                     ->get();

        return view('admin.marks.add_bulk', compact('subject', 'students', 'tests'));
    }

    /**
     * Store bulk marks for a subject.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function bulkStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($validated['marks'] as $studentId => $testMarks) {
            foreach ($testMarks as $testId => $mark) {
                if (!is_null($mark)) {
                    $this->markRepo->createOrUpdate([
                        'student_id' => $studentId,
                        'test_id' => $testId,
                        'mark' => $mark,
                    ]);
                } else {
                    $this->markRepo->deleteBy([
                        'student_id' => $studentId,
                        'test_id' => $testId,
                    ]);
                }
            }
        }

        return redirect()->route('admin.marks.index')->with('success', 'تم حفظ العلامات بنجاح.');
    }
}
