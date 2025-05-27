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
            ['nama_layanan' => 'Cuci Komplit', 'harga' => 7000],
            ['nama_layanan' => 'Cuci + Lipat', 'harga' => 5000],
            ['nama_layanan' => 'Setrika', 'harga' => 5000],
            ['nama_layanan' => 'Koka Express', 'harga' => 10000],
        ]);
    }
}
