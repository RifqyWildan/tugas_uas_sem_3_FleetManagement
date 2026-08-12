@extends('layouts.admin')

@section('title', 'Edit Tarif')
@section('page-title', 'Edit Data Tarif')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Tarif</h3>
    </div>
    <form action="{{ route('admin.tarif.update', $tarif) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                       id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $tarif->nama_layanan) }}" 
                       placeholder="Contoh: Ekspedisi Reguler">
                @error('nama_layanan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tarif_per_km">Tarif per Km (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('tarif_per_km') is-invalid @enderror" 
                           id="tarif_per_km" name="tarif_per_km" value="{{ old('tarif_per_km', $tarif->tarif_per_km) }}" min="0">
                    @error('tarif_per_km')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="minimal_tarif">Minimal Tarif (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('minimal_tarif') is-invalid @enderror" 
                           id="minimal_tarif" name="minimal_tarif" value="{{ old('minimal_tarif', $tarif->minimal_tarif) }}" min="0">
                    @error('minimal_tarif')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $tarif->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.tarif.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection