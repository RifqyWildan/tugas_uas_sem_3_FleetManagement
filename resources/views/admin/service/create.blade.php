@extends('layouts.admin')

@section('title', 'Tambah Jadwal Service')
@section('page-title', 'Tambah Jadwal Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Jadwal Service</h3>
    </div>
    <form action="{{ route('admin.service.store') }}" method="POST">
        @csrf
        <div class="card-body">
            
            <div class="form-group">
                <label for="id_armada">Pilih Armada <span class="text-danger">*</span></label>
                <select id="id_armada" name="id_armada" class="form-control @error('id_armada') is-invalid @enderror">
                    <option value="">Pilih Armada</option>
                    @foreach($armadas as $armada)
                        <option value="{{ $armada->id_armada }}" {{ old('id_armada') == $armada->id_armada ? 'selected' : '' }}>{{ $armada->merk }} ({{ $armada->nomor_polisi }})</option>
                    @endforeach
                </select>
                @error('id_armada')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_service">Tanggal Service <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_service') is-invalid @enderror" id="tanggal_service" name="tanggal_service" value="{{ old('tanggal_service') }}">
                    @error('tanggal_service')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="jenis_service">Jenis Service <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jenis_service') is-invalid @enderror" id="jenis_service" name="jenis_service" value="{{ old('jenis_service') }}" placeholder="Contoh: Ganti Oli">
                    @error('jenis_service')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="biaya">Biaya (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('biaya') is-invalid @enderror" id="biaya" name="biaya" value="{{ old('biaya') }}">
                    @error('biaya')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="catatan">Catatan</label>
                    <input type="text" class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" value="{{ old('catatan') }}" placeholder="Catatan (opsional)">
                    @error('catatan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi service (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.service.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection