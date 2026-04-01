<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Elektronik (category_id = 1)
            ['category_id' => 1, 'name' => 'Smartphone XYZ Pro',  'slug' => 'smartphone-xyz-pro',  'description' => 'Smartphone canggih dengan kamera 108MP', 'price' => 4999000, 'stock' => 50,  'is_active' => true],
            ['category_id' => 1, 'name' => 'Laptop UltraBook A1', 'slug' => 'laptop-ultrabook-a1', 'description' => 'Laptop tipis performa tinggi',             'price' => 12500000,'stock' => 20,  'is_active' => true],
            ['category_id' => 1, 'name' => 'TWS Earbuds Pro',     'slug' => 'tws-earbuds-pro',     'description' => 'Earbuds nirkabel dengan ANC',             'price' => 799000,  'stock' => 100, 'is_active' => true],
            // Pakaian (category_id = 2)
            ['category_id' => 2, 'name' => 'Kaos Polos Premium',  'slug' => 'kaos-polos-premium',  'description' => 'Kaos bahan cotton combed 30s',            'price' => 89000,   'stock' => 200, 'is_active' => true],
            ['category_id' => 2, 'name' => 'Celana Jeans Slim',   'slug' => 'celana-jeans-slim',   'description' => 'Celana jeans slim fit pria',              'price' => 249000,  'stock' => 80,  'is_active' => true],
            // Makanan (category_id = 3)
            ['category_id' => 3, 'name' => 'Kopi Arabika 250gr',  'slug' => 'kopi-arabika-250gr',  'description' => 'Kopi arabika single origin Flores',       'price' => 75000,   'stock' => 150, 'is_active' => true],
            ['category_id' => 3, 'name' => 'Snack Mix Pack',      'slug' => 'snack-mix-pack',      'description' => 'Paket camilan assorted 10 pcs',           'price' => 35000,   'stock' => 300, 'is_active' => true],
            // Olahraga (category_id = 4)
            ['category_id' => 4, 'name' => 'Sepatu Lari Sport X', 'slug' => 'sepatu-lari-sport-x', 'description' => 'Sepatu lari ringan dan breathable',       'price' => 450000,  'stock' => 60,  'is_active' => true],
        ];

        foreach ($products as &$p) {
            $p['image']      = null;
            $p['created_at'] = now();
            $p['updated_at'] = now();
        }

        DB::table('products')->insert($products);
    }
}
