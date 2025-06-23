<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'id_pelanggan',
        'remember_token',
        'role',
    ];

    public function getAuthIdentifierName()
    {
        return 'nama_pelanggan';
    }

    public function getAuthPassword()
    {
        return $this->id_pelanggan;
    }
}