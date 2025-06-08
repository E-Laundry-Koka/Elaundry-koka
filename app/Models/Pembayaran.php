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
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id');
    }

    // Mutator - untuk set data
    public function setStatusPembayaranAttribute($value)
    {
        $this->attributes['status_pembayaran'] = $value;
        
        if ($value === 'Lunas' && empty($this->attributes['tanggal_pembayaran'])) {
            $this->attributes['tanggal_pembayaran'] = now();
        } elseif ($value !== 'Lunas') {
            $this->attributes['tanggal_pembayaran'] = null;
        }
    }

    // Accessor - untuk get/tampilkan data
    public function getTanggalPembayaranAttribute($value)
    {
        // Hanya return tanggal jika status Lunas
        if ($this->attributes['status_pembayaran'] === 'Lunas') {
            return $value;
        }
        
        return null;
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