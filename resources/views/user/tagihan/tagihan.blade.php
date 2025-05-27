<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pesanan #{{ $pesanan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Koka Laundry</h2>
        <p>Jl. Sudirman No. 123, Kota Bandung<br>
           Telp: 022-12345678 | Email: info@koka-laundry.com</p>
        <hr>
        <h4>Invoice Pesanan #{{ $pesanan->id }}</h4>
        <p>{{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="section">
        <p><span class="label">Nama Pemesan:</span> {{ $pesanan->nama_pemesan }}</p>
        <p><span class="label">No. HP:</span> {{ $pesanan->no_hp }}</p>
        <p><span class="label">Alamat:</span> {{ $pesanan->alamat }}</p>
    </div>

    <div class="section">
        <h5>Detail Layanan</h5>
        <table>
            <tr>
                <th>Layanan</th>
                <td>{{ $pesanan->layanan->nama_layanan }}</td>
            </tr>
            <tr>
                <th>Berat</th>
                <td>{{ $pesanan->berat }} Kg</td>
            </tr>
            <tr>
                <th>Harga Per Kg</th>
                <td>Rp {{ number_format($pesanan->layanan->harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Diskon</th>
                <td>{{ $pesanan->diskon ?? '0' }}%</td>
            </tr>
            <tr>
                <th>Total Bayar</th>
                <td class="text-right">Rp {{ number_format($jumlah_pembayaran, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h5>Status Pembayaran</h5>
        @if ($pesanan->pembayaran)
            <p><span class="label">Metode:</span> {{ $pesanan->pembayaran->metode_pembayaran }}</p>
            <p><span class="label">Status:</span> 
                @if ($pesanan->pembayaran->status_pembayaran == 'Lunas')
                    Lunas
                @else
                    Pending
                @endif
            </p>
        @else
            <p>Belum ada pembayaran.</p>
        @endif
    </div>

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda pada Koka Laundry!</p>
    </div>
</div>

</body>
</html>