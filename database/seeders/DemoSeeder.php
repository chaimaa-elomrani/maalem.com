<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Artisan::factory(5)->create()->each(function ($artisan) {
            \App\Models\Post::factory(4)->create([
                'artisan_id' => $artisan->id,
            ]);
        });
    }
}
