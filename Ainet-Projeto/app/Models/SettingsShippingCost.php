<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class SettingsShippingCost extends Model
{
    protected $fillable = [
       'min_value_threshold',
       'max_value_threshold',
       'shipping_cost',

    ];
}
