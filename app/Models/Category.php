<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    // One-to-Many: satu category memiliki banyak product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
