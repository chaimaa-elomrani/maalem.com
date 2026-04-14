<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getFeed(int $perPage = 12)
    {
        return $this->postRepository->getPaginatedFeed($perPage);
    }

    public function storePost(array $data, $artisanId)
    {
        $imagePaths = [];
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $file) {
                $path = $file->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }

        $tagsArray = [];
        if (isset($data['tags']) && is_string($data['tags'])) {
            $tagsArray = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        return $this->postRepository->create([
            'artisan_id'  => $artisanId,
            'title'       => $data['title'],
            'description' => $data['description'],
            'images'      => $imagePaths,
            'category'    => $data['category'],
            'tags'        => $tagsArray,
        ]);
    }
}
