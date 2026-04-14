<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getPaginatedFeed(int $perPage = 12)
    {
        return Post::with('artisan.user')->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function findByArtisan(int $artisanId)
    {
        return Post::where('artisan_id', $artisanId)->latest()->get();
    }
}
