@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-people-fill" style="font-size:2rem;"></i>
                    <h5 class="card-title mt-2">Anggota</h5>
                    <h3>{{ $jumlahAnggota }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-wallet2" style="font-size:2rem;"></i>
                    <h5 class="card-title mt-2">Total Simpanan</h5>
                    <h3>Rp {{ number_format($totalSimpanan, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-cash-coin" style="font-size:2rem;"></i>
                    <h5 class="card-title mt-2">Total Pinjaman</h5>
                    <h3>Rp {{ number_format($totalPinjaman, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-list-check" style="font-size:2rem;"></i>
                    <h5 class="card-title mt-2">Transaksi</h5>
                    <h3>{{ $jumlahTransaksi }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="bi bi-people-fill me-2"></i> Manajemen Anggota
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-success w-100 py-3">
                <i class="bi bi-wallet2 me-2"></i> Manajemen Transaksi
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="#" class="btn btn-outline-warning w-100 py-3 disabled">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan (Coming Soon)
            </a>
        </div>
    </div>
</div>
@endsection
