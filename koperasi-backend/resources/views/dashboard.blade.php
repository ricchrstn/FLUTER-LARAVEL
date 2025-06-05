<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Koperasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        body {
            background-color: #f8f9fc;
        }
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
            min-height: 100vh;
            color: white;
        }
        .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            border-radius: 0.35rem;
            margin: 0.2rem 0;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .card-stats {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bg-primary-light {
            background: rgba(78, 115, 223, 0.1);
            color: #4e73df;
        }
        .bg-success-light {
            background: rgba(28, 200, 138, 0.1);
            color: #1cc88a;
        }
        .bg-warning-light {
            background: rgba(246, 194, 62, 0.1);
            color: #f6c23e;
        }
        .bg-info-light {
            background: rgba(54, 185, 204, 0.1);
            color: #36b9cc;
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
                    <hr class="text-white">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link active">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('anggota.index') }}" class="nav-link">
                                <i class="fas fa-users"></i> Anggota
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}" class="nav-link">
                                <i class="fas fa-exchange-alt"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link">
                                <i class="fas fa-chart-bar"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('feedback.my') }}" class="nav-link">
                                <i class="fas fa-comments"></i> Feedback
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Dashboard</h2>
                    <div class="text-muted">
                        <i class="fas fa-calendar"></i> {{ now()->format('d F Y') }}
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Anggota</h6>
                                        <h3 class="mb-0">{{ $jumlahAnggota ?? 0 }}</h3>
                                    </div>
                                    <div class="icon bg-primary-light">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Simpanan</h6>
                                        <h3 class="mb-0">Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="icon bg-success-light">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Pinjaman</h6>
                                        <h3 class="mb-0">Rp {{ number_format($totalPinjaman ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="icon bg-warning-light">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Transaksi</h6>
                                        <h3 class="mb-0">{{ $jumlahTransaksi ?? 0 }}</h3>
                                    </div>
                                    <div class="icon bg-info-light">
                                        <i class="fas fa-exchange-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="{{ route('anggota.index') }}" class="card card-stats text-decoration-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="icon bg-primary-light me-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Manajemen Anggota</h6>
                                        <p class="mb-0 text-dark">Kelola data anggota koperasi</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('transaksi.index') }}" class="card card-stats text-decoration-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="icon bg-success-light me-3">
                                        <i class="fas fa-exchange-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Manajemen Transaksi</h6>
                                        <p class="mb-0 text-dark">Kelola transaksi simpanan & pinjaman</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('laporan.index') }}" class="card card-stats text-decoration-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="icon bg-warning-light me-3">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Laporan</h6>
                                        <p class="mb-0 text-dark">Lihat laporan keuangan koperasi</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
