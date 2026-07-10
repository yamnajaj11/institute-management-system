<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::all();
        $query = Attendance::with(['student.courses']);

        if ($search = $request->query('search')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($date = $request->query('date')) {
            $query->where('date', $date);
        }

        if ($status = $request->query('status')) {
            if ($status !== 'all') {
                $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            }
        }

        if ($courseId = $request->query('course_id')) {
            if ($courseId !== 'all') {
                $query->whereHas('student.courses', function ($q) use ($courseId) {
                    $q->where('courses.id', $courseId);
                });
            }
        }

        $attendances = $query->latest('date')->paginate(15);
        $attendances->appends($request->query());

        return view('admin.attendance.index', compact('attendances', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courses = Course::all();
        $query = User::where('role', 'student')->with('courses');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        
        if ($courseId = $request->query('course_id')) {
            if ($courseId !== 'all') {
                $query->whereHas('courses', function ($q) use ($courseId) {
                    $q->where('courses.id', $courseId);
                });
            }
        }

        $students = $query->get();
        return view('admin.attendance.create-daily-attendance', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'student');
                }),
            ],
            'attendance.*.status' => 'required|in:present,absent,late',
        ]);

        try {
            DB::beginTransaction();
            
            // ✅ التحقق من وجود سجلات حضور مسبقة لكل طالب على حدة
            $studentsToSave = [];
            $errors = [];
            $date = $request->input('date');
            
            foreach ($request->input('attendance') as $attendanceData) {
                $studentId = $attendanceData['student_id'];
                
                $existingAttendance = Attendance::where('student_id', $studentId)
                                                ->where('date', $date)
                                                ->exists();

                if ($existingAttendance) {
                    // إذا كان السجل موجودًا، قم بإضافة خطأ محدد
                    $student = User::find($studentId);
                    $errors[] = 'تم تسجيل حضور الطالب **' . $student->name . '** بتاريخ **' . $date . '** مسبقًا.';
                } else {
                    // إذا لم يكن السجل موجودًا، أضف البيانات إلى قائمة الحفظ
                    $studentsToSave[] = $attendanceData;
                }
            }

            // ✅ إذا كان هناك أي أخطاء، قم بإرجاعها
            if (!empty($errors)) {
                DB::rollBack();
                return back()->withInput()->withErrors($errors);
            }

            // ✅ حفظ السجلات الجديدة فقط
            foreach ($studentsToSave as $attendanceData) {

                Attendance::create([
                    'student_id' => $attendanceData['student_id'],
                    'date' => $request->date,
                    'status' => $attendanceData['status'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.attendances.index')->with('success', __('تم حفظ سجل الحضور بنجاح.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['general_error' => __('admin.unexpected_error')]);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendance.edit-daily-attendance', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.attendances.index')->with('success', __('admin.attendance_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendances.index')->with('success', __('admin.attendance_deleted_successfully'));
    }
}