<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'status',
        'total_price', 'shipping_address', 'notes'
    ];

    // One-to-Many inverse: order milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many: satu order memiliki banyak order_item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
