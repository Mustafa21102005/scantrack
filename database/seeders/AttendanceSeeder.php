<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::with('students', 'sessions')->get();

        foreach ($courses as $course) {
            foreach ($course->sessions as $session) {
                foreach ($course->students as $student) {
                    if ($student->enrolledCourses()->where('course_id', $course->id)->exists()) {
                        if (rand(0, 1)) {
                            Attendance::create([
                                'student_id' => $student->id,
                                'course_session_id' => $session->id
                            ]);
                        }
                    }
                }
            }
        }
    }
}
