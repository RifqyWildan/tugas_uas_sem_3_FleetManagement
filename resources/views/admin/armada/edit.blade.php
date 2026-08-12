@extends('layouts.admin')

@section('title', 'Edit Armada')

@section('page-title', 'Edit Data Armada')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Armada</h3>
    </div>
    <form action="{{ route('admin.armada.update', $armada) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nomor_polisi">Nomor Polisi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_polisi') is-invalid @enderror" 
                       id="nomor_polisi" name="nomor_polisi" 
                       value="{{ old('nomor_polisi', $armada->nomor_polisi) }}" 
                       placeholder="Contoh: D 1234 AB">
                @error('nomor_polisi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jenis_kendaraan') is-invalid @enderror" 
                           id="jenis_kendaraan" name="jenis_kendaraan" 
                           value="{{ old('jenis_kendaraan', $armada->jenis_kendaraan) }}" 
                           placeholder="Contoh: Bus, Truk">
                    @error('jenis_kendaraan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="merk">Merk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                           id="merk" name="merk" value="{{ old('merk', $armada->merk) }}" placeholder="Contoh: Hino">
                    @error('merk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="kapasitas_muatan">Kapasitas Muatan <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('kapasitas_muatan') is-invalid @enderror" 
                           id="kapasitas_muatan" name="kapasitas_muatan" value="{{ old('kapasitas_muatan', $armada->kapasitas_muatan) }}">
                    @error('kapasitas_muatan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="tahun_pembuatan">Tahun Pembuatan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tahun_pembuatan') is-invalid @enderror" 
                           id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', $armada->tahun_pembuatan) }}" min="1900" max="{{ date('Y') + 1 }}">
                    @error('tahun_pembuatan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="aktif" {{ old('status', $armada->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $armada->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="maintenance" {{ old('status', $armada->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto Armada</label>
                
                <div class="mb-2">
                    <label>Foto Saat Ini:</label><br>
                    <img src="{{ $armada->foto_url }}" alt="Foto" class="img-thumbnail" width="200">
                </div>
                
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                    <label class="custom-file-label" for="foto">Pilih file gambar baru...</label>
                    @error('foto')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                
                <!-- Preview Foto Baru -->
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <label>Preview Foto Baru:</label><br>
                    <img id="preview" src="" alt="Preview" class="img-thumbnail" width="200">
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $armada->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.armada.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const label = document.querySelector('.custom-file-label');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
        label.textContent = input.files[0].name;
    }
}
</script>
@endsection
