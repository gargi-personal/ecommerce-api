<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Link to parent order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Link to the product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}