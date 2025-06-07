<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
// use App\Http\PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Pembayaran;
use App\Models\Lokasi;
use App\Models\User;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Layanan;

class OrderController extends Controller
{
    // Tampilkan halaman form buat pesanan
    public function create(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 10); // jumlah data per halaman
        $sortBy = $request->input('sort_by', 'created_at'); // kolom pengurutan
        $sortOrder = $request->input('sort_order'); // arah pengurutan
        $search = $request->input('search');
        $query = Pesanan::with(['layanan', 'lokasi']);
        $layanans = Layanan::all();
        $lokasiList = Lokasi::all();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%$search%")
                ->orWhere('nomor_resi', 'like', "%$search%")
                ->orWhere('no_hp', 'like', "%$search%");
            });
        }
        // Query dasar

        // Tambahkan filter berdasarkan role
        if ($user && $user->role_id != 1) {
            // Bukan supervisor, filter berdasarkan lokasi
            $query->where('id_lokasi', $user->id_lokasi);
        }

        // Hanya gunakan orderBy jika sortOrder valid
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy($sortBy, 'desc');
        }

        $pesanan = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'search' => $search,
        ]);

        return view('orders.create', compact('pesanan', 'layanans', 'perPage', 'sortBy', 'sortOrder', 'lokasiList', 'search'));
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
            'id_lokasi' => 'required|exists:lokasi,id',
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
            'id_lokasi' => $validated['id_lokasi'],
            'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
            'berat' => $validated['berat'],
            'diskon' => $validated['diskon'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Konfirmasi Admin' // default status baru
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
            'id_layanan' => 'required|exists:layanan,id',
            'id_lokasi' => 'required|exists:lokasi,id',
            'berat' => 'required|numeric|min:0.1',
            'diskon' => 'required|numeric|min:0',
            'status' => 'required|string|in:Konfirmasi Admin,Dalam Penjemputan,Proses,Dalam Pengantaran,Selesai',
            'status_pembayaran' => 'required|string|in:Lunas,Belum Bayar',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'nama_pemesan' => $validated['nama_pemesan'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'id_layanan' => $validated['id_layanan'],
            'id_lokasi' => $validated['id_lokasi'],
            'berat' => $validated['berat'],
            'diskon' => $validated['diskon'],
            'status' => $validated['status'],
            'status_pembayaran' => $validated['status_pembayaran'],
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

    public function export(Request $request)
    {
        // Ambil data pesanan dengan relasi
        $pesanan = Pesanan::with(['layanan', 'pembayaran'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul dokumen
        $sheet->setTitle('Data Pesanan Laundry');

        // Header Excel
        $sheet->setCellValue('A1', 'LAPORAN DATA PESANAN KOKA LAUNDRY');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Tanggal export
        $sheet->setCellValue('A2', 'Tanggal Export: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header tabel
        $headers = [
            'A4' => 'No',
            'B4' => 'Nomor Resi',
            'C4' => 'Nama Pemesan',
            'D4' => 'No. Handphone',
            'E4' => 'Alamat',
            'F4' => 'Layanan',
            'G4' => 'Lokasi',
            'H4' => 'Berat (Kg)',
            'I4' => 'Harga/Kg',
            'J4' => 'Diskon (%)',
            'K4' => 'Total Bayar',
            'L4' => 'Status',
            'M4' => 'Metode Pembayaran',
            'N4' => 'Status Pembayaran',
            'O4' => 'Tanggal Pemesanan'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header
        $headerRange = 'A4:O4';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
              ->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FF4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Data pesanan
        $row = 5;
        $no = 1;
        
        foreach ($pesanan as $item) {
            // Hitung total bayar
            $total = 0;
            if ($item->layanan) {
                $total = $item->berat * $item->layanan->harga;
                $total -= $total * (($item->diskon ?? 0) / 100);
            }

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item->nomor_resi ?? '-');
            $sheet->setCellValue('C' . $row, $item->nama_pemesan);
            $sheet->setCellValue('D' . $row, $item->no_hp);
            $sheet->setCellValue('E' . $row, $item->alamat);
            $sheet->setCellValue('F' . $row, $item->layanan->nama_layanan ?? '-');
            $sheet->setCellValue('G' . $row, $item->lokasi->nama_lokasi ?? '-');
            $sheet->setCellValue('H' . $row, $item->berat);
            $sheet->setCellValue('I' . $row, $item->layanan ? 'Rp ' . number_format($item->layanan->harga, 0, ',', '.') : '-');
            $sheet->setCellValue('J' . $row, $item->diskon ?? 0);
            $sheet->setCellValue('K' . $row, $total > 0 ? 'Rp ' . number_format($total, 0, ',', '.') : '-');
            $sheet->setCellValue('L' . $row, $item->status);
            $sheet->setCellValue('M' . $row, $item->pembayaran->metode_pembayaran ?? '-');
            $sheet->setCellValue('N' . $row, $item->pembayaran->status_pembayaran ?? 'Belum Bayar');
            $sheet->setCellValue('O' . $row, $item->tanggal_pemesanan ? date('d/m/Y', strtotime($item->tanggal_pemesanan)) : '-');

            $row++;
            $no++;
        }

        // Auto size kolom
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border untuk semua data
        $dataRange = 'A4:O' . ($row - 1);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Center alignment untuk kolom tertentu
        $centerColumns = ['A', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
        foreach ($centerColumns as $col) {
            $sheet->getStyle($col . '5:' . $col . ($row - 1))
                  ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Set nama file
        $filename = 'Data_Pesanan_Laundry_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Response untuk download
        $writer = new Xlsx($spreadsheet);
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
            'Cache-Control' => 'max-age=1',
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
            'Cache-Control' => 'cache, must-revalidate',
            'Pragma' => 'public',
        ]);
    }
}