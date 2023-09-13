<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class LogActivity extends Model
{
    use HasFactory;
    protected $table = 'log_activity';

    protected $fillable = [
        'user_id',
        'reason',
        'type'
    ];
}
