<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Item;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        if(!session()->has('student'))
        {
            return redirect('/');
        }

        return view('profile');
    }

    public function profile_update(Request $request)
    {
        $new_name = $request->input('name');

        // Get the current student data from session
        $student = session('student');

        // Update the name in the array
        $student['name'] = $new_name;

        // Store the updated array back in the session
        session(['student' => $student]);

        // Update the database
        Student::where('username', $student['username'])->update(['name' => $new_name]);

        return view('profile');
    }

    public function delete()
    {
        if(!session()->has('student'))
        {
            return redirect('/');
        }

        $student = session('student');

        foreach(Item::where('from', $student['email'])->get() as $item)
        {
            File::delete('images/'.$item->pic);
        }

        Item::where('from', $student['email'])->delete();
        Student::where('username', $student['username'])->delete();
        session()->forget('student');
        return redirect('/');
    }
}
