<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'       => 'Admin Toko',
                'email'      => 'admin@toko.com',
                'phone'      => '081200000001',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Budi Santoso',
                'email'      => 'budi@email.com',
                'phone'      => '081200000002',
                'password'   => Hash::make('password'),
                'role'       => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Siti Rahma',
                'email'      => 'siti@email.com',
                'phone'      => '081200000003',
                'password'   => Hash::make('password'),
                'role'       => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Andi Wijaya',
                'email'      => 'andi@email.com',
                'phone'      => '081200000004',
                'password'   => Hash::make('password'),
                'role'       => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        $profiles = [
            [
                'user_id'     => 1,
                'address'     => 'Jl. Merdeka No. 1',
                'city'        => 'Jakarta',
                'province'    => 'DKI Jakarta',
                'postal_code' => '10110',
                'birth_date'  => '1990-01-01',
                'avatar'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 2,
                'address'     => 'Jl. Sudirman No. 45',
                'city'        => 'Bandung',
                'province'    => 'Jawa Barat',
                'postal_code' => '40111',
                'birth_date'  => '1995-06-15',
                'avatar'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 3,
                'address'     => 'Jl. Ahmad Yani No. 12',
                'city'        => 'Malang',
                'province'    => 'Jawa Timur',
                'postal_code' => '65115',
                'birth_date'  => '1998-03-22',
                'avatar'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 4,
                'address'     => 'Jl. Diponegoro No. 8',
                'city'        => 'Surabaya',
                'province'    => 'Jawa Timur',
                'postal_code' => '60271',
                'birth_date'  => '1997-11-10',
                'avatar'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('user_profiles')->insert($profiles);
    }
}
