<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_lokasi',
        'no_hp',
        'foto_profile',
        'alamat'
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
