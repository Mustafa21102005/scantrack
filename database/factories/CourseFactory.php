<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('COURSE_###')),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            // 'lecturer_id' is being made in the CourseSeeder
        ];
    }
}
