<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::latest()->take(5)->get();
        // Hitung jumlah pesanan
        $totalPesanan = Pesanan::count();
        
        $totalPenjualan = Pembayaran::where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran');
        
        $today = Carbon::today();
        
        $estimasitotalPendapatanPerHari = Pembayaran::WhereDate('updated_at', $today)
            ->sum('jumlah_pembayaran');

        $totalpendapatanhariini = Pembayaran::WhereDate('updated_at', $today)
            ->where('status_pembayaran', 'Lunas')
            ->sum('jumlah_pembayaran');

        return view('admin.dashboard', compact('pesanan', 'totalPesanan', 'totalPenjualan', 'totalpendapatanhariini', 'estimasitotalPendapatanPerHari'));
    }
}