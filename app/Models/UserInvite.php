<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class UserInvite extends Model
{
    use HasFactory;
    protected $table = 'user_invite';

    protected $fillable = [
        'user_id',
        'friend_id'
    ];
}
