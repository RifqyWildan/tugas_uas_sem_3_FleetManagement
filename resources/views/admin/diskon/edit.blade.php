@extends('layouts.admin')

@section('title', 'Edit Diskon')
@section('page-title', 'Edit Diskon')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Diskon</h3>
    </div>
    <form action="{{ route('admin.diskon.update', $diskon) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_diskon">Nama Diskon <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_diskon') is-invalid @enderror" 
                       id="nama_diskon" name="nama_diskon" value="{{ old('nama_diskon', $diskon->nama_diskon) }}" 
                       placeholder="Contoh: Diskon Pelanggan Setia, Diskon Flash Sale, dll">
                @error('nama_diskon')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipe_diskon">Tipe Diskon <span class="text-danger">*</span></label>
                    <select id="tipe_diskon" name="tipe_diskon" class="form-control @error('tipe_diskon') is-invalid @enderror" onchange="updateDiskonFields()">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="persen" {{ old('tipe_diskon', $diskon->tipe_diskon) == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                        <option value="nominal" {{ old('tipe_diskon', $diskon->tipe_diskon) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                        <option value="otomatis" {{ old('tipe_diskon', $diskon->tipe_diskon) == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                    </select>
                    @error('tipe_diskon')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6" id="diskon-persen-group">
                    <label for="diskon_persen">Nilai Diskon (%) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('diskon_persen') is-invalid @enderror" 
                           id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', $diskon->diskon_persen) }}" 
                           placeholder="Contoh: 10" min="0" max="100">
                    @error('diskon_persen')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6" id="diskon-nominal-group" style="display: none;">
                    <label for="diskon_nominal">Nilai Diskon (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('diskon_nominal') is-invalid @enderror" 
                           id="diskon_nominal" name="diskon_nominal" value="{{ old('diskon_nominal', $diskon->diskon_nominal) }}" 
                           placeholder="Contoh: 50000" min="0">
                    @error('diskon_nominal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                           id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $diskon->tanggal_mulai) }}">
                    @error('tanggal_mulai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                           id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $diskon->tanggal_selesai) }}">
                    @error('tanggal_selesai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3" 
                          placeholder="Penjelasan diskon ini...">{{ old('keterangan', $diskon->keterangan) }}</textarea>
                @error('keterangan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="aktif" {{ old('status', $diskon->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $diskon->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
            <a href="{{ route('admin.diskon.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
function updateDiskonFields() {
    const tipeDiskon = document.getElementById('tipe_diskon').value;
    const persenGroup = document.getElementById('diskon-persen-group');
    const nominalGroup = document.getElementById('diskon-nominal-group');

    if (tipeDiskon === 'nominal') {
        persenGroup.style.display = 'none';
        nominalGroup.style.display = 'block';
    } else if (tipeDiskon === 'persen' || tipeDiskon === 'otomatis') {
        persenGroup.style.display = 'block';
        nominalGroup.style.display = 'none';
    } else {
        persenGroup.style.display = 'block';
        nominalGroup.style.display = 'none';
    }
}

// Jalankan saat page load
document.addEventListener('DOMContentLoaded', updateDiskonFields);
</script>
@endsection
