<p>Hai {{ $pesanan->nama_pemesan }},</p>
<p>Pesanan Anda telah berhasil dibuat.</p>
<p>Jumlah yang harus dibayar: Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
<p>ID Pesanan: #{{ $pesanan->id }}</p>
<p>Terima kasih!</p>