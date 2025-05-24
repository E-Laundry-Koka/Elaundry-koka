<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
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
    public function history()
    {
        $pesanan = Pesanan::with('pembayaran')->get();
        return view('payments.index', compact('pesanan'));
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