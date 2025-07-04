<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    public function run()
    {
        // Periksa kolom yang ada di tabel tarif
        $columns = Schema::getColumnListing('tarif');
        echo "Kolom tarif: " . implode(', ', $columns) . "\n";
        
        // Buat beberapa data tarif berdasarkan kategori
        $tarifData = [
            [
                'kategori' => 'Rumah Tangga',
                'tarif_per_m3' => 2000,
                'biaya_admin' => 5000,
                'biaya_beban' => 0,
            ],
            [
                'kategori' => 'Komersial',
                'tarif_per_m3' => 3000,
                'biaya_admin' => 7500,
                'biaya_beban' => 2000,
            ],
            [
                'kategori' => 'Industri',
                'tarif_per_m3' => 4000,
                'biaya_admin' => 10000,
                'biaya_beban' => 5000,
            ],
            [
                'kategori' => 'Sosial',
                'tarif_per_m3' => 1500,
                'biaya_admin' => 3000,
                'biaya_beban' => 0,
            ],
        ];
        
        // Buat tarif jika belum ada
        if (Tarif::count() == 0) {
            foreach ($tarifData as $data) {
                $tarif = Tarif::create($data);
                echo "✓ Tarif {$data['kategori']} berhasil dibuat dengan ID: {$tarif->id_tarif}\n";
            }
        } else {
            echo "✓ Tarif sudah ada\n";
        }
        
        echo "\n✓ TarifSeeder berhasil dijalankan!\n";
        echo "Total tarif: " . count($tarifData) . "\n";
    }
}