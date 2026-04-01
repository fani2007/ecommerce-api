<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Order 1 (ORD-2025-0001): Smartphone + TWS
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 1, 'unit_price' => 4999000, 'subtotal' => 4999000],
            ['order_id' => 1, 'product_id' => 3, 'quantity' => 1, 'unit_price' => 799000,  'subtotal' => 799000],
            // Order 2 (ORD-2025-0002): Celana Jeans
            ['order_id' => 2, 'product_id' => 5, 'quantity' => 1, 'unit_price' => 249000,  'subtotal' => 249000],
            // Order 3 (ORD-2025-0003): Kopi + Snack
            ['order_id' => 3, 'product_id' => 6, 'quantity' => 1, 'unit_price' => 75000,   'subtotal' => 75000],
            ['order_id' => 3, 'product_id' => 7, 'quantity' => 1, 'unit_price' => 35000,   'subtotal' => 35000],
            // Order 4 (ORD-2025-0004): Laptop
            ['order_id' => 4, 'product_id' => 2, 'quantity' => 1, 'unit_price' => 12500000,'subtotal' => 12500000],
        ];

        foreach ($items as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('order_items')->insert($items);
    }
}
