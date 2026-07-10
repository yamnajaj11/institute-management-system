<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * يعرض سجلات حضور الطالب الحالي.
     */
    public function index()
    {
        // التحقق من أن المستخدم مسجل الدخول ولديه دور "طالب"
        if (Auth::check() && Auth::user()->role === 'student') {
            // جلب سجلات الحضور للطالب الحالي فقط
            $attendances = Attendance::where('student_id', Auth::id())
                                   ->latest('date')
                                   ->get();

            // تمرير المتغير بشكل صحيح إلى ملف العرض
            return view('student.attendance.index', compact('attendances'));
        }

        // إعادة توجيه المستخدم إذا لم يكن لديه صلاحية
        return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول لهذه الصفحة.');
    }
}
