<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function addComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function getPostComments(int $postId)
    {
        return $this->commentRepository->getForPost($postId);
    }
}
