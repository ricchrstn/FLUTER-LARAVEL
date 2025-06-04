<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Koperasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --koperasi-green: #388e3c;
            --koperasi-light-green: #4caf50;
        }
        .sidebar {
            background: var(--koperasi-green);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            background: white;
            color: var(--koperasi-green);
        }
        .sidebar .nav-link i {
            width: 1.5rem;
        }
        .card-stats {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card-stats:hover {
            transform: translateY(-5px);
        }
        .card-stats .icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .bg-primary-light {
            background: rgba(56, 142, 60, 0.1);
            color: var(--koperasi-green);
        }
        .bg-success-light {
            background: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
        }
        .bg-warning-light {
            background: rgba(255, 152, 0, 0.1);
            color: #f57c00;
        }
        .bg-info-light {
            background: rgba(3, 169, 244, 0.1);
            color: #0288d1;
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
                        <h5 class="mb-0">Admin Panel</h5>
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
                            <a href="{{ route('feedback.index') }}" class="nav-link">
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
                                        <h3 class="mb-0">{{ $totalAnggota ?? 0 }}</h3>
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
                                        <h6 class="text-muted mb-1">Feedback Baru</h6>
                                        <h3 class="mb-0">{{ $feedbackBaru ?? 0 }}</h3>
                                    </div>
                                    <div class="icon bg-info-light">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">Transaksi Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Anggota</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksiTerbaru ?? [] as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $transaksi->anggota->name }}</td>
                                        <td>{{ $transaksi->jenis }}</td>
                                        <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaksi->status == 'selesai' ? 'success' : 'warning' }}">
                                                {{ ucfirst($transaksi->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada transaksi terbaru</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Feedback -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">Feedback Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Anggota</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbackTerbaru ?? [] as $feedback)
                                    <tr>
                                        <td>{{ $feedback->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $feedback->user->name }}</td>
                                        <td>{{ Str::limit($feedback->pesan, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $feedback->status == 'dibaca' ? 'success' : 'warning' }}">
                                                {{ ucfirst($feedback->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada feedback terbaru</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 