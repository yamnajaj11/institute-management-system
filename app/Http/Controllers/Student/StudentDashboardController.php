<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated student.
        $student = Auth::user();

        // For now, let's create a dummy list of courses since we haven't
        // implemented the student-course relationship in the database yet.
        $courses = collect([
            (object)[
                'title' => 'أساسيات البرمجة بلغة Python',
                'description' => 'دورة شاملة للمبتدئين في عالم البرمجة.',
                'progress_percent' => 75
            ],
            (object)[
                'title' => 'التصميم الجرافيكي للمبتدئين',
                'description' => 'تعلم أساسيات التصميم وأدواته الرئيسية.',
                'progress_percent' => 50
            ]
        ]);

        return view('student.dashboard', compact('courses'));
    }
}
