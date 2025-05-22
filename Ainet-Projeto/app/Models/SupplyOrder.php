<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class SupplyOrder extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'registered_by_user_id',
        'status',
        'quantity',
    ];
}
