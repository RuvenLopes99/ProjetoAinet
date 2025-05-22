<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Settigns_shipping_costs extends Model
{
    protected $table = 'settings_shipping_costs';
    protected $fillable = [
       'min_value_threshold',
       'max_value_threshold',
       'shipping_cost',

    ];
}
