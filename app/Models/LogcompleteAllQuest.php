<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class LogcompleteAllQuest extends Model
{
    use HasFactory;
    protected $table = 'log_complete_all_quest';

    protected $fillable = [
        'user_id',
    ];
}
