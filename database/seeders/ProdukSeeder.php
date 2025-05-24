<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Layanan::insert([
            ['nama_layanan' => 'Cuci Kiloan', 'harga' => 10000],
            ['nama_layanan' => 'Setrika', 'harga' => 8000],
            ['nama_layanan' => 'Cuci Satuan', 'harga' => 15000],
        ]);
    }
}
