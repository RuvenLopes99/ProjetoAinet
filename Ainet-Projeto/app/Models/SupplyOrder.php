<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Supply_order extends Model
{
    protected $fillable = [
        'produtct_id',
        'registered_by_user_id',
        'status',
        'quantity',
    ];
}
