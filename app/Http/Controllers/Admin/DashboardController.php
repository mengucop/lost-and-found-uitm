<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetching items and users (example, modify as needed)
        $allItems = Item::latest()->with('user')->get();  // Assuming Item has a relationship with User
        return view('admin.dashboard', compact('allItems'));
    }
}
