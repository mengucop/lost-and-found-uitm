<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Admin Name',
            'email' => 'admin@uitm.edu.my',
            'password' => Hash::make('admin123'), // Make sure to hash the password
        ]);
    }
}
