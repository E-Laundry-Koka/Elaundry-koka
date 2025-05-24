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
  </style>
</head>
<body>

<div class="form-card">
  <form id="multiStepForm">
    <!-- Step 1 -->
    <div class="form-step" id="step1">
      <h3>Data Profile</h3>
      <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
      <input type="email" class="form-control" name="email" placeholder="Email" required>
      <input type="tel" class="form-control" name="telepon" placeholder="Nomor Telepon" required>
    </div>

    <!-- Step 2 -->
    <div class="form-step d-none" id="step2">
      <h3>Pilihan Layanan</h3>
      <select name="layanan" class="form-control" required>
        <option value="">Pilih layanan</option>
        <option value="Cuci">Cuci</option>
        <option value="Setrika">Setrika</option>
        <option value="Cuci + Setrika">Cuci + Setrika</option>
      </select>
    </div>

    <!-- Step 3 -->
    <div class="form-step d-none" id="step3">
      <h3>Metode Pembayaran</h3>
      <select name="pembayaran" class="form-control" required>
        <option value="">Pilih metode</option>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="QRIS">QRIS</option>
        <option value="COD">Bayar di Tempat (COD)</option>
      </select>
    </div>

    <!-- Step 4 -->
    <div class="form-step d-none" id="step4">
      <h3>Verifikasi Pembayaran</h3>
      <input type="text" class="form-control" name="kode_verifikasi" placeholder="Masukkan Kode Verifikasi" required>
      <input type="file" class="form-control" name="bukti" required>
    </div>

    <!-- Navigasi -->
    <div class="navigation-buttons mt-3">
      <button type="button" class="btn btn-secondary w-50" onclick="changeStep(-1)">Back</button>
      <button type="button" class="btn btn-primary w-50" onclick="changeStep(1)">Next</button>
    </div>

    <!-- Submit -->
    <div class="text-end mt-4 d-none" id="submitSection">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i> Submit
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

  function showStep(index) {
    steps.forEach((step, i) => {
      step.classList.toggle('d-none', i !== index);
    });
    backBtn.disabled = index === 0;
    nextBtn.classList.toggle('d-none', index === steps.length - 1);
    submitSection.classList.toggle('d-none', index !== steps.length - 1);
  }

  function changeStep(direction) {
    if (direction === 1 && !validateStep()) return;
    currentStep += direction;
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
</script>

</body>
</html>
