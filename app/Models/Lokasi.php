<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    
    protected $fillable = [
        'nama_lokasi', 
        'alamat', 
        'kota', 
        'kode_pos'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id_lokasi');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_lokasi');
    }
}
