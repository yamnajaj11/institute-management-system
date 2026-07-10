<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['student_id' => $credentials['student_id'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isStudent()) {
                return redirect()->intended('/student/dashboard');
            }
            
            return redirect()->intended('/home');
        }

        throw ValidationException::withMessages([
            'student_id' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}