<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CourseSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 0; $i < 1; $i++) {
                CourseSession::factory()->create([
                    'course_id' => $course->id,
                    'qr_token' => Str::random(32),
                    'expires_at' => now()->addMinutes(10),
                ]);
            }
        }
    }
}
