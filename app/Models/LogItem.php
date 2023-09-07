<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class LogItem extends Model
{
    use HasFactory;
    protected $table = 'log_item';

    protected $fillable = [
        'user_id',
        'old',
        'new',
        'item_name',
        'reason',
        'record',
    ];
}
