<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik',       'slug' => 'elektronik',       'description' => 'Produk elektronik dan gadget',    'is_active' => true],
            ['name' => 'Pakaian',          'slug' => 'pakaian',          'description' => 'Fashion pria dan wanita',         'is_active' => true],
            ['name' => 'Makanan & Minuman','slug' => 'makanan-minuman',  'description' => 'Produk pangan dan minuman',       'is_active' => true],
            ['name' => 'Olahraga',         'slug' => 'olahraga',         'description' => 'Peralatan dan aksesoris olahraga','is_active' => true],
        ];

        foreach ($categories as &$cat) {
            $cat['created_at'] = now();
            $cat['updated_at'] = now();
        }

        DB::table('categories')->insert($categories);
    }
}
