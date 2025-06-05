@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Simpanan</h1>
        <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Simpanan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('simpanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="anggota_id">Anggota <span class="text-danger">*</span></label>
                            <select name="anggota_id" id="anggota_id" class="form-control @error('anggota_id') is-invalid @enderror" required>
                                <option value="">Pilih Anggota</option>
                                @foreach($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('anggota_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} - {{ $item->nim }}
                                    </option>
                                @endforeach
                            </select>
                            @error('anggota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_simpanan">Jenis Simpanan <span class="text-danger">*</span></label>
                            <select name="jenis_simpanan" id="jenis_simpanan" class="form-control @error('jenis_simpanan') is-invalid @enderror" required>
                                <option value="">Pilih Jenis</option>
                                <option value="pokok" {{ old('jenis_simpanan') == 'pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
                                <option value="wajib" {{ old('jenis_simpanan') == 'wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
                                <option value="sukarela" {{ old('jenis_simpanan') == 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                            </select>
                            @error('jenis_simpanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" 
                                       class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" 
                                       name="jumlah" 
                                       value="{{ old('jumlah') }}" 
                                       required>
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bukti_transfer">Bukti Transfer</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('bukti_transfer') is-invalid @enderror" 
                                       id="bukti_transfer" 
                                       name="bukti_transfer">
                                <label class="custom-file-label" for="bukti_transfer">Pilih file</label>
                            </div>
                            <small class="form-text text-muted">
                                Format: JPG, JPEG, PNG. Maksimal 2MB
                            </small>
                            @error('bukti_transfer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview nama file yang dipilih
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Format input jumlah dengan pemisah ribuan
    $('#jumlah').on('keyup', function() {
        let val = $(this).val();
        val = val.replace(/[^\d]/g, '');
        $(this).val(val);
    });
</script>
@endpush 