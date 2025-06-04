<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Koperasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --koperasi-green: #388e3c;
            --koperasi-light-green: #4caf50;
        }
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .sidebar {
            background: var(--koperasi-green);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.2);
        }
        .sidebar .nav-link i {
            width: 1.5rem;
        }
        .main-content {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,.1);
            padding: 1.5rem;
        }
        .btn-koperasi {
            background-color: var(--koperasi-green);
            border-color: var(--koperasi-green);
            color: white;
        }
        .btn-koperasi:hover {
            background-color: var(--koperasi-light-green);
            border-color: var(--koperasi-light-green);
            color: white;
        }
        .text-koperasi {
            color: var(--koperasi-green);
        }
        .about-header {
            background: var(--koperasi-green);
            color: white;
            padding: 3rem 2rem;
            border-radius: 1rem 1rem 0 0;
            text-align: center;
        }
        .about-logo {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            padding: 1rem;
        }
        .about-logo img {
            max-width: 100%;
            height: auto;
        }
        .feature-card {
            text-align: center;
            padding: 2rem;
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--koperasi-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/koperasi-logo.png') }}" alt="Koperasi Logo" class="img-fluid mb-3" style="max-width: 150px;">
                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                        <small class="text-white-50">{{ auth()->user()->nim }}</small>
                    </div>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link">
                                <i class="fas fa-user"></i> Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link active">
                                <i class="fas fa-info-circle"></i> Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="card">
                    <div class="about-header">
                        <div class="about-logo">
                            <img src="{{ asset('images/koperasi-logo.png') }}" alt="Koperasi Logo">
                        </div>
                        <h2 class="mb-3">Koperasi Mahasiswa</h2>
                        <p class="lead mb-0">Melayani dengan Sepenuh Hati</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h3 class="text-koperasi mb-4">Visi</h3>
                                <p class="lead">
                                    Menjadi koperasi mahasiswa terdepan yang mengutamakan kesejahteraan anggota dan berkontribusi positif terhadap pengembangan ekonomi kampus.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-koperasi mb-4">Misi</h3>
                                <ul class="lead">
                                    <li>Menyediakan layanan keuangan yang terjangkau</li>
                                    <li>Mengembangkan program simpanan dan pinjaman yang menguntungkan</li>
                                    <li>Mendukung kegiatan akademik dan non-akademik mahasiswa</li>
                                    <li>Menerapkan prinsip transparansi dan akuntabilitas</li>
                                </ul>
                            </div>
                        </div>

                        <h3 class="text-koperasi text-center mb-4">Layanan Kami</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-piggy-bank"></i>
                                    </div>
                                    <h4>Simpanan</h4>
                                    <p class="text-muted">
                                        Program simpanan dengan bunga kompetitif dan berbagai pilihan jangka waktu.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <h4>Pinjaman</h4>
                                    <p class="text-muted">
                                        Pinjaman dengan bunga rendah dan proses yang cepat untuk kebutuhan pendidikan.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h4>Investasi</h4>
                                    <p class="text-muted">
                                        Peluang investasi yang aman dan menguntungkan untuk masa depan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-koperasi mb-4">Kontak</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="fas fa-map-marker-alt text-koperasi me-2"></i>
                                        Jl. Kampus No. 1, Kota
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-phone text-koperasi me-2"></i>
                                        (021) 1234-5678
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-envelope text-koperasi me-2"></i>
                                        info@koperasi-mahasiswa.ac.id
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-koperasi mb-4">Jam Operasional</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="fas fa-clock text-koperasi me-2"></i>
                                        Senin - Jumat: 08:00 - 16:00
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-clock text-koperasi me-2"></i>
                                        Sabtu: 08:00 - 12:00
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-clock text-koperasi me-2"></i>
                                        Minggu: Tutup
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 