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
    public function create(Request $request)
    {
        $perPage = $request->input('per_page', 10); // jumlah data per halaman
        $sortBy = $request->input('sort_by', 'created_at'); // kolom pengurutan
        $sortOrder = $request->input('sort_order'); // arah pengurutan

        $layanans = Layanan::all();

        $query = Pesanan::with('layanan');

        // Hanya gunakan orderBy jika sortOrder valid
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Jika tidak valid, gunakan default (desc)
            $query->orderBy($sortBy, 'desc');
        }

        $pesanan = $query->paginate($perPage);

        return view('orders.create', compact('pesanan', 'layanans', 'perPage', 'sortBy', 'sortOrder'));
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

        // Berikan nilai default untuk catatan jika kosong
        $validatedData['catatan'] = $validatedData['catatan'] ?? 'Tidak ada catatan';

        $nomorResi = $this->generateNomorResi();

        // Simpan pesanan ke database menggunakan create() method
        $pesanan=Pesanan::create([
            'nomor_resi' => $nomorResi,
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

        // Redirect dengan SweetAlert
        return redirect()->back()->with([
            'success' => 'Pesanan berhasil dibuat!'
        ]);
    }

    private function generateRandomLetters()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($letters), 0, 4);
    }
    
    private function generateNomorResi()
    {
        $tanggal = now()->format('Ymd'); // Format: YYYYMMDD
        $randomLetters = $this->generateRandomLetters(); // 4 huruf acak

        // Hitung jumlah pesanan hari ini dengan prefix tanggal
        $jumlahHariIni = Pesanan::whereDate('created_at', now())
            ->where('nomor_resi', 'like', "{$randomLetters}{$tanggal}%")
            ->count();

        $urutan = str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT); // 001, 002, dst

        return "{$randomLetters}{$tanggal}-{$urutan}";
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
}