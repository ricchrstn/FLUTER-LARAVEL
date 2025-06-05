@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Simpanan</h1>
        <div>
            <a href="{{ route('simpanan.edit', $simpanan->id) }}" class="btn btn-warning">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Simpanan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Simpanan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Anggota</th>
                                    <td>{{ $simpanan->anggota->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>{{ $simpanan->anggota->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Simpanan</th>
                                    <td>
                                        @if($simpanan->jenis_simpanan == 'pokok')
                                            <span class="badge badge-primary">Simpanan Pokok</span>
                                        @elseif($simpanan->jenis_simpanan == 'wajib')
                                            <span class="badge badge-info">Simpanan Wajib</span>
                                        @else
                                            <span class="badge badge-success">Simpanan Sukarela</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Tanggal</th>
                                    <td>{{ $simpanan->tanggal->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($simpanan->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($simpanan->status == 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $simpanan->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $simpanan->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui</th>
                                    <td>{{ $simpanan->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Bukti Transfer -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bukti Transfer</h6>
                </div>
                <div class="card-body text-center">
                    @if($simpanan->bukti_transfer)
                        <img src="{{ Storage::url($simpanan->bukti_transfer) }}" 
                             alt="Bukti Transfer" 
                             class="img-fluid mb-3">
                        <a href="{{ Storage::url($simpanan->bukti_transfer) }}" 
                           class="btn btn-primary btn-sm" 
                           target="_blank">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> Tidak ada bukti transfer
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aksi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    @if($simpanan->status == 'pending')
                        <form action="{{ route('simpanan.approve', $simpanan->id) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-success btn-block mb-2"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui simpanan ini?')">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('simpanan.reject', $simpanan->id) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-danger btn-block"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak simpanan ini?')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 