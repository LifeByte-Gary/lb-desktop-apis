<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = [
            'LifeByte',
            'TMGM'
        ];

        $departments = [
            'IT Support',
            'Development',
            'BA',
            'DevOp',
            'Risk'
        ];

        $types = [
            'Employee',
            'Storage',
            'Meeting Room',
            'Others'
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'company' => fake()->randomElement($companies),
            'department' => fake()->randomElement($departments),
            'job_title' => fake()->jobTitle(),
            'location_id' => fake()->numberBetween(1, 5),
            'desk' => fake()->randomNumber(2),
            'state' => fake()-> numberBetween(0, 1),
            'type' => fake()->randomElement($types),
            'permission_level' => 0,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
