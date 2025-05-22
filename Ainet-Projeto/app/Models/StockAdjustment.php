<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class StockAdjustment extends Model
{
    protected $fillable = [
        'product_id',
        'registered_by_user_id',
        'quantity_changed',

    ];
}
