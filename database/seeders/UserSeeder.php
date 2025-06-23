<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'nama_pelanggan' => 'Admin',
                'id_pelanggan' => '12345',
                'role' => 'admin',
            ],
            [
                'nama_pelanggan' => 'Nadya',
                'id_pelanggan' => '67890',
                'role' => 'user',
            ],
            [
                'nama_pelanggan' => 'Budi',
                'id_pelanggan' => '54321',
                'role' => 'user',
            ],
        ]);
    }
}