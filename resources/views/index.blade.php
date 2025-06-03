@extends('layouts.main')
@section('title', 'Home | Koka Laundry')
@section('content')
<!-- Topbar Start -->
    <div class="container-fluid bg-primary py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                    <!-- <div class="d-inline-flex align-items-center">
                        <a class="text-white pr-3" href="">FAQs</a>
                        <span class="text-white">|</span>
                        <a class="text-white px-3" href="">Help</a>
                        <span class="text-white">|</span>
                        <a class="text-white pl-3" href="">Support</a>
                    </div> -->
                </div>
                <div class="col-md-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-white px-3" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-white px-3" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-white px-3" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-white px-3" href="https://www.instagram.com/kokalaundryjbi_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-white pl-3" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 pl-3 pl-lg-5 rounded-navbar">
                <a href="" class="navbar-brand">
                    <h1 class="m-0 text-secondary"><span class="text-primary">KO</span>KA</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="/" class="nav-item nav-link">Halaman Utama</a>
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu border-0 rounded-0 m-0">
                                <a href="blog.html" class="dropdown-item">Blog Grid</a>
                                <a href="single.html" class="dropdown-item">Blog Detail</a>
                            </div>
                        </div> -->
                        <a href="#contact" class="nav-item nav-link">Kontak</a>
                        <a href="{{ route('user.form_pemesanan') }}" class="nav-item nav-link">Pesan</a>
                        <a href="{{ route('check-status') }}" class="nav-item nav-link">Cek Pesanan</a>
                        <x-nav-link>
                            <a href="{{ route('login') }}" class="nav-item nav-link active">Admin</a>
                        </x-nav-link>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Laundry & Setrika</h4>
                            <h1 class="display-3 text-white mb-md-4">Siap Cepat 1 Hari Selesai</h1>
                           
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Laundry & Setrika</h4>
                            <h1 class="display-3 text-white mb-md-4">Gratis Antar Jemput</h1>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Contact Info Start -->
    <div class="container-fluid contact-info mt-5 mb-4">
        <div class="container " style="padding: 0 30px;">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0" style="height: 100px; border-radius: 15px;">
                    <div class="d-inline-flex">
                        <i class="fa fa-2x fa-map-marker-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Lokasi Kami (Pusat)</h5>
                            <p class="m-0 text-white">JL. Serma Ishak Ahmad, Mayang Mangurai, Jambi City 36126</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-primary mb-4 mb-lg-0" style="height: 100px; border-radius: 15px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-envelope text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Instagram Kami</h5>
                            <p class="m-0 text-white">@kokalaundryjbi_</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0" style="height: 100px; border-radius: 15px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-phone-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Telepon Kami</h5>
                            <p class="m-0 text-white">+62 811-7443-553</p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Info End -->


    <!-- About Start -->
    <div class="container-fluid py-5" id="about">
        <div class="container pt-0 pt-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid" src="img/about.jpg" alt="" style="border-radius: 15px;">
                </div>
                <div class="col-lg-7 mt-5 mt-lg-0 pl-lg-5">
                    <h6 class="text-secondary text-uppercase font-weight-medium mb-3">Tentang Kami</h6>
                    <h1 class="mb-4">Laundry & Setrika Kekinian Buat Kamu yang Anti Ribet</h1>
                    <h5 class="font-weight-medium font-italic mb-4">Cepat, praktis, dan tanpa ribet. Biar kamu lebih fokus buat hal seru lainnya!</h5>
                    <p class="mb-2">Bosen sama cucian yang gak kelar-kelar? Serahin aja ke kita! Layanan laundry dan setrika kita cepat, praktis, dan bikin hidup kamu makin santuy. Dengan teknologi modern dan karyawan kece, baju kamu bakal kinclong tanpa drama.</p>
                    <div class="row">
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-primary font-weight-medium m-0">🧺 Layanan Laundry & Setrika Kekinian</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-primary font-weight-medium m-0">🚚 Jemput & Antar Cepat, Gak Perlu Repot Jalan</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-primary font-weight-medium m-0">👕 Karyawan yang Jago Rawat Baju</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-primary font-weight-medium m-0">🌟 Garansi Puas atau Uang Kembali!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Services Start -->
    <div class="container-fluid pt-5 pb-3" id="services">
        <div class="container">
            <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Layanan</h6>
            <h1 class="display-4 text-center mb-5">Layanan yang Kami Sediakan</h1>
            <div class="row">
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4 service-card" style="height: 300px; border-radius: 15px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-3x fa-cloud-sun text-secondary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Cuci Komplit</h4>
                        <p class="mt-2" style="color: #6c757d; font-size: 0.95rem; line-height: 1.5; font-weight: 400;">
                            Harga : Rp 7.000 / Kg<br>
                            Termasuk cuci, kering, setrika, & lipat<br>
                            Estimasi : 1 Hari (Reguler)
                            </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4 service-card" style="height: 300px; border-radius: 15px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4" style="width: 100px; height: 100px;">
                            <i class="fas fa-3x fa-soap text-secondary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Cuci + Lipat</h4>
                        <p class="mt-2" style="color: #6c757d; font-size: 0.95rem; line-height: 1.5; font-weight: 400;">
                            Harga: Rp 5.000 / Kg<br>
                            Cocok untuk pakaian sehari-hari yang tidak perlu disetrika
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4 service-card" style="height: 300px; border-radius: 15px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-3x fa-burn text-secondary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Setrika Saja</h4>
                        <p class="mt-2" style="color: #6c757d; font-size: 0.95rem; line-height: 1.5; font-weight: 400;">
                            Harga: Rp 5.000 / Kg<br>
                            Untuk pakaian yang sudah dicuci sendiri dari rumah pelanggan
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4 service-card" style="height: 300px; border-radius: 15px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4" style="width: 100px; height: 100px;">
                            <i class="fa fa-3x fa-tshirt text-secondary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Cuci Karpet</h4>
                        <p class="mt-2" style="color: #6c757d; font-size: 0.95rem; line-height: 1.5; font-weight: 400;">
                            Harga tidak tercantum<br>
                            Dikhususkan untuk karpet rumah/toko<br>
                            Bisa ditanyakan via kontak
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 m-0 my-lg-5 pt-0 pt-lg-5 pr-lg-5">
                    <h6 class="text-secondary text-uppercase font-weight-medium mb-3">Fitur Kami</h6>
                    <h1 class="mb-4">Kenapa Memilih Kami</h1>
                    <p>Kami memadukan teknologi laundry terkini, cara yang ramah lingkungan, dan karywana yang profesional untuk memberikan hasil terbaik. Baik pakaian sehari-hari maupun yang paling halus, kami merawatnya dengan sepenuh hati, jadi Anda bisa tenang tanpa khawatir.</p>
                    <div class="row">
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">6</h1>
                            <h5 class="font-weight-bold">Tahun Pengalaman</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">18</h1>
                            <h5 class="font-weight-bold">Karyawan</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">9550</h1>
                            <h5 class="font-weight-bold">Pelanggan Puas</h5>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h1 class="text-secondary" data-toggle="counter-up">9550</h1>
                            <h5 class="font-weight-bold">Laundry</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex flex-column align-items-center justify-content-center bg-secondary h-100 py-5 px-3" style="border-radius: 15px;">
                        <i class="fa fa-5x fa-certificate text-white mb-5"></i>
                        <h1 class="display-1 text-white mb-3">6</h1>
                        <h1 class="text-white m-0">Tahun Pengalaman</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Location Start -->        
    <div class="container-fluid py-5">
        <div class="container">
            <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Cabang Kami</h6>
            <h1 class="display-4 text-center mb-5">Temukan Koka Laundry di Lokasi Berikut</h1>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item" onclick="window.open('https://maps.app.goo.gl/d8UBc4fRkwkJYy148', '_blank')" style="cursor:pointer;">
                    <img class="position-relative bg-white shadow mx-auto" src="{{ asset('img/cb1.jpg') }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 0 0 15px 15px;">
                        <h5 class="font-weight-medium mt-2">Cabang 1 (Pusat)</h5>
                        <p class="m-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            Jl. Serma Ishak Ahmad, Mayang Mangurai, Kec. Kota Baru, Kota Jambi, Jambi 36361
                        </p>
                    </div>
                </div>

                <div class="testimonial-item" onclick="window.open('https://maps.app.goo.gl/8D5JCzdAW2hbXZcm6', '_blank')" style="cursor:pointer;">
                    <img class="position-relative bg-white shadow mx-auto" src="img/cb2.jpg" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 0 0 15px 15px;">
                        <h5 class="font-weight-medium mt-2">Cabang 2</h5>
                        <p class="m-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            Jl. Kapten A Hasan, Pematang Sulur, Arah Ke Pemancar TVRI Depan TK AL-Aqsha, Kec. Telanaipura, Kota Jambi, Jambi 36361</p>
                        </p>
                    </div>
                </div>

                <div class="testimonial-item" onclick="window.open('https://maps.app.goo.gl/CJAVUmAuSj9qnakE8', '_blank')" style="cursor:pointer;">
                    <img class="position-relative bg-white shadow mx-auto" src="img/cb3.jpg" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 0 0 15px 15px;">
                        <h5 class="font-weight-medium mt-2">Cabang 3</h5>
                        <p class="m-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            Jl. Letmud Sarniem, Kenali Asam Bawah, Kec. Kota Baru, Kota Jambi, Jambi 36129</p>
                        </p>
                    </div>
                </div>

                <div class="testimonial-item" onclick="window.open('https://maps.app.goo.gl/8v4GsPuA6jd5eyr96', '_blank')" style="cursor:pointer;">
                    <img class="position-relative bg-white shadow mx-auto" src="img/cb4.jpg" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 0 0 15px 15px;">
                        <h5 class="font-weight-medium mt-2">Cabang 4</h5>
                        <p class="m-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            Jl. Sari Bakti, Bagan Pete, Kec. Kota Baru, Kota Jambi, Jambi 36361</p>
                        </p>
                    </div>
                </div>

                <div class="testimonial-item" onclick="window.open('https://maps.app.goo.gl/8D5JCzdAW2hbXZcm6', '_blank')" style="cursor:pointer;">
                    <img class="position-relative bg-white shadow mx-auto" src="img/cb1.jpg" style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 0 0 15px 15px;">
                        <h5 class="font-weight-medium mt-2">Cabang 5</h5>
                        <p class="m-0">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            Simpang Rimbo</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location End -->


    <!-- Working Process Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Proses Pelayanan</h6>
            <h1 class="display-4 text-center mb-5">Tahapan Layanan</h1>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="process-step d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="process-circle d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4" style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">1</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Pesan Layanan</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="process-circle d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4" style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">2</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Penjemputan Gratis</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="process-circle d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4" style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">3</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Proses Laundry</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step d-flex flex-column align-items-center justify-content-center text-center mb-5">
                        <div class="process-circle d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4" style="width: 150px; height: 150px; border-width: 15px !important;">
                            <h2 class="display-2 text-secondary m-0">4</h2>
                        </div>
                        <h3 class="font-weight-bold m-0 mt-2">Pengantaran Gratis</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Working Process End -->


    <!-- Pricing Plan Start -->
    <div class="container-fluid pt-5 pb-3" id="prices">
    <div class="container">
        <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Paket Harga Kami</h6>
        <h1 class="display-4 text-center mb-5">Penawaran Terbaik</h1>
        <div class="row justify-content-center">

            <!-- Koka Reguler -->
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="bg-light text-center mb-2 pt-4" style="border-radius: 15px;">
                    <div class="price-circle d-inline-flex flex-column align-items-center justify-content-center bg-secondary rounded-circle shadow mt-2 mb-4"
                        style="width: 310px; height: 310px; border: 15px solid #ffffff;">
                        <h3 class="text-white">Koka Reguler</h3>
                        <h1 class="display-4 text-white mb-0">
                            <small class="align-top" style="font-size: 22px; line-height: 45px;">Rp</small>
                            7.000
                            <small class="align-bottom" style="font-size: 16px; line-height: 40px;">/Kg</small>
                        </h1>
                    </div>
                    <div class="d-flex flex-column align-items-center py-3">
                        <p>Estimasi selesai: 1 hari</p>
                        <p>Cuci Standar</p>
                        <p>Bisa Hubungi Via Chat</p>
                    </div>
                    <a href="{{ route('user.form_pemesanan') }}" class="btn btn-secondary py-2 px-4 mb-4" style="border-radius: 15px;">Cuci Sekarang</a>
                </div>
            </div>

            <!-- Koka Express -->
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="bg-light text-center mb-2 pt-4" style="border-radius: 15px;">
                    <div class="price-circle d-inline-flex flex-column align-items-center justify-content-center bg-primary rounded-circle shadow mt-2 mb-4"
                        style="width: 310px; height: 310px; border: 15px solid #ffffff;">
                        <h3 class="text-white">Koka Express</h3>
                        <h1 class="display-4 text-white mb-0">
                            <small class="align-top" style="font-size: 22px; line-height: 45px;">Rp</small>
                            10.000
                            <small class="align-bottom" style="font-size: 16px; line-height: 40px;">/Kg</small>
                        </h1>
                    </div>
                    <div class="d-flex flex-column align-items-center py-3">
                        <p>Estimasi selesai: 3 jam</p>
                        <p>Cuci Premium</p>
                        <p>Bisa Hubungi Via Chat</p>
                    </div>
                    <a href="{{ route('user.form_pemesanan') }}" class="btn btn-primary py-2 px-4 mb-4" style="border-radius: 15px;">Cuci Sekarang</a>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Pricing Plan End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Testimoni</h6>
            <h1 class="display-4 text-center mb-5">Ulasan Pelanggan</h1>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/testimonial-1.jpg" style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 15px;">
                        <h5 class="font-weight-medium mt-5">Andi Prasetyo</h5>
                        <p class="text-muted font-italic">Pelanggan Setia</p>
                        <p class="m-0">"Pelayanan Koka Laundry sangat memuaskan! Pakaian saya selalu bersih dan rapi, plus pengantaran tepat waktu."</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/testimonial-2.jpg" style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 15px;">
                        <h5 class="font-weight-medium mt-5">Syahla Khairun</h5>
                        <p class="text-muted font-italic">Mahasiswa</p>
                        <p class="m-0">"Gak nyangka laundry bisa secepat ini. Baju wangi, bersih, dan nggak kusut. Recommended banget deh!"</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/testimonial-3.jpg" style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 15px;">
                        <h5 class="font-weight-medium mt-5">Budi Santoso</h5>
                        <p class="text-muted font-italic">Desainer Produk</p>
                        <p class="m-0">"Koka Laundry selalu jadi andalan kalau buru-buru. Pelayanan ramah dan hasil cucian selalu oke!"</p>
                    </div>
                </div>
                <div class="testimonial-item">
                    <img class="position-relative rounded-circle bg-white shadow mx-auto" src="img/testimonial-4.jpg" style="width: 100px; height: 100px; padding: 12px; margin-bottom: -50px; z-index: 1;" alt="">
                    <div class="bg-light text-center p-4 pt-0" style="border-radius: 15px;">
                        <h5 class="font-weight-medium mt-5">Rina Savana</h5>
                        <p class="text-muted font-italic">Dosen</p>
                        <p class="m-0">"Cucian selalu wangi dan bersih banget, plus karywannya ramah dan cepat. Koka Laundry emang juara!"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-white mt-5 pt-5 px-sm-3 px-md-5" id="contact">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href=""><h1 class="text-secondary mb-3"><span class="text-white">KO</span>KA Laundry</h1></a>
                <p>Koka Laundry siap memberikan layanan terbaik untuk pakaian Anda. Cepat, bersih, dan ramah lingkungan dengan harga terjangkau.</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;" href="https://www.instagram.com/kokalaundryjbi_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white mb-4">Hubungi Kami</h4>
                <p>Jangan ragu untuk menghubungi kami untuk layanan laundry terbaik.</p>
                <p><i class="fa fa-map-marker-alt mr-2"></i>JL. Serma Ishak Ahmad, Mayang Mangurai, Jambi City 36126</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+62 811-7443-553</p>
                <p><i class="fa fa-envelope mr-2"></i>@kokalaundryjbi_</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white mb-4">Layanan Kami</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Cuci Komplit</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Cuci + Lipat</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Setrika Saja</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Cuci Karpet</a>
                    <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Antar & Jemput</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <div style="border-radius: 10px; overflow: hidden; width: 100%; height: 300px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3988.194341516925!2d103.57821607496626!3d-1.6348050983499876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMcKwMzgnMDUuMyJTIDEwM8KwMzQnNTAuOSJF!5e0!3m2!1sid!2sid!4v1747670482310!5m2!1sid!2sid" 
                        width="600" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 800); // 800ms durasi scroll
            }
        });
    });
    </script>

@endsection