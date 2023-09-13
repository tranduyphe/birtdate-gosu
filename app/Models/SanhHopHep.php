<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class SanhHopHep extends Model
{
    use HasFactory;
    protected $table = 'sanh_hop_hep';

    protected $fillable = [
        'user_id',
        'is_reward_quest',
    ];
}
