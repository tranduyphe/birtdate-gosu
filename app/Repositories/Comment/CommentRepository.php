<?php

namespace App\Repositories\Comment;

use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    protected $model;
    
    public function getModel()
    {
        return \App\Models\Comment::class;
    }

    // public function getWall()
    // {
    //     return $this->model->select('file_name')->take(5)->get();
    // }
}
