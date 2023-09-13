<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walls extends Model
{
    use HasFactory;
    protected $table = 'wall';
    protected $fillable = [
        'user_id',
        'title',
        'file_name',
        'content',
        'color',
        'liked',
        'data_like',
        'created_at',
        'updated_at',
    ];
}
