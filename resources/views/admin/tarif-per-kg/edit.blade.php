@extends('layouts.admin')

@section('title', 'Edit Tarif Per Kg')
@section('page-title', 'Edit Tarif Per Kg')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Tarif Per Kg</h3>
    </div>
    <form action="{{ route('admin.tarif-per-kg.update', $tarifPerKg) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_tarif">Nama Tarif <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_tarif') is-invalid @enderror" 
                       id="nama_tarif" name="nama_tarif" value="{{ old('nama_tarif', $tarifPerKg->nama_tarif) }}" 
                       placeholder="Contoh: Tarif Standard, Tarif Express, dll">
                @error('nama_tarif')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="harga_per_kg">Harga Per Kg (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                           id="harga_per_kg" name="harga_per_kg" value="{{ old('harga_per_kg', $tarifPerKg->harga_per_kg) }}" 
                           placeholder="Contoh: 10000" min="0">
                    @error('harga_per_kg')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tipe_barang">Tipe Barang</label>
                    <input type="text" class="form-control @error('tipe_barang') is-invalid @enderror" 
                           id="tipe_barang" name="tipe_barang" value="{{ old('tipe_barang', $tarifPerKg->tipe_barang) }}" 
                           placeholder="Contoh: Elektronik, Fragile, Makanan, dll">
                    @error('tipe_barang')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="3" 
                          placeholder="Penjelasan tarif ini...">{{ old('deskripsi', $tarifPerKg->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="aktif" {{ old('status', $tarifPerKg->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $tarifPerKg->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.tarif-per-kg.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
