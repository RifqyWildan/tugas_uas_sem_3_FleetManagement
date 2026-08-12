@extends('layouts.admin')

@section('title', 'Edit Driver')
@section('page-title', 'Edit Data Driver')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Driver</h3>
    </div>
    <form action="{{ route('admin.driver.update', $driver) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama', $driver->nama) }}" placeholder="Contoh: John Doe">
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="no_ktp">No. KTP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" 
                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $driver->no_ktp) }}" placeholder="16 digit">
                    @error('no_ktp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="no_sim">No. SIM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_sim') is-invalid @enderror" 
                           id="no_sim" name="no_sim" value="{{ old('no_sim', $driver->no_sim) }}" placeholder="Contoh: SIM12345">
                    @error('no_sim')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="tipe_sim">Tipe SIM <span class="text-danger">*</span></label>
                    <select id="tipe_sim" name="tipe_sim" class="form-control @error('tipe_sim') is-invalid @enderror">
                        <option value="">Pilih Tipe</option>
                        <option value="A" {{ old('tipe_sim', $driver->tipe_sim) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B1" {{ old('tipe_sim', $driver->tipe_sim) == 'B1' ? 'selected' : '' }}>B1</option>
                        <option value="B2" {{ old('tipe_sim', $driver->tipe_sim) == 'B2' ? 'selected' : '' }}>B2</option>
                        <option value="C" {{ old('tipe_sim', $driver->tipe_sim) == 'C' ? 'selected' : '' }}>C</option>
                    </select>
                    @error('tipe_sim')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" name="telepon" value="{{ old('telepon', $driver->telepon) }}" placeholder="Contoh: 08123456789">
                    @error('telepon')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $driver->alamat) }}</textarea>
                @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_gabung">Tanggal Bergabung <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_gabung') is-invalid @enderror" id="tanggal_gabung" name="tanggal_gabung" value="{{ old('tanggal_gabung', optional($driver->tanggal_gabung)->format('Y-m-d')) }}">
                    @error('tanggal_gabung')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="status_aktif">Status <span class="text-danger">*</span></label>
                    <select id="status_aktif" name="status_aktif" class="form-control @error('status_aktif') is-invalid @enderror">
                        <option value="aktif" {{ old('status_aktif', $driver->status_aktif) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status_aktif', $driver->status_aktif) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="cuti" {{ old('status_aktif', $driver->status_aktif) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                    </select>
                    @error('status_aktif')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto Profil</label>
                
<div class="mb-2">
                    <label>Foto Saat Ini:</label><br>
                    <img src="{{ $driver->foto_url }}" alt="Foto" class="img-thumbnail rounded-circle" width="150" height="150" style="object-fit: cover;">
                </div>
                
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                    <label class="custom-file-label" for="foto">Pilih file foto baru...</label>
                    @error('foto')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Max: 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                
                <!-- Preview Foto Baru -->
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <label>Preview Foto Baru:</label><br>
                    <img id="preview" src="" alt="Preview" class="img-thumbnail rounded-circle" width="150" height="150" style="object-fit: cover;">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.driver.index') }}" class="btn btn-secondary">
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