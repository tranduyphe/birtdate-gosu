<?php

namespace App\Repositories\Wall;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wall\WallRepositoryInterface;
use App\Repositories\BaseRepository;

class WallRepository extends BaseRepository implements WallRepositoryInterface
{
    protected $model;
    
    public function getModel()
    {
        return \App\Models\Walls::class;
    }

    public function getWall()
    {
        return $this->model->select('file_name')->take(5)->get();
    }

    public function getAllWall(){
        return $this->model->with(['comments', 'users'])->get();
    }

    public function getWallById($id){
        return $this->model->with(['comments', 'users'])->find($id);
    }
}