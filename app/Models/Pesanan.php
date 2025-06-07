<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    
    protected $fillable = [
        'nama_pemesan', 
        'nomor_resi',
        'no_hp',
        'alamat',
        'id_layanan',
        'id_lokasi',
        'tanggal_pemesanan',
        'berat', 
        'diskon',
        'catatan', 
        'status'
    ];

    // Relasi ke tabel layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id');
    }

    // Method untuk menghitung total harga
    public function getTotalAttribute()
    {
        $harga = $this->layanan->harga ?? 0;
        $berat = $this->berat ?? 0;
        $diskon = $this->diskon ?? 0;
        
        return ($harga * $berat) - $diskon;
    }
}