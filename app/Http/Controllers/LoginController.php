<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form or redirect if already logged in.
     */
    public function index()
    {
        if (session()->has('student')) {
            return redirect('/home/' . session('student')['username']);
        }

        return view('login');
    }

    /**
     * Process the login submission.
     */
    public function login(Request $request)
    {
        // 1) Validate input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2) Find student by email
        $student = Student::where('email', $request->input('email'))->first();

        if (! $student) {
            return redirect('/')
                   ->withErrors(['email' => 'Email not found']);
        }

        // 3) Check plain password (you may later replace with hash check)
        if ($request->input('password') !== $student->password) {
            return redirect('/')
                   ->withErrors(['password' => 'Incorrect password']);
        }

        // 4) Store student in session
        $request->session()->put('student', $student->toArray());

        // 5) Authenticate with 'students' guard
        Auth::guard('students')->login($student);

        // 6) Redirect to student's home page
        return redirect('/home/' . $student->username);
    }
}
