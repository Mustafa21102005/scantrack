<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = User::role('lecturer')->get();

        Course::factory(3)->make()->each(function ($course) use ($lecturers) {
            $course->lecturer_id = $lecturers->random()->id;
            $course->save();
        });
    }
}
