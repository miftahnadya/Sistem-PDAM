<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pel',
        'nama_pelanggan',
        'alamat',
        'no_telepon',
        'email',
        'jenis_pelanggan',
        'status_aktif',
        'created_by',
        'updated_by'
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_pel', 'id_pel');
    }
}