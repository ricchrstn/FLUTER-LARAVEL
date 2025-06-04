@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Anggota</h5>
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota as $a)
                                <tr>
                                    <td>{{ $a->user->nim }}</td>
                                    <td>{{ $a->user->name }}</td>
                                    <td>{{ $a->user->email }}</td>
                                    <td>{{ $a->user->phone }}</td>
                                    <td>{{ $a->tanggal_daftar->format('d/m/Y') }}</td>
                                    <td>{{ $a->status_anggota }}</td>
                                    <td>{{ $a->alamat }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('anggota.edit', $a->id) }}" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('anggota.destroy', $a->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 