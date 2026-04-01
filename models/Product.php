<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active'
    ];

    // Relasi One-to-Many (inverse): produk milik satu kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Many-to-Many: produk punya banyak tag
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    // Relasi One-to-Many: produk punya banyak item order
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi One-to-Many: produk punya banyak review
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
