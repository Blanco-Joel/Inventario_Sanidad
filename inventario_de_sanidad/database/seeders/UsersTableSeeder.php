<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin
        User::create([
            'first_name'      => 'Miriam',
            'last_name'       => 'López Rouco',
            'email'           => 'admin@example.com',
            'hashed_password' => Hash::make('123'),
            'role'            => 'admin',
        ]);

        // Create a teacher
        User::create([
            'first_name'      => 'Jane',
            'last_name'       => 'Doe',
            'email'           => 'jane.teacher@example.com',
            'hashed_password' => Hash::make('456'),
            'role'            => 'teacher',
        ]);

        // Create students
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'first_name'      => 'Student' . $i,
                'last_name'       => 'User' . $i,
                'email'           => "student{$i}@example.com",
                'hashed_password' => Hash::make('password'),
                'role'            => 'student',
            ]);
        }
    }
}
