<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artisan>
 */
class ArtisanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'workingArea' => fake()->city(),
            'service' => fake()->jobTitle(),
            'disponibility' => json_encode(['Monday', 'Tuesday', 'Wednesday']),
            'experience' => fake()->numberBetween(1, 20),
            'certifications' => json_encode(['Certified Plumber', 'Master Craftsman']),
            'workshopAdresse' => fake()->address(),
            'status' => 'active',
            'access_type' => 'full_service',
            'noteMoyenne' => fake()->randomFloat(1, 3, 5),
        ];
    }
}
