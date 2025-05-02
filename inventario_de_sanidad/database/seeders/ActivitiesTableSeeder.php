<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;
use App\Models\Subject;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = User::where('role', 'student')->get();
        $subjects = Subject::all();

        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                Activity::create([
                    'user_id'       => $student->user_id,
                    'subject_id'    => $subject->subject_id,
                    'description'   => 'Ejercicio práctico de ' . $subject->name,
                    'activity_date' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
