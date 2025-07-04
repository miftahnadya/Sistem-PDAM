<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_tagihan',
        'id_pel',
        'periode',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
        'tarif_per_m3',
        'biaya_admin',
        'total_tagihan',
        'status_bayar',
        'tgl_tagihan',
        'tgl_batas_bayar',
        'keterangan',
        'created_by'
    ];
    
    protected $casts = [
        'tgl_tagihan' => 'date',
        'tgl_batas_bayar' => 'date',
    ];
    
    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pel', 'id_pel');
    }
    
    // Relasi ke user (untuk koneksi saat cek tagihan)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pel', 'id_pel');
    }
}