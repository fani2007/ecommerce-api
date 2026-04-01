<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'unit_price', 'subtotal'
    ];

    // Relasi One-to-Many (inverse): item milik satu order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi One-to-Many (inverse): item merujuk satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
