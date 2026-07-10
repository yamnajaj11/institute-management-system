<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Repositories\TestRepository;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $testRepo;

    public function __construct(TestRepository $testRepo)
    {
        $this->testRepo = $testRepo;
    }

    // عرض جميع الاختبارات
    public function index()
    {
        $tests = $this->testRepo->all()->where('name', '!=', 'final_exam');
        return view('admin.tests.index', compact('tests'));  // عرض صفحة الاختبارات مع الترجمة
    }

    // عرض صفحة إنشاء اختبار جديد
    public function create()
    {
        // جلب جميع المواد (Subjects) ليتمكن المستخدم من اختيار مادة للاختبار
        $subjects = Subject::all();
        return view('admin.tests.create', compact('subjects'));  // تمرير المواد إلى الـ View
    }

    // حفظ اختبار جديد
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'test_date' => 'nullable|date',
        ]);

        // حفظ الاختبار باستخدام الريبو
        $this->testRepo->create($validated);

        return redirect()->route('admin.tests.index')->with('success', __('admin.test_created_successfully'));  // رسالة النجاح مع الترجمة
    }

    // عرض صفحة تعديل اختبار
    public function edit($id)
    {
        // جلب الاختبار
        $test = $this->testRepo->find($id);

        // جلب جميع المواد (Subjects) ليتمكن المستخدم من تعديل المادة المرتبطة بالاختبار
        $subjects = Subject::all();

        return view('admin.tests.edit', compact('test', 'subjects'));  // تمرير الاختبار والمواد إلى الـ View
    }

    // تحديث اختبار
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'test_date' => 'nullable|date',
        ]);

        // تحديث الاختبار باستخدام الريبو
        $this->testRepo->update($id, $validated);

        return redirect()->route('admin.tests.index')->with('success', __('admin.test_updated_successfully'));  // رسالة النجاح مع الترجمة
    }

    // حذف اختبار
    public function destroy($id)
    {
        // حذف الاختبار باستخدام الريبو
        $this->testRepo->delete($id);

        return redirect()->route('admin.tests.index')->with('success', __('admin.test_deleted_successfully'));  // رسالة النجاح مع الترجمة
    }
}
