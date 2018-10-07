<?php

namespace Corp\Repositories;

use Corp\Comment;

class CommentRepository extends Repository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}