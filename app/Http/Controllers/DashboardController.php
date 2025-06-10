<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $admin = User::all();
        $today = Carbon::today();

        // Cek apakah user adalah supervisor
        $isSupervisor = $user && $user->role_id == 1;

        // Ambil pesanan terbaru (limit 5), difilter jika bukan supervisor
        $pesananQuery = Pesanan::latest();
        if (!$isSupervisor) {
            $pesananQuery->where('id_lokasi', $user->id_lokasi);
        }
        $pesanan = $pesananQuery->take(5)->get();

        // Hitung total pesanan hari ini (konsisten menggunakan tanggal_pemesanan)
        $totalPesanan = $isSupervisor
            ? Pesanan::whereDate('tanggal_pemesanan', $today)->count()
            : Pesanan::where('id_lokasi', $user->id_lokasi)
                ->whereDate('tanggal_pemesanan', $today)
                ->count();

        // Total penjualan seluruh pembayaran yang sudah lunas (all time)
        $totalPenjualan = $isSupervisor
            ? Pembayaran::where('status_pembayaran', 'Lunas')->sum('jumlah_pembayaran')
            : Pembayaran::where('status_pembayaran', 'Lunas')
                ->whereHas('pesanan', function ($query) use ($user) {
                    $query->where('id_lokasi', $user->id_lokasi);
                })->sum('jumlah_pembayaran');

        // Pendapatan hari ini yang sudah lunas (berdasarkan tanggal pembayaran lunas)
        $totalpendapatanhariini = $isSupervisor
            ? Pembayaran::where('status_pembayaran', 'Lunas')
                ->whereDate('updated_at', $today)
                ->sum('jumlah_pembayaran')
            : Pembayaran::where('status_pembayaran', 'Lunas')
                ->whereDate('updated_at', $today)
                ->whereHas('pesanan', function ($query) use ($user) {
                    $query->where('id_lokasi', $user->id_lokasi);
                })->sum('jumlah_pembayaran');

        // Estimasi total pendapatan hari ini (semua pembayaran dari pesanan hari ini, termasuk yang belum lunas)
        $estimasitotalPendapatanPerHari = $isSupervisor
            ? Pembayaran::whereHas('pesanan', function ($query) use ($today) {
                $query->whereDate('tanggal_pemesanan', $today);
            })->sum('jumlah_pembayaran')
            : Pembayaran::whereHas('pesanan', function ($query) use ($user, $today) {
                $query->where('id_lokasi', $user->id_lokasi)
                    ->whereDate('tanggal_pemesanan', $today);
            })->sum('jumlah_pembayaran');

        return view('admin.dashboard', compact(
            'admin',
            'pesanan',
            'totalPesanan',
            'totalPenjualan',
            'totalpendapatanhariini',
            'estimasitotalPendapatanPerHari'
        ));
    }
}