<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Minigame extends Model
{
    use HasFactory;
    protected $table = 'minigame';

    protected $fillable = [
        'user_id',
        'list_flips',
        'active_flips',
        'flag',
    ];
}
