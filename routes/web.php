<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\StudentDashboardController as StudentDashboardController;
use App\Http\Controllers\Student\StudentAttendanceController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Student\StudentPaymentController;
use App\Http\Controllers\Admin\MarkController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\FinalExamMarkController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SectionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// المسار الرئيسي
Route::get('/', function () {
    return view('index');
})->name('home');

// صفحة "من نحن"
Route::get('/about', function () {
    return view('about');
})->name('about');

// مسارات المصادقة (تسجيل الدخول، تسجيل الخروج)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// مسارات لوحة تحكم المدير
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    
    // لوحة تحكم المدير
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // مسارات الطلاب
    Route::resource('students', StudentController::class)->names('students');
    
    // مسارات الحضور
    Route::resource('attendances', AttendanceController::class)->names('attendances');

    // مسارات الدفعات
    Route::get('payments/{payment}/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('payments/apply/{payment}', [PaymentController::class, 'apply'])->name('payments.apply');
    Route::post('payments/process-apply/{payment}', [PaymentController::class, 'processApply'])->name('payments.processApply');
    Route::get('payments/search-users', [PaymentController::class, 'searchUsers'])->name('payments.searchUsers');
    Route::resource('payments', PaymentController::class)->except(['show'])->names('payments');

    // مسارات إدارة العلامات
    Route::get('marks', [MarkController::class, 'index'])->name('marks.index');
    Route::get('marks/create', [MarkController::class, 'selectSubject'])->name('marks.create');
    Route::get('marks/select-test/{subjectId}', [MarkController::class, 'selectTest'])->name('marks.selectTest');
    Route::get('marks/add/{subjectId}/{testId}', [MarkController::class, 'addMarks'])->name('marks.add_marks');
    Route::post('marks/store', [MarkController::class, 'store'])->name('marks.store');
    Route::get('marks/student/{studentId}', [MarkController::class, 'showStudentMarks'])->name('marks.student');
    Route::delete('marks/{id}', [MarkController::class, 'destroy'])->name('marks.destroy');
    Route::get('marks/add-bulk/select-subject', [MarkController::class, 'selectSubjectForBulkMarks'])->name('marks.select_subject_for_bulk');
    Route::get('marks/add-bulk/{subjectId}', [MarkController::class, 'addBulkMarks'])->name('marks.add_bulk');
    Route::post('marks/bulk-store', [MarkController::class, 'bulkStore'])->name('marks.bulk_store');

    // مسارات المواد
    Route::resource('subjects', SubjectController::class)->names('subjects');

    // مسارات الاختبارات
    Route::resource('tests', TestController::class)->names('tests');

    // إضافة مسار علامات الاختبارات
    Route::get('test_marks', [MarkController::class, 'testMarksIndex'])->name('test_marks.index');

    // إضافة مسارات علامات الامتحانات النهائية
    Route::get('final_exam_marks', [FinalExamMarkController::class, 'index'])->name('final_exam_marks.index');
    Route::get('final_exam_marks/create', [FinalExamMarkController::class, 'create'])->name('final_exam_marks.create');
    Route::post('final_exam_marks', [FinalExamMarkController::class, 'store'])->name('final_exam_marks.store');
    Route::get('final_exam_marks/{id}/edit', [FinalExamMarkController::class, 'edit'])->name('final_exam_marks.edit');
    Route::put('final_exam_marks/{id}', [FinalExamMarkController::class, 'update'])->name('final_exam_marks.update');
    Route::delete('final_exam_marks/{id}', [FinalExamMarkController::class, 'destroy'])->name('final_exam_marks.destroy');
    Route::post('final_exam_marks/bulk', [FinalExamMarkController::class, 'bulkStore'])->name('final_exam_marks.bulkStore');

    // مسارات الدورات
    Route::resource('courses', CourseController::class)->names('courses');

    // مسارات الشعب (Sections)
    Route::resource('sections', SectionController::class)->names('sections');

    // ✅ مسارات مخصصة لإدارة الطلاب في الشعب
    Route::post('sections/{section}/add-student', [SectionController::class, 'addStudent'])->name('sections.addStudent');
    Route::delete('sections/{section}/remove-student/{student}', [SectionController::class, 'removeStudent'])->name('sections.removeStudent');
});

// مسارات لوحة تحكم الطالب
Route::middleware(['auth', 'student'])->prefix('student')->as('student.')->group(function () {
    
    // لوحة تحكم الطالب
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // مسارات الحضور
    Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('attendance.index');

    // مسارات الدفعات
    Route::get('/payments', [StudentPaymentController::class, 'index'])->name('payments.index');
});