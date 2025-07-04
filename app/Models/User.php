<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_pel',
        'id_meter',
        'nama_pelanggan',
        'password',
        'role',
        'goltar',
        'alamat',
        'desa',
        'kecamatan',
        'rute',
        'merek_meter',
        'status_pelanggan',
        'status_meter',
        'angka_meter_kini',
        'periode_terakhir',
        'jumlah_bulan_rekening',
        'total_pemakaian_m3',
        'harga_air',
        'biaya_admin',
        'denda',
        'total_tagihan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'harga_air' => 'decimal:2',
        'biaya_admin' => 'decimal:2',
        'denda' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'user_id');
    }

    // Accessor untuk nama (untuk compatibility)
    public function getNameAttribute()
    {
        return $this->nama_pelanggan;
    }

    // Accessor untuk email (untuk compatibility)
    public function getEmailAttribute()
    {
        return $this->id_pel . '@pdam.com';
    }
}