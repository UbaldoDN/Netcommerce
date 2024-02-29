<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'is_completed' => false,
            'started_at' => now(),
            'expired_at' => now()->addDays(3),
            'user_id' => \App\Models\User::factory(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
