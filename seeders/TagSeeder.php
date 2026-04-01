<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Best Seller', 'slug' => 'best-seller'],
            ['name' => 'New Arrival', 'slug' => 'new-arrival'],
            ['name' => 'Diskon',      'slug' => 'diskon'],
            ['name' => 'Premium',     'slug' => 'premium'],
            ['name' => 'Lokal',       'slug' => 'lokal'],
            ['name' => 'Flash Sale',  'slug' => 'flash-sale'],
        ];

        foreach ($tags as &$tag) {
            $tag['created_at'] = now();
            $tag['updated_at'] = now();
        }

        DB::table('tags')->insert($tags);

        // Relasi product_tag (many-to-many)
        $productTags = [
            ['product_id' => 1, 'tag_id' => 1], // Smartphone -> Best Seller
            ['product_id' => 1, 'tag_id' => 4], // Smartphone -> Premium
            ['product_id' => 2, 'tag_id' => 2], // Laptop     -> New Arrival
            ['product_id' => 2, 'tag_id' => 4], // Laptop     -> Premium
            ['product_id' => 3, 'tag_id' => 3], // TWS        -> Diskon
            ['product_id' => 3, 'tag_id' => 6], // TWS        -> Flash Sale
            ['product_id' => 4, 'tag_id' => 1], // Kaos       -> Best Seller
            ['product_id' => 4, 'tag_id' => 5], // Kaos       -> Lokal
            ['product_id' => 6, 'tag_id' => 5], // Kopi       -> Lokal
            ['product_id' => 6, 'tag_id' => 1], // Kopi       -> Best Seller
            ['product_id' => 8, 'tag_id' => 3], // Sepatu     -> Diskon
        ];

        foreach ($productTags as &$pt) {
            $pt['created_at'] = now();
            $pt['updated_at'] = now();
        }

        DB::table('product_tag')->insert($productTags);
    }
}
