<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,       // Rafani  - users & user_profiles
            CategorySeeder::class,   // Shilla  - categories
            ProductSeeder::class,    // Shilla  - products
            TagSeeder::class,        // Nabila  - tags & product_tag
            OrderSeeder::class,      // Naila   - orders
            OrderItemSeeder::class,  // Lidia   - order_items
            ReviewSeeder::class,     // Dewi    - reviews
        ]);
    }
}
