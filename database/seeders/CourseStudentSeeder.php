<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all users with 'student' role
        $students = User::role('student')->get();

        // Attach random students to each course (e.g., 3-6 students per course)
        Course::all()->each(function ($course) use ($students) {
            $randomStudents = $students->random(rand(3, 6))->pluck('id')->toArray();
            $course->students()->attach($randomStudents);
        });
    }
}
