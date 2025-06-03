<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class UserOrderController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        
        // Debug: tampilkan data lengkap dengan attributes (hapus setelah selesai)
        // dd($layanans->toArray());
        
        return view('user.form_pemesanan', compact('layanans'));
    }

    public function store(Request $request)
    {
        // HAPUS BARIS INI! - dd($request->all()); 
        // dd() akan menghentikan eksekusi sebelum data disimpan
        // Validasi input
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|min:12|max:13',
            'alamat' => 'required|string',
            'id_layanan' => 'required|exists:layanan,id',
            'berat' => 'required|numeric|min:0.1',
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
            'tanggal_pemesanan' => now(),
            'berat' => $validated['berat'],
            'diskon' => 0.0,
            'catatan' => $validated['catatan'] ?? ' ',
            'status' => 'Konfirmasi Admin' // default status baru
        ]);

        // Hitung jumlah pembayaran berdasarkan berat dan diskon
        $layanan = Layanan::findOrFail($validated['id_layanan']);
        $harga_per_kg = (float)$layanan->harga;

        // Hitung pembayaran
        $berat = (float)$pesanan->berat;
        $diskon = (float)$pesanan->diskon;

        $total_harga = $berat * $harga_per_kg;
        $jumlah_pembayaran = $total_harga - ($total_harga * ($diskon / 100));

        // Buat entri pembayaran
        Pembayaran::create([
            'id_pesanan' => $pesanan->id,
            'jumlah_pembayaran' => $jumlah_pembayaran,
            'tanggal_pembayaran' => null,
        ]);

        // Generate file pesanan
        $this->generatePesananFile($pesanan, $layanan, $jumlah_pembayaran, $validated['metode_pembayaran']);

        // Redirect dengan SweetAlert
        return redirect()->back()->with([
            'success' => 'Pesanan berhasil dibuat!',
            'download_link' => url('/user-order/download-pesanan/' . $pesanan->id)
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


    /**
     * Method helper untuk generate file pesanan
     */
    private function generatePesananFile($pesanan, $layanan = null, $jumlah_pembayaran = null, $metode_pembayaran = null)
    {
        // Jika parameter tidak diberikan, hitung ulang
        if (!$layanan) {
            $layanan = Layanan::find($pesanan->id_layanan);
        }
        
        if (!$jumlah_pembayaran) {
            $harga_per_kg = (float)$layanan->harga;
            $berat = (float)$pesanan->berat;
            $diskon = (float)$pesanan->diskon;
            $total_harga = $berat * $harga_per_kg;
            $jumlah_pembayaran = $total_harga - ($total_harga * ($diskon / 100));
        }

        // Buat konten file txt
        $content = "Detail Pesanan\n";
        $content .= "==============\n";
        $content .= "Nomor Resi      : " . $pesanan->nomor_resi . "\n";
        $content .= "Nama Pemesan   : " . $pesanan->nama_pemesan . "\n";
        $content .= "No HP           : " . $pesanan->no_hp . "\n";
        $content .= "Alamat          : " . $pesanan->alamat . "\n";
        $content .= "Tanggal         : " . $pesanan->created_at->format('d M Y') . "\n";
        $content .= "Jenis Layanan   : " . ($layanan ? $layanan->nama_layanan : 'Layanan tidak ditemukan') . "\n";
        $content .= "Harga Layanan   : Rp. " . number_format($layanan->harga, 0, ',', '.') . "/kg\n";
        $content .= "Berat           : " . $pesanan->berat . " Kg\n";
        $content .= "Metode Bayar    : " . ($metode_pembayaran ?: 'Tidak tersedia') . "\n";
        $content .= "Total Harga     : Rp. " . number_format($jumlah_pembayaran, 0, ',', '.') . "\n";
        $content .= "Catatan         : " . $pesanan->catatan;

        // Buat PDF
        // $pdf = Pdf::loadView('user.order.invoice', compact('pesanan', 'layanan', 'totalHarga'));
        
        // Simpan file menggunakan Storage facade
        $fileName = 'detail_pesanan_' . $pesanan->nama_pemesan . '.txt';
        $filePath = 'public/pesanan/' . $fileName;

        // Storage::put akan otomatis membuat direktori jika belum ada
        Storage::put($filePath, $content);

        return $filePath;
    }

    public function downloadPesanan($id)
    {
        try {
            // Cari pesanan berdasarkan ID
            $pesanan = Pesanan::with('layanan')->findOrFail($id);
            
            // Nama file yang akan didownload
            $fileName = 'detail_pesanan_' . $pesanan->nama_pemesan . '.txt';
            $filePath = 'public/pesanan/' . $fileName;
            
            // Cek apakah file exists
            if (!Storage::exists($filePath)) {
                // Jika file tidak ada, buat ulang
                $this->generatePesananFile($pesanan);
            }
            
            // Download file
            return Storage::download($filePath, $fileName, [
                'Content-Type' => 'text/plain',
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'File tidak ditemukan atau terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ALTERNATIF: Method download tanpa menyimpan file (lebih simple)
    public function downloadPesananDirect($id)
    {
        try {
            $pesanan = Pesanan::with('layanan')->findOrFail($id);
            
            // Hitung total harga
            $layanan = $pesanan->layanan;
            $harga_per_kg = (float)$layanan->harga;
            $berat = (float)$pesanan->berat;
            $diskon = (float)$pesanan->diskon;
            $total_harga = $berat * $harga_per_kg;
            $jumlah_pembayaran = $total_harga - ($total_harga * ($diskon / 100));
            
            // Buat konten file
            $content = "Detail Pesanan\n";
            $content .= "==============\n";
            $content .= "ID Pesanan      : " . $pesanan->id . "\n";
            $content .= "Nama Pemesan   : " . $pesanan->nama_pemesan . "\n";
            $content .= "No HP           : " . $pesanan->no_hp . "\n";
            $content .= "Alamat          : " . $pesanan->alamat . "\n";
            $content .= "Jenis Layanan   : " . $layanan->nama_layanan . "\n";
            $content .= "Berat           : " . $pesanan->berat . " Kg\n";
            $content .= "Diskon          : " . $pesanan->diskon . "%\n";
            $content .= "Total Harga     : Rp " . number_format($jumlah_pembayaran, 0, ',', '.') . "\n";
            $content .= "Metode Bayar    : Tidak tersedia\n";
            $content .= "Tanggal         : " . $pesanan->created_at->format('d M Y H:i:s') . "\n";
            
            $fileName = 'detail_pesanan_' . $pesanan->nama_pemesan . '.txt';
            
            // Return response download langsung tanpa menyimpan file
            return response($content)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }
    }

    public function downloadPdf($id)
    {
        $pesanan = Pesanan::with(['layanan', 'pembayaran'])->findOrFail($id);
        
        // Hitung total bayar
        $totalBayar = ($pesanan->berat * $pesanan->layanan->harga) - 
                    ($pesanan->berat * $pesanan->layanan->harga * ($pesanan->diskon / 100));

        // Kirim ke view PDF
        $pdf = Pdf::loadView('user.tagihan.tagihan', compact('pesanan', 'totalBayar'));

        return $pdf->download("Detail_pesanan_{$id}.pdf");
    }

    // public function export()
    // {
    //     return Excel::download(new OrdersExport(), 'pesanan-laundry.xlsx');
    // }

    public function checkStatusShow(){
        return view('user.check-status') ;
    }
    
    public function checkStatus(Request $request)
    {
        $validated = $request->validate([
            'nomor_resi' => 'required|exists:pesanan,nomor_resi' // cari berdasarkan nomor_resi
        ]);

        try {
            $pesanan = Pesanan::with(['layanan', 'pembayaran'])
                ->where('nomor_resi', $validated['nomor_resi'])
                ->firstOrFail();

            $totalBayar = ($pesanan->berat * $pesanan->layanan->harga) - 
                        ($pesanan->berat * $pesanan->layanan->harga * ($pesanan->diskon / 100));

            return view('user.check-status', compact('pesanan', 'totalBayar'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Nomor resi tidak ditemukan.');
        }
    }

    public function simpanPesanan(Request $request)
    {
        $isi = "Contoh isi pesanan";

        // Buat folder jika belum ada
        Storage::makeDirectory('public/pesanan');

        // Simpan file
        Storage::put('public/pesanan/detail_pesanan_2.txt', $isi);

        return response()->json(['message' => 'File berhasil disimpan!']);
    }
}