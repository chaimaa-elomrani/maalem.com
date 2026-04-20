<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getPaginatedFeed(array $filters = [], int $perPage = 12)
    {
        $query = Post::with(['artisan.user', 'comments.user']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhereHas('artisan.user', function ($q) use ($search) {
                      $q->where('name', 'ilike', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
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
