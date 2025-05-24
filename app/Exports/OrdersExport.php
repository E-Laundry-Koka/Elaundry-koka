<?
// app/Exports/OrdersExport.php
namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pesanan::all();
    }

    public function headings(): array
    {
        return [
            'Nama Pemesan',
            'Produk',
            'Jumlah',
            'Harga',
            'Diskon (%)',
            'Pembayaran',
            'Pemesanan',
        ];
    }
}