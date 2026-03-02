<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price', 'status'];

    // Link order to customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link order to its items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}