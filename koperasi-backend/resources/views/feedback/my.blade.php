@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Kirim Feedback / Saran</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan / Saran</label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" id="pesan" name="pesan" rows="3" required>{{ old('pesan') }}</textarea>
                            @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Riwayat Feedback Saya</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Pesan</th>
                                    <th>Status</th>
                                    <th>Balasan Admin</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $f)
                                <tr>
                                    <td>{{ $f->pesan }}</td>
                                    <td>
                                        @if($f->status == 'baru')
                                            <span class="badge bg-warning text-dark">Belum Dibalas</span>
                                        @else
                                            <span class="badge bg-success">Dibalas</span>
                                        @endif
                                    </td>
                                    <td>{{ $f->balasan ?? '-' }}</td>
                                    <td>{{ $f->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada feedback.</td>
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