<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function getForPost(int $postId)
    {
        return Comment::where('post_id', $postId)
            ->with('user')
            ->oldest()
            ->get();
    }
}
