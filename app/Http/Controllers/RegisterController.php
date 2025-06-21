<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => ['required', Rule::unique('students', 'username')],
            'email' => ['required', Rule::unique('students', 'email')],
            'password' => 'required'
        ]);

        $student = Student::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        //$request->session()->put('student', $student);
        
        return redirect('/');
    }
}
