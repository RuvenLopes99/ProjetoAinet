<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'photo',
        'discount_min_qty',
        'discount',
        'stock_lowe_limit',
        'stock_upper_limit',

    ];
}
