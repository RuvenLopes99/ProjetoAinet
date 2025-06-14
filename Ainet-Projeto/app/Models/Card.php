<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Card extends Model
{
    protected $fillable = [
        'card_number',
        'balance',
    ];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
