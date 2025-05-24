<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'id_pesanan',
        'metode_pembayaran',
        'jumlah_pembayaran',
        'tanggal_pembayaran',
        'status_pembayaran'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';
    
    protected $fillable = [
        'metode_pembayaran',
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}