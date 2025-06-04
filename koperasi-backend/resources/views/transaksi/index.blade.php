@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Transaksi</h5>
                    <div>
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                        <a href="{{ route('transaksi.index', ['jenis' => request('jenis')]) }}?export=excel" class="btn btn-success ms-2">Ekspor Excel</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $jenis == 'simpanan' ? 'active' : '' }}" href="{{ route('transaksi.index', ['jenis' => 'simpanan']) }}">Simpanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $jenis == 'pinjaman' ? 'active' : '' }}" href="{{ route('transaksi.index', ['jenis' => 'pinjaman']) }}">Pinjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ !$jenis ? 'active' : '' }}" href="{{ route('transaksi.index') }}">Semua</a>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $i => $t)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $t->anggota->user->name ?? '-' }}</td>
                                    <td>{{ ucfirst($t->jenis) }}</td>
                                    <td>{{ $t->created_at->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($t->jumlah, 2, ',', '.') }}</td>
                                    <td>{{ $t->keterangan }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('transaksi.edit', $t->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data transaksi.</td>
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
@endsection 