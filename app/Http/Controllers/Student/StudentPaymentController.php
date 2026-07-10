<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StudentPaymentController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            $payments = Payment::where('student_id', Auth::id())
                               ->with('details')
                               ->orderBy('due_date', 'desc')
                               ->get();

            return view('student.payments.index', compact('payments'));
        }

        return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول لهذه الصفحة.');
    }
}

