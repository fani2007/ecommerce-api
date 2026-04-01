<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'role'];

    // One-to-One: satu user memiliki satu profile
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // One-to-Many: satu user memiliki banyak order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
