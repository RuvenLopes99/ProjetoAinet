<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsOrder extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
    ];
    public $incrementing = false;

    public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
}
