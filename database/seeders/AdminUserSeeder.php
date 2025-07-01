<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('role', 'admin')->first();
        
        if (!$adminExists) {
            User::create([
                'nama_pelanggan' => 'Administrator',
                'id_pel' => 'admin123',
                'role' => 'admin',
                'goltar' => 'ADMIN',
                'alamat' => 'Kantor PDAM',
                'desa' => 'Pusat',
                'kecamatan' => 'Pusat',
                'status_pelanggan' => 'AKTIF',
            ]);
            
            echo "Admin user created successfully!\n";
            echo "Username: Administrator\n";
            echo "ID Pelanggan: admin123\n";
        } else {
            echo "Admin user already exists!\n";
        }
    }
}
