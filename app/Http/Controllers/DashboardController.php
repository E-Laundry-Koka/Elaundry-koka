<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah pesanan
        $totalPesanan = Pesanan::count();

        // Hitung total penjualan (jumlah_pembayaran dari tabel pembayaran)
        $totalPenjualan = Pembayaran::sum('jumlah_pembayaran');

        return view('admin.dashboard', compact('totalPesanan', 'totalPenjualan'));
    }
}