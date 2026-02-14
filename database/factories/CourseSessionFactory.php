<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseSession>
 */
class CourseSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qr_token' => $this->faker->unique()->regexify('[A-Za-z0-9]{32}'),
            'expires_at' => now()->addMinutes(10),
            'course_id' => Course::factory(),
        ];
    }
}
