<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

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
        'prioritas',
        'response_admin',
        'tanggal_response',
        'admin_id'
    ];

    protected $casts = [
        'files' => 'array',
        'tanggal_response' => 'datetime'
    ];

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber()
    {
        $prefix = 'PDAM';
        $date = date('Ymd');
        $lastTicket = self::where('ticket_number', 'like', $prefix . $date . '%')
                         ->orderBy('ticket_number', 'desc')
                         ->first();
        
        if ($lastTicket) {
            $lastNumber = intval(substr($lastTicket->ticket_number, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        
        return $prefix . $date . $newNumber;
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'ditutup' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get priority color class
     */
    public function getPriorityColorAttribute()
    {
        return match($this->prioritas) {
            'tinggi' => 'bg-red-100 text-red-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'rendah' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}