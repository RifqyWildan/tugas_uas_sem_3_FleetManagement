@extends('layouts.admin')

@section('title', 'Tambah Gudang')
@section('page-title', 'Tambah Gudang Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Gudang</h3>
    </div>
    <form action="{{ route('admin.gudang.store') }}" method="POST">
        @csrf
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_gudang">Nama Gudang <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_gudang') is-invalid @enderror" 
                       id="nama_gudang" name="nama_gudang" value="{{ old('nama_gudang') }}" 
                       placeholder="Contoh: Gudang Pusat Bandung">
                @error('nama_gudang')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="4" 
                          placeholder="Alamat lengkap gudang...">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="kapasitas">Kapasitas (Unit) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" 
                           id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" 
                           placeholder="Contoh: 1000" min="0" step="0.01">
                    @error('kapasitas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tarif_per_kg">Tarif Per Kg (Rp) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tarif_per_kg') is-invalid @enderror" 
                           id="tarif_per_kg" name="tarif_per_kg" value="{{ old('tarif_per_kg') }}" 
                           placeholder="Contoh: 10000" min="0" step="0.01">
                    @error('tarif_per_kg')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="penuh" {{ old('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="over_capacity" {{ old('status') == 'over_capacity' ? 'selected' : '' }}>Over Capacity</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="diskon_persen">Diskon (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('diskon_persen') is-invalid @enderror" 
                           id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', 0) }}" 
                           placeholder="Contoh: 10" min="0" max="100" step="0.01">
                    @error('diskon_persen')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Stok awal akan dimulai dari 0. Gunakan tombol <strong>View</strong> pada daftar gudang untuk menambah atau mengurangi stok.
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.gudang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection