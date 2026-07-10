<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * عرض قائمة الطلاب
     */
    public function index(Request $request)
    {
        // استعلام قاعدة البيانات للحصول على الطلاب مع تحميل علاقة الدورات
        $query = User::where('role', User::ROLE_STUDENT)->with('courses');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        $students = $query->paginate(10); 

        return view('admin.students.index', compact('students'));
    }

    /**
     * عرض نموذج إنشاء طالب جديد
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
    }

    /**
     * تخزين طالب جديد
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = User::ROLE_STUDENT;
        
        $student = User::create($validatedData);

        // هنا التعديل: نتحقق مما إذا كانت الدورات موجودة ونسندها.
        // إذا كانت قيمة فردية، ستعمل بشكل صحيح مع sync().
        if (isset($validatedData['courses'])) {
            $student->courses()->sync($validatedData['courses']);
        }

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully!');
    }

    /**
     * عرض نموذج تعديل طالب
     */
    public function edit(User $student)
    {
        $courses = Course::all();
        return view('admin.students.edit', compact('student', 'courses'));
    }

    /**
     * تحديث بيانات طالب
     */
    public function update(UpdateStudentRequest $request, User $student)
    {
        $validatedData = $request->validated();
        
        // هنا التعديل
        // إذا كانت كلمة المرور موجودة، نقوم بتحديثها، وإلا فنتجاهلها.
        if (isset($validatedData['password']) && !empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        
        $student->update($validatedData);

        // هنا التعديل: نتحقق من وجود حقل الدورات ونقوم بالمزامنة.
        // إذا لم يتم اختيار أي دورة، سنقوم بفك ارتباطها (detach).
        if (isset($validatedData['courses'])) {
            $student->courses()->sync($validatedData['courses']);
        } else {
            $student->courses()->detach();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * حذف طالب
     */
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * عرض قائمة الدورات للطالب
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\View\View
     */
    public function showCourses(User $student)
    {
        // استرجاع الدورات المسجل بها الطالب
        $enrolledCourses = $student->courses;
        // استرجاع جميع الدورات الأخرى غير المسجل بها الطالب
        $availableCourses = Course::whereDoesntHave('students', function ($query) use ($student) {
            $query->where('user_id', $student->id);
        })->get();
                                    
        return view('admin.students.courses', compact('student', 'enrolledCourses', 'availableCourses'));
    }
}