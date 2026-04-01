<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['user_id' => 2, 'product_id' => 1, 'rating' => 5, 'comment' => 'Smartphone sangat bagus, kamera jernih!',        'is_approved' => true],
            ['user_id' => 2, 'product_id' => 3, 'rating' => 4, 'comment' => 'TWS suaranya mantap, tapi baterai agak boros.',   'is_approved' => true],
            ['user_id' => 3, 'product_id' => 5, 'rating' => 5, 'comment' => 'Celana jeans sangat nyaman dipakai sehari-hari.', 'is_approved' => true],
            ['user_id' => 4, 'product_id' => 6, 'rating' => 5, 'comment' => 'Kopi arabikanya enak, aroma kuat!',              'is_approved' => true],
            ['user_id' => 4, 'product_id' => 7, 'rating' => 3, 'comment' => 'Snacknya oke tapi packaging kurang rapi.',        'is_approved' => false],
            ['user_id' => 2, 'product_id' => 2, 'rating' => 5, 'comment' => 'Laptop kencang banget, puas!',                   'is_approved' => true],
        ];

        foreach ($reviews as &$r) {
            $r['created_at'] = now();
            $r['updated_at'] = now();
        }

        DB::table('reviews')->insert($reviews);
    }
}
