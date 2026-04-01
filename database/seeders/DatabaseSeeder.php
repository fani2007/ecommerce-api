<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== USERS =====
        DB::table('users')->insert([
            ['name' => 'Admin Toko',    'email' => 'admin@toko.com',   'phone' => '081200000001', 'role' => 'admin',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Budi Santoso',  'email' => 'budi@email.com',   'phone' => '081200000002', 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Siti Rahayu',   'email' => 'siti@email.com',   'phone' => '081200000003', 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dian Pratama',  'email' => 'dian@email.com',   'phone' => '081200000004', 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== USER PROFILES =====
        DB::table('user_profiles')->insert([
            ['user_id' => 1, 'address' => 'Jl. Merdeka No.1',  'city' => 'Jakarta',  'province' => 'DKI Jakarta',   'postal_code' => '10110', 'birth_date' => '1990-01-01', 'gender' => 'male',   'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'address' => 'Jl. Pahlawan No.5', 'city' => 'Surabaya', 'province' => 'Jawa Timur',    'postal_code' => '60111', 'birth_date' => '1995-03-15', 'gender' => 'male',   'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'address' => 'Jl. Mawar No.10',   'city' => 'Bandung',  'province' => 'Jawa Barat',    'postal_code' => '40111', 'birth_date' => '1998-07-20', 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'address' => 'Jl. Melati No.3',   'city' => 'Malang',   'province' => 'Jawa Timur',    'postal_code' => '65111', 'birth_date' => '2000-11-05', 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== CATEGORIES =====
        DB::table('categories')->insert([
            ['name' => 'Elektronik',    'slug' => 'elektronik',    'description' => 'Produk elektronik dan gadget',       'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakaian',       'slug' => 'pakaian',       'description' => 'Pakaian pria dan wanita',            'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Makanan',       'slug' => 'makanan',       'description' => 'Produk makanan dan minuman',         'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perabotan',     'slug' => 'perabotan',     'description' => 'Perabotan dan perlengkapan rumah',   'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== PRODUCTS =====
        DB::table('products')->insert([
            ['category_id' => 1, 'name' => 'Laptop Asus A415',    'slug' => 'laptop-asus-a415',    'description' => 'Laptop 14 inch RAM 8GB',       'price' => 7500000,  'stock' => 10, 'status' => 'active',   'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'name' => 'Smartphone Samsung',  'slug' => 'smartphone-samsung',  'description' => 'HP Android 6.5 inch 128GB',    'price' => 3200000,  'stock' => 25, 'status' => 'active',   'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Kaos Polos Putih',    'slug' => 'kaos-polos-putih',    'description' => 'Kaos bahan katun combed 30s',  'price' => 75000,    'stock' => 50, 'status' => 'active',   'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Kemeja Batik',        'slug' => 'kemeja-batik',        'description' => 'Kemeja batik lengan panjang',  'price' => 150000,   'stock' => 30, 'status' => 'active',   'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'name' => 'Kopi Arabika 250gr',  'slug' => 'kopi-arabika-250gr',  'description' => 'Kopi arabika Aceh pilihan',    'price' => 45000,    'stock' => 100,'status' => 'active',   'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 4, 'name' => 'Kursi Kantor',        'slug' => 'kursi-kantor',        'description' => 'Kursi ergonomis bahan mesh',   'price' => 850000,   'stock' => 0,  'status' => 'inactive', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== ORDERS =====
        DB::table('orders')->insert([
            ['user_id' => 2, 'order_code' => 'ORD-20240101-0001', 'status' => 'delivered',  'total_price' => 7575000,  'shipping_address' => 'Jl. Pahlawan No.5 Surabaya', 'notes' => null,              'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'order_code' => 'ORD-20240101-0002', 'status' => 'processing', 'total_price' => 3290000,  'shipping_address' => 'Jl. Mawar No.10 Bandung',    'notes' => 'Kirim siang',     'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'order_code' => 'ORD-20240101-0003', 'status' => 'pending',    'total_price' => 195000,   'shipping_address' => 'Jl. Melati No.3 Malang',     'notes' => 'Packing rapi',    'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== ORDER ITEMS =====
        DB::table('order_items')->insert([
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 1, 'unit_price' => 7500000, 'subtotal' => 7500000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 1, 'product_id' => 3, 'quantity' => 1, 'unit_price' => 75000,   'subtotal' => 75000,   'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'product_id' => 2, 'quantity' => 1, 'unit_price' => 3200000, 'subtotal' => 3200000, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'product_id' => 5, 'quantity' => 2, 'unit_price' => 45000,   'subtotal' => 90000,   'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'product_id' => 3, 'quantity' => 1, 'unit_price' => 75000,   'subtotal' => 75000,   'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'product_id' => 4, 'quantity' => 1, 'unit_price' => 150000,  'subtotal' => 150000,  'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== TAGS =====
        DB::table('tags')->insert([
            ['name' => 'Promo',     'slug' => 'promo',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bestseller','slug' => 'bestseller','created_at' => now(), 'updated_at' => now()],
            ['name' => 'New',       'slug' => 'new',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Flash Sale','slug' => 'flash-sale','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lokal',     'slug' => 'lokal',     'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===== PRODUCT_TAG (pivot) =====
        DB::table('product_tag')->insert([
            ['product_id' => 1, 'tag_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'tag_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'tag_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'tag_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'tag_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'tag_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 5, 'tag_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 5, 'tag_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
