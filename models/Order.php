<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'total_price', 'status',
        'shipping_address', 'shipping_city', 'shipping_postal_code'
    ];

    // Relasi One-to-Many (inverse): order milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi One-to-Many: satu order punya banyak item
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
