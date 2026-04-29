<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getFeed(array $filters = [], int $perPage = 12)
    {
        return $this->postRepository->getPaginatedFeed($filters, $perPage);
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

    public function updatePost(Post $post, array $data)
    {
        if (isset($data['images']) && is_array($data['images'])) {
            $imagePaths = [];
            foreach ($data['images'] as $file) {
                $path = $file->store('posts', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = $imagePaths;
        }

        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        return $this->postRepository->update($post, $data);
    }
}
