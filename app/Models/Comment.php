<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Walls;
class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'target_id',
        'profile_id',
        'avatar',
        'fullname',
        'content',
    ];

    public function padlet()
    {
        return $this->belongsTo(Walls::class);
    }
}
