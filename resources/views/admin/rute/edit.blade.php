@extends('layouts.admin')

@section('title', 'Edit Rute')
@section('page-title', 'Edit Data Rute')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Rute</h3>
    </div>
    <form action="{{ route('admin.rute.update', $rute) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_rute">Nama Rute <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_rute') is-invalid @enderror" id="nama_rute" name="nama_rute" value="{{ old('nama_rute', $rute->nama_rute) }}" placeholder="Contoh: Bandung - Jakarta">
                @error('nama_rute')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="asal">Kota Asal <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('asal') is-invalid @enderror" id="asal" name="asal" value="{{ old('asal', $rute->asal) }}" placeholder="Contoh: Bandung">
                    @error('asal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="tujuan">Kota Tujuan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" value="{{ old('tujuan', $rute->tujuan) }}" placeholder="Contoh: Jakarta">
                    @error('tujuan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="jarak_km">Jarak (Km) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('jarak_km') is-invalid @enderror" id="jarak_km" name="jarak_km" value="{{ old('jarak_km', $rute->jarak_km) }}" placeholder="Contoh: 150" min="0">
                    @error('jarak_km')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="estimasi_waktu">Estimasi Waktu (menit) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('estimasi_waktu') is-invalid @enderror" id="estimasi_waktu" name="estimasi_waktu" value="{{ old('estimasi_waktu', $rute->estimasi_waktu) }}" min="0">
                    @error('estimasi_waktu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="tarif">Tarif (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('tarif') is-invalid @enderror" id="tarif" name="tarif" value="{{ old('tarif', $rute->tarif) }}" min="0">
                    @error('tarif')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $rute->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.rute.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection