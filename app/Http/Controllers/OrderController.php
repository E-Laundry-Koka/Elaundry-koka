<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Layanan;

class OrderController extends Controller
{
    // Tampilkan halaman form buat pesanan
    public function create()
    {
        $layanans = Layanan::all();
        $pesanan = Pesanan::all(); // ambil semua data pesanan
        return view('orders.create', compact('pesanan','layanans'));
    }

    // public function create(){
    //     $pesanan = Pesanan::with('customer')->get(); // eager load relasi customer
    //     return view('orders.create', compact('pesanan'));
    // }

    // Simpan pesanan baru (jika submit form)
    public function store(Request $request)
    {
        // HAPUS BARIS INI! - dd($request->all()); 
        // dd() akan menghentikan eksekusi sebelum data disimpan

        // Validasi input
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'id_layanan' => 'required|exists:layanan,id',
            'tanggal_pemesanan' => 'required|date',
            'berat' => 'required|numeric|min:0.1',
            'diskon' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:200',
            'metode_pembayaran' => 'required|string|max:255',
        ]);

        // Simpan pesanan ke database menggunakan create() method
        $pesanan=Pesanan::create([
            'nama_pemesan' => $validated['nama_pemesan'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'id_layanan' => $validated['id_layanan'],
            'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
            'berat' => $validated['berat'],
            'diskon' => $validated['diskon'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Proses' // default status baru
        ]);

        // Hitung jumlah pembayaran berdasarkan berat dan diskon
        $layanan = Layanan::findOrFail($validated['id_layanan']);
        $harga_per_kg = $layanan->harga;
        $jumlah_pembayaran = ($validated['berat'] * $harga_per_kg) - ($validated['berat'] * $harga_per_kg * ($validated['diskon'] / 100));

        // Buat entri pembayaran
        Pembayaran::create([
            'id_pesanan' => $pesanan->id,
            'jumlah_pembayaran' => $jumlah_pembayaran,
            'tanggal_pembayaran' => $validated['tanggal_pemesanan'],
        ]);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    // Tampilkan riwayat pesanan/pembayaran
    public function history()
    {
        return view('orders.history');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'diskon' => 'required|numeric|min:0',
            'status' => 'required|string|in:Proses,Selesai',
            'status_pembayaran' => 'required|string|in:Lunas,Belum Bayar',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'nama_pemesan' => $validated['nama_pemesan'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'berat' => $validated['berat'],
            'diskon' => $validated['diskon'],
            'status' => $validated['status'],
        ]);

        // Update pembayaran jika ada
        if ($pesanan->pembayaran) {
            $pesanan->pembayaran->update([
                'status_pembayaran' => $validated['status_pembayaran']
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $order = Pesanan::findOrFail($id);
            $order->delete();
            
            return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    // public function export()
    // {
    //     return Excel::download(new OrdersExport(), 'pesanan-laundry.xlsx');
    // }
}