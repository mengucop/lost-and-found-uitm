<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test student with a bcrypt-hashed password
        Student::create([
            'name'     => 'Test Student',
            'email'    => 'test@student.uitm.edu.my',
            'username' => 'teststudent',
            'password' => Hash::make('secret123'),
        ]);

        // Seed 10 random students using factory
        Student::factory(10)->create();

        // Call the AdminSeeder to create default admin
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
