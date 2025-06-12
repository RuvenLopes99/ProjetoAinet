<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class Order extends Model
{
   protected $fillable = [
        'member_id',
        'status',
        'date',
        'total_items',
        'shipping_cost',
        'total',
        'nif',
        'delivery_address',
        'pdf_receipt',
        'cancel_reason',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Each order has many order_products (pivot)
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function items_orders()
    {
        return $this->hasMany(ItemsOrder::class);
    }
}
