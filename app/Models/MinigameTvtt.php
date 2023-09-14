<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class MinigameTvtt extends Model
{
    use HasFactory;
    protected $table = 'minigame_tvtt';

    protected $fillable = [
        'user_id',
        'active_flip_tvtt',
        'flag',
    ];
}
