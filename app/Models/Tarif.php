<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif';
    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'kategori',
        'tarif_per_m3',
        'biaya_admin',
        'biaya_beban',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tarif_per_m3' => 'decimal:2',
        'biaya_admin' => 'decimal:2',
        'biaya_beban' => 'decimal:2',
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'tarif_id', 'id_tarif');
    }

    // Relasi ke user yang membuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke user yang mengupdate
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessor untuk format rupiah
    public function getFormattedTarifPerM3Attribute()
    {
        return 'Rp ' . number_format($this->tarif_per_m3, 0, ',', '.');
    }

    public function getFormattedBiayaAdminAttribute()
    {
        return 'Rp ' . number_format($this->biaya_admin, 0, ',', '.');
    }

    public function getFormattedBiayaBebanAttribute()
    {
        return 'Rp ' . number_format($this->biaya_beban, 0, ',', '.');
    }

    // Scope untuk filter
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Method untuk menghitung total biaya berdasarkan pemakaian
    public function hitungTotalBiaya($pemakaian, $biaya_denda = 0, $denda = 0)
    {
        $biaya_air = $pemakaian * $this->tarif_per_m3;
        return $biaya_air + $this->biaya_admin + $this->biaya_beban + $biaya_denda + $denda;
    }
}