<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'stock', 'status'
    ];

    // One-to-Many inverse: product milik satu category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many-to-Many: satu product memiliki banyak tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    // relasi ke order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
