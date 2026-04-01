<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'address', 'city', 'province',
        'postal_code', 'birth_date', 'gender'
    ];

    // One-to-One inverse: profile milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
