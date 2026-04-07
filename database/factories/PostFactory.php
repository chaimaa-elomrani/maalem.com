<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artisan_id' => \App\Models\Artisan::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['Pottery', 'Weaving', 'Leather', 'Metalwork', 'Ceramics', 'Woodwork']),
            'tags' => [fake()->word(), fake()->word()],
            'images' => ['https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=600&q=80'],
        ];
    }
}
