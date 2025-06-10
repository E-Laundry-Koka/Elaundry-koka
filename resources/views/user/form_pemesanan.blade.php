<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Form Pemesanan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #194376;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-card {
      background: #fff;
      border-radius: 15px;
      padding: 40px 30px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 60px auto;
    }

    h3 {
      color: #194376;
      text-align: center;
      margin-bottom: 25px;
    }

    .btn-primary {
      background-color: #194376;
      border-color: #194376;
    }

    .btn-primary:hover {
      background-color: #163a68;
    }

    .btn-success {
      width: 100%;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 15px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .navigation-buttons {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    /* Animasi Slide */
    .form-step {  
      opacity: 1;
      transition: transform 0.5s ease, opacity 0.5s ease;
    }

    .animate-slide-enter {
      transform: translateX(100%);
      opacity: 0;
    }

    .animate-slide-leave {
      transform: translateX(-100%);
      opacity: 0;
    }

    .navigation-buttons button {
        width: 50%;
    }

    .full-width {
        width: 100% !important;
    }
  </style>
</head>
<body>
<a href="/" class="position-absolute top-0 start-0 m-4 d-flex align-items-center text-white text-decoration-none">
    <div class="back-button me-2">
        <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
    </div>
    <span>Kembali</span>
</a>

<div class="form-card">
    <form id="multiStepForm" action="{{ route('user_order.store') }}" method="POST">
        @csrf
        <!-- Step 1 -->
        <div class="form-step" id="step1">
            <h3>Selamat Datang!</h3>
            <img src="{{ asset('img/blog-1.jpg') }}" alt="Welcome Image" class="w-100 mb-3" style="border-radius: 10px;">
            <p class="text-center">Kami senang Anda memilih layanan kami. Silakan ikuti langkah-langkah berikut untuk memesan layanan.</p>
        </div>

        <!-- Step 2 -->
        <div class="form-step" id="step2">
            <h3>Layanan Kami</h3>
            <img src="{{ asset('img/blog-2.jpg') }}" alt="Services Image" class="w-100 mb-3" style="border-radius: 10px;">
            <ul class="list-group">
                <li class="list-group-item">Layanan Cuci Komplit</li>
                <li class="list-group-item">Layanan Cuci + Lipat</li>
                <li class="list-group-item">Layanan Setrika Saja</li>
                <li class="list-group-item">Layanan Cuci Cepat (Express)</li>
            </ul>
        </div>

        <!-- Step 3 -->
        <div class="form-step" id="step3">
            <h3>Ayo Mulai Pesan!</h3>
      <p class="text-center">Tidak perlu menunggu lama. Langkah pertama adalah mengisi data profile Anda untuk melanjutkan pemesanan.</p>
        </div>

        <!-- Step 4 -->
        <div class="form-step" id="step4">
            <h3>Data Profile</h3>
            <input type="text" class="form-control" name="nama_pemesan" placeholder="Nama Lengkap" pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan" required>
            <small>contoh: Budi Santoso.</small>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <small>contoh: budi@example.com</small>
            <input type="tel" class="form-control" name="no_hp" placeholder="Nomor Telepon" minlength="12" maxlength="13" pattern="^08\d{10,11}$" title="Masukkan nomor telepon dengan benar" required>
            <small>contoh: 08xxxxxxx</small>
            <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
            <small>Tulis alamat lengkap dan kode pos jika ada.</small>
        </div>

        <!-- Step 5 -->
        <div class="form-step d-none" id="step5">
            <h3>Pilihan Layanan</h3>
            <select name="id_layanan" class="form-control" id="layananSelect" required>
                <option value="">Pilih layanan</option>
                @foreach ($layanans as $layanan)
                    <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                        {{ $layanan->nama_layanan }}
                    </option>
                @endforeach
            </select>

            <!-- Tempat menampilkan harga -->
            <div id="hargaDisplay" class="mb-2 text-success d-none">
                Harga layanan: <span id="hargaPerKg"></span> /kg
            </div>

            <!-- Input Berat -->
            <input type="number" class="form-control" name="berat" id="inputBerat" placeholder="Berat (Kg)" min="5.0" step="0.1" required disabled>

            <!-- Input Lokasi Cabang -->
            <select name="id_lokasi" class="form-control" id="lokasiSelect" required>
                <option value="">Pilih Cabang</option>
                @foreach ($lokasiList as $lokasi)
                    <option value="{{ $lokasi->id }}">
                        {{ $lokasi->nama_lokasi }}
                    </option>
                @endforeach
            </select>
            
            <!-- Catatan -->
            <textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan" rows="2"></textarea>
        </div>

        <!-- Step 6 -->
        <div class="form-step d-none" id="step6">
            <h3>Metode Pembayaran</h3>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">Pilih metode</option>
                <option value="Transfer Bank" disabled>Transfer Bank (Sementara Tidak Tersedia)</option>
                <option value="QRIS" disabled>QRIS (Sementara Tidak Tersedia)</option>
                <option value="Cash">Bayar di Tempat (COD)</option>
            </select>
        </div>

        <!-- Step 7
        <div class="form-step d-none" id="step7">
            <h3>Verifikasi Pembayaran</h3>
            <input type="text" class="form-control" name="kode_verifikasi" placeholder="Masukkan Kode Verifikasi">
            <input type="file" class="form-control" name="bukti_bayar">
        </div> -->
        

        <!-- Navigasi -->
        <div class="navigation-buttons mt-3">
            <button type="button" class="btn btn-secondary w-50" onclick="changeStep(-1)" id="backBtn">Back</button>
            <button type="button" class="btn btn-primary w-50" onclick="changeStep(1)" id="nextBtn">Next</button>
            <button type="submit" class="btn btn-success w-100 d-none" id="submitBtn">
                <i class="bi bi-check-circle me-1"></i> Submit Pesanan
            </button>
        </div>
    </form>
</div>  

<script>
let currentStep = 0;
const steps = document.querySelectorAll('.form-step');
const backBtn = document.querySelector('.btn-secondary');
const nextBtn = document.querySelector('.btn-primary');
const submitSection = document.getElementById('submitSection');
const submitBtn = document.getElementById('submitBtn');

function showStep(index) {
    steps.forEach((step, i) => {
        step.classList.toggle('d-none', i !== index);
    });

    // Tombol Back
    backBtn.classList.toggle('d-none', index === 0);

    // Tombol Next & Submit
    if (index === steps.length - 1) {
        nextBtn.classList.add('d-none');
        submitBtn.classList.remove('d-none');
    } else {
        nextBtn.classList.remove('d-none');
        submitBtn.classList.add('d-none');
    }
}

function changeStep(direction) {
    if (direction === 1 && !validateStep()) return;

    // Cek metode pembayaran
    const paymentMethod = document.querySelector('[name="metode_pembayaran"]').value;

    if (currentStep === 2 && paymentMethod === 'Cash') {
        // Langsung ke step submit jika metode pembayaran Cash
        currentStep = 3; // skip verifikasi
    }

    currentStep += direction;

    // Pastikan tidak melebihi jumlah langkah
    if (currentStep < 0) currentStep = 0;
    if (currentStep >= steps.length) currentStep = steps.length - 1;

    showStep(currentStep);
}

function validateStep() {
    const inputs = steps[currentStep].querySelectorAll('input, select');
    for (let input of inputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return false;
        }
    }
    return true;
}

showStep(currentStep);

document.addEventListener('DOMContentLoaded', function () {
    const layananSelect = document.getElementById('layananSelect');
    const hargaDisplay = document.getElementById('hargaDisplay');
    const hargaPerKgSpan = document.getElementById('hargaPerKg');
    const inputBerat = document.getElementById('inputBerat');

    if (layananSelect) {
        layananSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');

            if (harga) {
                hargaPerKgSpan.textContent = 'Rp ' + parseFloat(harga).toLocaleString('id-ID');
                hargaDisplay.classList.remove('d-none');
                inputBerat.disabled = false; // aktifkan input berat
            } else {
                hargaDisplay.classList.add('d-none');
                inputBerat.disabled = true;
                inputBerat.value = '';
            }
        });
    }
});


</script>

<!-- SweetAlert untuk Success Message -->
@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadLink = "{{ session('download_link') ?? '' }}";
            
            Swal.fire({
                icon: 'success',
                title: 'Pesanan Berhasil Dibuat!',
                text: 'Silakan unduh file detail pesanan Anda.',
                footer: downloadLink ? 
                    '<a href="' + downloadLink + '" class="btn btn-success mt-2">Unduh Detail (.txt)</a>' : 
                    '<p class="text-muted">Link download tidak tersedia</p>',
                confirmButtonColor: '#194376'
            });
        });
    </script>
@endif

</body>
</html>
