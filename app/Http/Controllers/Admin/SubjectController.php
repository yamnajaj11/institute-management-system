<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // عرض جميع المواد
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subject.index', compact('subjects'));
    }

    // عرض صفحة إضافة مادة جديدة
    public function create()
    {
        return view('admin.subject.create');
    }

    // تخزين مادة جديدة في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
           
        ]);

        // إنشاء مادة جديدة
        Subject::create([
            'name' => $request->name,
            
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.subjects.index')->with('success', __('admin.subject_added_successfully'));
    }

    // عرض صفحة تعديل مادة
    public function edit($id)
    {
        // العثور على المادة من خلال الـ ID
        $subject = Subject::findOrFail($id);

        // إرجاع صفحة التعديل
        return view('admin.subject.edit', compact('subject'));
    }

    // تحديث المادة في قاعدة البيانات
    public function update(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
           
        ]);

        // العثور على المادة وتحديثها
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
            
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.subjects.index')->with('success', __('admin.subject_updated_successfully'));
    }

    // حذف مادة من قاعدة البيانات
    public function destroy($id)
    {
        // العثور على المادة وحذفها
        $subject = Subject::findOrFail($id);
        $subject->delete();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.subjects.index')->with('success', __('admin.subject_deleted_successfully'));
    }
}
