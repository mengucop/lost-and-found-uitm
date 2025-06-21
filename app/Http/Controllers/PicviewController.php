<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Item;
use App\Models\Student;
use Illuminate\Http\Request;

class PicviewController extends Controller
{
    public function index()
    {
        // Check if the student is in the session
        if (!session('student')) {
            return redirect('/');
        }

        // Get the current path and extract the picture name
        $path = url()->current();
        $path_split = explode('/', $path);
        $pic_name = end($path_split);
        $pic = Item::where('pic', $pic_name)->first();

        // If the picture does not exist, redirect back
        if (!$pic) {
            return redirect('/home/' . session('student')['username']);
        }

        // Retrieve lost and found items
        $lostItems = Item::where('status', 'lost')->get();
        $foundItems = Item::where('status', 'found')->get();

        // Store the selected picture in the session
        session()->put('pic', $pic);

        // Pass all data to the view
        return view('pic_view', compact('pic', 'lostItems', 'foundItems'));
    }

    public function delete()
    {
        // Check if the student is in the session
        if (!session('student')) {
            return redirect('/');
        }

        // Get the current path and extract the picture name
        $path = url()->current();
        $path_split = explode('/', $path);
        $pic_name = end($path_split);

        // Delete the item with the picture name
        $pic = Item::where('pic', $pic_name)->delete();

        // If the item is not found, redirect back
        if (!$pic) {
            return redirect('/home/' . session('student')['username']);
        }

        // Delete the picture file from the disk
        File::delete('images/' . $pic_name);

        // Redirect back to the student's homepage
        return redirect('/home/' . session('student')['username']);
    }
}
