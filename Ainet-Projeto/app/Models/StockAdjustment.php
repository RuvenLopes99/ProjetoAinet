<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $fillable = [
        'product_id',
        'registered_by_user_id',
        'quantity_changed',
    ];

    // Each stock adjustment belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Each stock adjustment is registered by a user
    public function registeredByUser()
    {
        return $this->belongsTo(User::class, 'registered_by_user_id');
    }
}
