<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan'; // atau 'pengaduans' sesuai nama tabel

    protected $fillable = [
        'ticket_number',
        'nama_pelanggan',
        'id_pelanggan',
        'alamat',
        'no_hp',
        'kategori',
        'judul',
        'detail_pengaduan',
        'files',
        'status',
        'tanggal_pengaduan',
        'response_admin',
        'tanggal_response',
        'user_id'
    ];

    protected $casts = [
        'files' => 'array', 
        'tanggal_pengaduan' => 'datetime',
        'tanggal_response' => 'datetime'
    ];
}