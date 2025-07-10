<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Tarif;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Clear existing data
        DB::table('users')->truncate();
        DB::table('pelanggan')->truncate();
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Debug: Periksa kolom yang ada di tabel users
        $userColumns = Schema::getColumnListing('users');
        echo "Kolom users yang tersedia: " . implode(', ', $userColumns) . "\n";
        
        // Debug: Periksa kolom yang ada di tabel pelanggan
        $pelangganColumns = Schema::getColumnListing('pelanggan');
        echo "Kolom pelanggan yang tersedia: " . implode(', ', $pelangganColumns) . "\n";
        
        // Pastikan ada tarif default
        $defaultTarif = Tarif::first();
        if (!$defaultTarif) {
            $defaultTarif = Tarif::create([
                'kategori' => 'Rumah Tangga',
                'tarif_per_m3' => 2500,
                'biaya_admin' => 5000,
                'biaya_beban' => 0,
                'status' => 'AKTIF',
            ]);
            echo "✓ Tarif default berhasil dibuat dengan ID: {$defaultTarif->id_tarif}\n";
        }
    
          $users = [
            // Admin user
            [
                'id_pel' => '00323',
                'id_meter' => '00031858',
                'nama_pelanggan' => 'FADHIL RIDWAN',
                'password' => Hash::make('00323'),
                'role' => 'admin',
                'goltar' => '24',
                'alamat' => 'DUSUN MELUR',
                'desa' => 'BUKIT RATA',
                'kecamatan' => 'KEJURUAN MUDA',
                'rute' => 'G102 - KP. PAYA BEDI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '60',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 1,
                'harga_air' => 3600,
                'biaya_admin' => 10000,
                'denda' => 0,
                'total_tagihan' => 13600,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00357',
                'id_meter' => '00019503',
                'nama_pelanggan' => 'HANIF',
                'password' => Hash::make('00357'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'PAYA BEDI',
                'desa' => 'PAYA BEDI',
                'kecamatan' => 'RANTAU',
                'rute' => 'G102 - KP. PAYA BEDI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '797',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 6,
                'total_pemakaian_m3' => 137,
                'harga_air' => 503400,
                'biaya_admin' => 60000,
                'denda' => 25000,
                'total_tagihan' => 588400,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00382',
                'id_meter' => '00000275',
                'nama_pelanggan' => 'SYAHRUL AISYAH IMRAN',
                'password' => Hash::make('00382'),
                'role' => 'user',
                'goltar' => '25',
                'alamat' => 'JL.SRI WIJAYA',
                'desa' => 'SRIWIJAYA',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B102 - KP. SRIWIJAYA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'TERKUNCI',
                'angka_meter_kini' => '4.975',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 28,
                'total_pemakaian_m3' => 95,
                'harga_air' => 384100,
                'biaya_admin' => 280000,
                'denda' => 135000,
                'total_tagihan' => 00000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00451',
                'id_meter' => '00000343',
                'nama_pelanggan' => 'AISYAH',
                'password' => Hash::make('00451'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'GG.BECEK',
                'desa' => 'SRIWIJAYA',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B103 - GG.BECEK-SRIWIJAYA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'RUSAK',
                'angka_meter_kini' => '810',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 20,
                'harga_air' => 72000,
                'biaya_admin' => 10000,
                'denda' => 0,
                'total_tagihan' => 82000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00483',
                'id_meter' => '00020249',
                'nama_pelanggan' => 'SITI SULAIMAN',
                'password' => Hash::make('00483'),
                'role' => 'user',
                'goltar' => '25',
                'alamat' => 'GG.BECEK',
                'desa' => 'GG.BECEK',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B103 - GG.BECEK-SRIWIJAYA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '1.613',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 2,
                'total_pemakaian_m3' => 36,
                'harga_air' => 158640,
                'biaya_admin' => 20000,
                'denda' => 5000,
                'total_tagihan' => 183640,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00522',
                'id_meter' => '00000414',
                'nama_pelanggan' => 'FAUZI ZAHRA ZULKARNAIN',
                'password' => Hash::make('00522'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'GG.BECEK',
                'desa' => 'GG.BECEK',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B103 - GG.BECEK-SRIWIJAYA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'RUSAK',
                'angka_meter_kini' => '2.610',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 10,
                'total_pemakaian_m3' => 95,
                'harga_air' => 297000,
                'biaya_admin' => 100000,
                'denda' => 45000,
                'total_tagihan' => 442000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00526',
                'id_meter' => '00026301',
                'nama_pelanggan' => 'FADHIL',
                'password' => Hash::make('00526'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'GG.BECEK',
                'desa' => 'GG.BECEK',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B103 - GG.BECEK-SRIWIJAYA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'TERTIMBUN',
                'angka_meter_kini' => '485',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 32,
                'total_pemakaian_m3' => 262,
                'harga_air' => 898500,
                'biaya_admin' => 315000,
                'denda' => 155000,
                'total_tagihan' => 1368500,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00538',
                'id_meter' => '00026367',
                'nama_pelanggan' => 'MUHAMMAD IMRAN',
                'password' => Hash::make('00538'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'JL SUTOYO',
                'desa' => 'JL.SUTOYO',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B104 - SUTOYO-A.I.SURYANI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '3.046',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 5,
                'total_pemakaian_m3' => 243,
                'harga_air' => 960600,
                'biaya_admin' => 50000,
                'denda' => 20000,
                'total_tagihan' => 1030000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00549',
                'id_meter' => '00036985',
                'nama_pelanggan' => 'FAUZI HIKMAH RIDWAN',
                'password' => Hash::make('00549'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'JL.SUTOYO',
                'desa' => 'JL.SUTOYO',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B104 - SUTOYO-A.I.SURYANI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '784',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 38,
                'harga_air' => 253680,
                'biaya_admin' => 20000,
                'denda' => 0,
                'total_tagihan' => 273680,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00591',
                'id_meter' => '00000483',
                'nama_pelanggan' => 'FAUZI FATIMAH',
                'password' => Hash::make('00591'),
                'role' => 'user',
                'goltar' => '25',
                'alamat' => 'JL.SUTOYO',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B124 - KP.KOTA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '1.539',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 7,
                'total_pemakaian_m3' => 124,
                'harga_air' => 579360,
                'biaya_admin' => 70000,
                'denda' => 30000,
                'total_tagihan' => 679360,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00634',
                'id_meter' => '00032607',
                'nama_pelanggan' => 'SYAHRUL MUNAWWAR',
                'password' => Hash::make('00634'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'JL.SUTOYO',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B124 - KP.KOTA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '489',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 46,
                'harga_air' => 181200,
                'biaya_admin' => 10000,
                'denda' => 0,
                'total_tagihan' => 191200,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00655',
                'id_meter' => '00035239',
                'nama_pelanggan' => 'FAUZIAH',
                'password' => Hash::make('00655'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'JL.SUTOYO',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B104 - SUTOYO-A.I.SURYANI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '895',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 20,
                'harga_air' => 178080,
                'biaya_admin' => 20000,
                'denda' => 0,
                'total_tagihan' => 198000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00661',
                'id_meter' => '00009190',
                'nama_pelanggan' => 'NURUL ZULKARNAIN',
                'password' => Hash::make('00661'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'JL.PERDAMAIAN.LR.PJKA',
                'desa' => 'PERDAMAIAN',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B116 - KP.PERDAMAIAN',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '2735',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 8,
                'total_pemakaian_m3' => 108,
                'harga_air' => 363600,
                'biaya_admin' => 80000,
                'denda' => 35000,
                'total_tagihan' => 478600,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00675',
                'id_meter' => '00000567',
                'nama_pelanggan' => 'RIZKI AISYAH SULAIMAN',
                'password' => Hash::make('00675'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'JL.AE.SURYANI',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B124 - KP.KOTA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '4098',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 32,
                'total_pemakaian_m3' => 346,
                'harga_air' => 1176800,
                'biaya_admin' => 315000,
                'denda' => 155000,
                'total_tagihan' => 1646800,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00692',
                'id_meter' => '00035873',
                'nama_pelanggan' => 'MUHAMMAD MUNAWAAR',
                'password' => Hash::make('00692'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'JL.ISKANDAR MUDA',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B105 - KL.ISKANDAR MUDA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '2100',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 90,
                'harga_air' => 646800,
                'biaya_admin' => 20000,
                'denda' => 0,
                'total_tagihan' => 666800,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00698',
                'id_meter' => '00040395',
                'nama_pelanggan' => 'IKHSAN',
                'password' => Hash::make('00698'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'JL.ISKANDAR MUDA',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B105 - JL.ISKANDAR MUDA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '1274',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 3,
                'total_pemakaian_m3' => 307,
                'harga_air' => 2220120,
                'biaya_admin' => 60000,
                'denda' => 10000,
                'total_tagihan' => 2290120,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00702',
                'id_meter' => '00009800',
                'nama_pelanggan' => 'SITI MUNAWAR',
                'password' => Hash::make('00702'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'JL.ISKANDAR MUDA',
                'desa' => 'KOTA KSP',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B105 - JL.ISKANDAR MUDA',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '5815',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 0,
                'harga_air' => 0,
                'biaya_admin' => 20000,
                'denda' => 0,
                'total_tagihan' => 20000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00760',
                'id_meter' => '00027299',
                'nama_pelanggan' => 'RIZKI',
                'password' => Hash::make('00760'),
                'role' => 'user',
                'goltar' => '31',
                'alamat' => 'SP.IV KOLITA,JL.PAJAK PAGI',
                'desa' => 'KOTA LINTANG',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B121 - PAJAK PAGI',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '2625',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 5,
                'total_pemakaian_m3' => 23,
                'harga_air' => 103320,
                'biaya_admin' => 100000,
                'denda' => 20000,
                'total_tagihan' => 223320,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pel' => '00782',
                'id_meter' => '00030560',
                'nama_pelanggan' => 'RIZKI KOLITA',
                'password' => Hash::make('00782'),
                'role' => 'user',
                'goltar' => '21',
                'alamat' => 'JL.KOLITA, DPN GG.GABUNGAN',
                'desa' => 'KOTA LINTANG',
                'kecamatan' => 'KUALA SIMPANG',
                'rute' => 'B101 - KP.KOTA LINTANG',
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => 'BAIK',
                'angka_meter_kini' => '1360',
                'periode_terakhir' => '202506',
                'jumlah_bulan_rekening' => 1,
                'total_pemakaian_m3' => 228,
                'harga_air' => 945600,
                'biaya_admin' => 10000,
                'denda' => 0,
                'total_tagihan' => 955600,
                'created_at' => now(),
                'updated_at' => now()
            ],
                        [
                'id_pel' => '12345',
                'id_meter' => '123456',
                'nama_pelanggan' => 'ADMIN',
                'password' => Hash::make('12345'),
                'role' => 'admin',
                'goltar' => null,
                'alamat' => 'PDAM Office',
                'desa' => null,
                'kecamatan' => null,
                'rute' => null,
                'merek_meter' => null,
                'status_pelanggan' => 'AKTIF',
                'status_meter' => null,
                'angka_meter_kini' => null,
                'periode_terakhir' => null,
                'jumlah_bulan_rekening' => null,
                'total_pemakaian_m3' => null,
                'harga_air' => null,
                'biaya_admin' => null,
                'denda' => null,
                'total_tagihan' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        echo "Mulai insert data users dan pelanggan...\n";
        
        foreach ($users as $user) {
            try {
                // Siapkan data user berdasarkan kolom yang tersedia
                $userData = [];
                
                // Mapping kolom yang ada untuk tabel users
                $userFieldMapping = [
                    'name' => 'nama_pelanggan',
                    'nama_pelanggan' => 'nama_pelanggan',
                    'email' => function($user) {
                        return strtolower(str_replace(' ', '', $user['nama_pelanggan'])) . '@pdam.com';
                    },
                    'password' => 'password',
                    'role' => function($user) {
                        return $user['role'] == 'admin' ? 'admin' : 'pelanggan';
                    },
                    'id_pel' => 'id_pel',
                    'id_meter' => 'id_meter',
                    'alamat' => 'alamat',
                    'desa' => 'desa',
                    'kecamatan' => 'kecamatan',
                    'rute' => 'rute',
                    'goltar' => 'goltar',
                    'merek_meter' => 'merek_meter',
                    'status_pelanggan' => 'status_pelanggan',
                    'status_meter' => 'status_meter',
                    'angka_meter_kini' => 'angka_meter_kini',
                    'periode_terakhir' => 'periode_terakhir',
                    'jumlah_bulan_rekening' => 'jumlah_bulan_rekening',
                    'total_pemakaian_m3' => 'total_pemakaian_m3',
                    'harga_air' => 'harga_air',
                    'biaya_admin' => 'biaya_admin',
                    'denda' => 'denda',
                    'total_tagihan' => 'total_tagihan',
                    'created_at' => 'created_at',
                    'updated_at' => 'updated_at',
                ];
                
                // Populate userData berdasarkan kolom yang tersedia
                foreach ($userFieldMapping as $dbColumn => $sourceKey) {
                    if (in_array($dbColumn, $userColumns)) {
                        if (is_callable($sourceKey)) {
                            $userData[$dbColumn] = $sourceKey($user);
                        } else {
                            $userData[$dbColumn] = $user[$sourceKey] ?? null;
                        }
                    }
                }
                
                // Insert ke tabel users
                $userId = DB::table('users')->insertGetId($userData);

                // Jika bukan admin, buat data pelanggan
                if ($user['role'] !== 'admin') {
                    // Buat email unik untuk pelanggan
                    $email = strtolower(str_replace(' ', '', $user['nama_pelanggan'])) . '@pdam.com';
                    
                    // Siapkan data pelanggan
                    $pelangganData = [
                        'id_pel' => $user['id_pel'],
                        'nama_pelanggan' => $user['nama_pelanggan'],
                        'alamat' => $user['alamat'] . 
                                  ($user['desa'] ? ', ' . $user['desa'] : '') . 
                                  ($user['kecamatan'] ? ', ' . $user['kecamatan'] : ''),
                        'no_telepon' => '0812' . substr(str_pad($user['id_pel'], 8, '0', STR_PAD_LEFT), -8),
                        'email' => $email,
                        'status_pelanggan' => $user['status_pelanggan'],
                        'role' => 'pelanggan',
                        'tgl_daftar' => now()->subDays(rand(1, 365)),
                        'tarif_id' => $defaultTarif->id_tarif,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ];
                    
                    // Insert ke tabel pelanggan
                    Pelanggan::create($pelangganData);
                    
                    echo "✓ User & Pelanggan {$user['nama_pelanggan']} (ID: {$user['id_pel']}) berhasil ditambahkan\n";
                } else {
                    echo "✓ Admin {$user['nama_pelanggan']} berhasil ditambahkan\n";
                }
                
            } catch (\Exception $e) {
                echo "✗ Error inserting user {$user['nama_pelanggan']}: {$e->getMessage()}\n";
            }
        }
        
        echo "\n✓ UserSeeder berhasil dijalankan!\n";
        echo "Total user: " . count($users) . "\n";
        echo "Total pelanggan yang berhasil dibuat: " . Pelanggan::count() . "\n";
        
        // Tampilkan beberapa data pelanggan untuk verifikasi
        echo "\nData pelanggan yang tersedia:\n";
        $pelangganSample = Pelanggan::select('id_pel', 'nama_pelanggan', 'alamat')->limit(5)->get();
        foreach ($pelangganSample as $pel) {
            echo "- ID: {$pel->id_pel}, Nama: {$pel->nama_pelanggan}\n";
        }
    }
}