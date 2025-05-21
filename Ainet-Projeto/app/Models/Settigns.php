<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Settigns extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'membership_fee',
    ];
}
