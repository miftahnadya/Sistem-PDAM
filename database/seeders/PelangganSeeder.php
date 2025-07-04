<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        // Pastikan tarif sudah ada
        $defaultTarif = Tarif::first();
        if (!$defaultTarif) {
            $defaultTarif = Tarif::create([
                'kategori' => 'Rumah Tangga',
                'tarif_per_m3' => 2500,
                'biaya_admin' => 5000,
                'biaya_beban' => 0,
                'status' => 'AKTIF',
            ]);
        }

        $pelanggan = [
            [
                'id_pel' => '00323',
                'nama_pelanggan' => 'FADHIL RIDWAN',
                'alamat' => 'DUSUN MELUR, BUKIT RATA, KEJURUAN MUDA',
                'no_telepon' => '081200000323',
                'email' => 'fadhilridwan@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00357',
                'nama_pelanggan' => 'HANIF',
                'alamat' => 'PAYA BEDI, PAYA BEDI, RANTAU',
                'no_telepon' => '081200000357',
                'email' => 'hanif@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00382',
                'nama_pelanggan' => 'SYAHRUL AISYAH IMRAN',
                'alamat' => 'JL.SRI WIJAYA, SRIWIJAYA, KUALA SIMPANG',
                'no_telepon' => '081200000382',
                'email' => 'syahrulaisyahimran@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00451',
                'nama_pelanggan' => 'AISYAH',
                'alamat' => 'GG.BECEK, SRIWIJAYA, KUALA SIMPANG',
                'no_telepon' => '081200000451',
                'email' => 'aisyah@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00483',
                'nama_pelanggan' => 'SITI SULAIMAN',
                'alamat' => 'GG.BECEK, GG.BECEK, KUALA SIMPANG',
                'no_telepon' => '081200000483',
                'email' => 'sitisulaiman@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00522',
                'nama_pelanggan' => 'FAUZI ZAHRA ZULKARNAIN',
                'alamat' => 'GG.BECEK, GG.BECEK, KUALA SIMPANG',
                'no_telepon' => '081200000522',
                'email' => 'fauzizahrazulkarnain@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00526',
                'nama_pelanggan' => 'FADHIL',
                'alamat' => 'GG.BECEK, GG.BECEK, KUALA SIMPANG',
                'no_telepon' => '081200000526',
                'email' => 'fadhil@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00538',
                'nama_pelanggan' => 'MUHAMMAD IMRAN',
                'alamat' => 'JL SUTOYO, JL.SUTOYO, KUALA SIMPANG',
                'no_telepon' => '081200000538',
                'email' => 'muhammadimran@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00549',
                'nama_pelanggan' => 'FAUZI HIKMAH RIDWAN',
                'alamat' => 'JL.SUTOYO, JL.SUTOYO, KUALA SIMPANG',
                'no_telepon' => '081200000549',
                'email' => 'fauzihikmahridwan@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00591',
                'nama_pelanggan' => 'FAUZI FATIMAH',
                'alamat' => 'JL.SUTOYO, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000591',
                'email' => 'fauzifatimah@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00634',
                'nama_pelanggan' => 'SYAHRUL MUNAWWAR',
                'alamat' => 'JL.SUTOYO, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000634',
                'email' => 'syahrulmunawwar@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00655',
                'nama_pelanggan' => 'FAUZIAH',
                'alamat' => 'JL.SUTOYO, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000655',
                'email' => 'fauziah@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00661',
                'nama_pelanggan' => 'NURUL ZULKARNAIN',
                'alamat' => 'JL.PERDAMAIAN.LR.PJKA, PERDAMAIAN, KUALA SIMPANG',
                'no_telepon' => '081200000661',
                'email' => 'nurulzulkarnain@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00675',
                'nama_pelanggan' => 'RIZKI AISYAH SULAIMAN',
                'alamat' => 'JL.AE.SURYANI, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000675',
                'email' => 'rizkiaisyahsulaiman@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00692',
                'nama_pelanggan' => 'MUHAMMAD MUNAWAAR',
                'alamat' => 'JL.ISKANDAR MUDA, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000692',
                'email' => 'muhammadmunawaar@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00698',
                'nama_pelanggan' => 'IKHSAN',
                'alamat' => 'JL.ISKANDAR MUDA, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000698',
                'email' => 'ikhsan@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00702',
                'nama_pelanggan' => 'SITI MUNAWAR',
                'alamat' => 'JL.ISKANDAR MUDA, KOTA KSP, KUALA SIMPANG',
                'no_telepon' => '081200000702',
                'email' => 'sitimunawar@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00760',
                'nama_pelanggan' => 'RIZKI',
                'alamat' => 'SP.IV KOLITA,JL.PAJAK PAGI, KOTA LINTANG, KUALA SIMPANG',
                'no_telepon' => '081200000760',
                'email' => 'rizki@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => '00782',
                'nama_pelanggan' => 'RIZKI KOLITA',
                'alamat' => 'JL.KOLITA, DPN GG.GABUNGAN, KOTA LINTANG, KUALA SIMPANG',
                'no_telepon' => '081200000782',
                'email' => 'rizkikolita@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(rand(30, 365)),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            // Tambahan data pelanggan untuk testing
            [
                'id_pel' => 'PEL001',
                'nama_pelanggan' => 'Ahmad Suryadi',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'no_telepon' => '081234567890',
                'email' => 'ahmad.suryadi@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(30),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => 'PEL002',
                'nama_pelanggan' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta Selatan',
                'no_telepon' => '081234567891',
                'email' => 'siti.nurhaliza@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(60),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => 'PEL003',
                'nama_pelanggan' => 'Budi Santoso',
                'alamat' => 'Jl. Thamrin No. 789, Jakarta Barat',
                'no_telepon' => '081234567892',
                'email' => 'budi.santoso@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(90),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => 'PEL004',
                'nama_pelanggan' => 'Dewi Kartika',
                'alamat' => 'Jl. Gatot Subroto No. 321, Jakarta Timur',
                'no_telepon' => '081234567893',
                'email' => 'dewi.kartika@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(120),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
            [
                'id_pel' => 'PEL005',
                'nama_pelanggan' => 'Eko Prasetyo',
                'alamat' => 'Jl. Kuningan No. 654, Jakarta Utara',
                'no_telepon' => '081234567894',
                'email' => 'eko.prasetyo@pdam.com',
                'status_pelanggan' => 'AKTIF',
                'role' => 'pelanggan',
                'tgl_daftar' => now()->subDays(150),
                'tarif_id' => $defaultTarif->id_tarif,
                'created_by' => 1,
            ],
        ];

        echo "Mulai menambahkan data pelanggan...\n";
        $berhasil = 0;
        $gagal = 0;

        foreach ($pelanggan as $pel) {
            try {
                Pelanggan::create($pel);
                echo "✓ Pelanggan {$pel['nama_pelanggan']} (ID: {$pel['id_pel']}) berhasil ditambahkan\n";
                $berhasil++;
            } catch (\Exception $e) {
                echo "✗ Error menambahkan pelanggan {$pel['nama_pelanggan']}: {$e->getMessage()}\n";
                $gagal++;
            }
        }

        echo "\n=== RINGKASAN SEEDER ===\n";
        echo "✓ Total pelanggan berhasil ditambahkan: {$berhasil}\n";
        echo "✗ Total pelanggan gagal ditambahkan: {$gagal}\n";
        echo "✓ Total pelanggan dalam database: " . Pelanggan::count() . "\n";
        echo "✓ Tarif yang digunakan: {$defaultTarif->kategori} (ID: {$defaultTarif->id_tarif})\n";
        echo "=========================\n";
    }
}