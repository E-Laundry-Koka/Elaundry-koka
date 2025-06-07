<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Pembayaran;
class PaymentController extends Controller
{
    // Tampilkan halaman daftar tagihan (invoice)
    public function index()
    {
        // Ambil data dari model Payment atau Invoice jika tersedia
        // $payments = \App\Models\Payment::where('user_id', auth()->id())->get();

        return view('payments.index'/*, compact('payments')*/);
    }

    // Tampilkan detail tagihan tertentu
    public function history(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'pembayaran.tanggal_pembayaran');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');
        $user = Auth::user();

        // Validasi kolom sortir
        $allowedSortColumns = [
            'pembayaran.tanggal_pembayaran',
            'pesanan.nama_pemesan',
            'pembayaran.jumlah_pembayaran'
        ];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'pembayaran.tanggal_pembayaran';
        }

        $sortOrder = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';

        // Query utama dengan relasi
        $query = Pesanan::whereHas('pembayaran') // Pastikan pesanan memiliki pembayaran
                        ->with('pembayaran');     // Eager load relasi

        // Filter lokasi jika bukan admin pusat
        if ($user && $user->role_id != 1) {
            $query->where('id_lokasi', $user->id_lokasi);
        }

        // Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%$search%")
                ->orWhere('nomor_resi', 'like', "%$search%");
            });
        }

        // Sorting
        if (str_starts_with($sortBy, 'pembayaran.')) {
            // Jika sort by field dari pembayaran, gunakan join
            $query->join('pembayaran', 'pesanan.id', '=', 'pembayaran.id_pesanan')
                ->select('pesanan.*', 'pembayaran.tanggal_pembayaran', 'pembayaran.jumlah_pembayaran')
                ->orderByRaw("{$sortBy} {$sortOrder}");
        } else {
            // Jika sort by field dari pesanan
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $payments = $query->paginate($perPage)->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage,
        ]);

        return view('payments.index', compact('payments', 'perPage', 'sortBy', 'sortOrder', 'search'));
    }


    // Proses pembayaran (jika diperlukan)
    public function pay(Request $request, $id)
    {
        // Lakukan validasi dan update status pembayaran
        // $payment = \App\Models\Payment::findOrFail($id);
        // $payment->status = 'paid';
        // $payment->save();

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diproses.');
    }

    // Unduh tagihan sebagai PDF
    public function download($id)
    {
        // Gunakan dompdf atau Laravel Snappy untuk generate PDF
        // $payment = \App\Models\Payment::findOrFail($id);

        // Contoh penggunaan dompdf:
        // $pdf = \PDF::loadView('payments.invoice', compact('payment'));
        // return $pdf->download('tagihan-'.$id.'.pdf');

        return response()->download(storage_path('app/public/sample-invoice.pdf')); // Contoh dummy
    }
}