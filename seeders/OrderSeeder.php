<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'user_id'              => 2,
                'order_code'           => 'ORD-2025-0001',
                'total_price'          => 5798000,
                'status'               => 'delivered',
                'shipping_address'     => 'Jl. Sudirman No. 45',
                'shipping_city'        => 'Bandung',
                'shipping_postal_code' => '40111',
                'created_at'           => now()->subDays(10),
                'updated_at'           => now()->subDays(10),
            ],
            [
                'user_id'              => 3,
                'order_code'           => 'ORD-2025-0002',
                'total_price'          => 249000,
                'status'               => 'shipped',
                'shipping_address'     => 'Jl. Ahmad Yani No. 12',
                'shipping_city'        => 'Malang',
                'shipping_postal_code' => '65115',
                'created_at'           => now()->subDays(3),
                'updated_at'           => now()->subDays(3),
            ],
            [
                'user_id'              => 4,
                'order_code'           => 'ORD-2025-0003',
                'total_price'          => 110000,
                'status'               => 'pending',
                'shipping_address'     => 'Jl. Diponegoro No. 8',
                'shipping_city'        => 'Surabaya',
                'shipping_postal_code' => '60271',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'user_id'              => 2,
                'order_code'           => 'ORD-2025-0004',
                'total_price'          => 12500000,
                'status'               => 'paid',
                'shipping_address'     => 'Jl. Sudirman No. 45',
                'shipping_city'        => 'Bandung',
                'shipping_postal_code' => '40111',
                'created_at'           => now()->subDay(),
                'updated_at'           => now()->subDay(),
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
