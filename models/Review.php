<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'rating', 'comment', 'is_approved'
    ];

    // Relasi One-to-Many (inverse): review milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi One-to-Many (inverse): review milik satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
