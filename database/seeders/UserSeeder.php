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
                'nama_pelanggan' => 'Sulaiman',
                'id_pelanggan' => '12345',
            ],
            [
                'nama_pelanggan' => 'Nadya',
                'id_pelanggan' => '67890',
            ],
            [
                'nama_pelanggan' => 'Budi',
                'id_pelanggan' => '54321',
            ],
        ]);
    }
}