<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class MinigameQuests extends Model
{
    use HasFactory;
    protected $table = 'minigame_quests';

    protected $fillable = [
        'user_id',
        'quests',
        'date',
    ];
}
