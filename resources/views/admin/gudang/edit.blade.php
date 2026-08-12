@extends('layouts.admin')

@section('title', 'Edit Gudang')
@section('page-title', 'Edit Data Gudang')

@section('content')

<!-- Alert Messages -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check-circle"></i> <strong>Sukses!</strong> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-times-circle"></i> <strong>Error!</strong> {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Gudang</h3>
    </div>
    <form action="{{ route('admin.gudang.update', $gudang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <div class="form-group">
                <label for="nama_gudang">Nama Gudang <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_gudang') is-invalid @enderror" 
                       id="nama_gudang" name="nama_gudang" value="{{ old('nama_gudang', $gudang->nama_gudang) }}" 
                       placeholder="Contoh: Gudang Pusat Bandung">
                @error('nama_gudang')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="4" 
                          placeholder="Alamat lengkap gudang...">{{ old('alamat', $gudang->alamat) }}</textarea>
                @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="kapasitas">Kapasitas (Unit) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" 
                           id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $gudang->kapasitas) }}" 
                           placeholder="Contoh: 1000" min="0" step="0.01">
                    @error('kapasitas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tarif_per_kg">Tarif Per Kg (Rp) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tarif_per_kg') is-invalid @enderror" 
                           id="tarif_per_kg" name="tarif_per_kg" value="{{ old('tarif_per_kg', $gudang->tarif_per_kg) }}" 
                           placeholder="Contoh: 10000" min="0" step="0.01" onchange="hitungHarga()">
                    @error('tarif_per_kg')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="aktif" {{ old('status', $gudang->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $gudang->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="penuh" {{ old('status', $gudang->status) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                        <option value="maintenance" {{ old('status', $gudang->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="over_capacity" {{ old('status', $gudang->status) == 'over_capacity' ? 'selected' : '' }}>Over Capacity</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="diskon_persen">Diskon (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('diskon_persen') is-invalid @enderror" 
                           id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', $gudang->diskon_persen) }}" 
                           placeholder="Contoh: 10" min="0" max="100" step="0.01" onchange="hitungHarga()">
                    @error('diskon_persen')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Calculator Harga Barang -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calculator"></i> Kalkulator Harga Barang</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="berat_barang">Berat Barang (Kg)</label>
                            <input type="number" class="form-control" id="berat_barang" 
                                   placeholder="Contoh: 50" min="0" step="0.01" onchange="hitungHarga()" oninput="hitungHarga()">
                        </div>
                        <div class="form-group col-md-8">
                            <div class="row" style="margin-top: 32px;">
                                <div class="col-md-4">
                                    <small class="text-muted">Harga Sebelum Diskon:</small>
                                    <div class="h5"><strong id="hasil_harga_sebelum">Rp 0</strong></div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Nominal Diskon:</small>
                                    <div class="h5 text-danger"><strong id="hasil_diskon">Rp 0</strong></div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Total Harga:</small>
                                    <div class="h5 text-success"><strong id="hasil_harga_akhir">Rp 0</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-3">
                        <strong>Rumus:</strong> 
                        Harga Akhir = (Berat × Tarif/Kg) - ((Berat × Tarif/Kg) × Diskon / 100)
                    </small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stok Dipakai</span>
                            <span class="info-box-number">{{ number_format($gudang->stok) }}</span>
                            <div style="margin-top: 10px; font-size: 12px;">
                                <div class="progress" style="height: 8px; margin-bottom: 5px;">
                                    @php
                                        $percentage = $gudang->kapasitas > 0 ? ($gudang->stok / $gudang->kapasitas) * 100 : 0;
                                        $progressColor = $percentage > 100 ? 'danger' : ($percentage >= 75 ? 'warning' : 'success');
                                    @endphp
                                    <div class="progress-bar bg-{{ $progressColor }}" role="progressbar" 
                                         style="width: {{ min($percentage, 100) }}%;" aria-valuenow="{{ min($percentage, 100) }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">{{ number_format($percentage, 1) }}% dari {{ number_format($gudang->kapasitas) }} unit</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-cube"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stok Tersedia</span>
                            <span class="info-box-number">{{ number_format(max(0, $gudang->kapasitas - $gudang->stok)) }}</span>
                            <div style="margin-top: 10px; font-size: 12px;">
                                @php
                                    $tersedia = max(0, $gudang->kapasitas - $gudang->stok);
                                    $persentaseTersedia = $gudang->kapasitas > 0 ? ($tersedia / $gudang->kapasitas) * 100 : 0;
                                @endphp
                                <div class="progress" style="height: 8px; margin-bottom: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $persentaseTersedia }}%;" aria-valuenow="{{ $persentaseTersedia }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">{{ number_format($persentaseTersedia, 1) }}% dari {{ number_format($gudang->kapasitas) }} unit</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Penggunaan Kapasitas</span>
                            @php
                                $percentage = $gudang->kapasitas > 0 ? ($gudang->stok / $gudang->kapasitas) * 100 : 0;
                                $statusColor = $percentage > 100 ? 'danger' : ($percentage >= 75 ? 'warning' : 'success');
                            @endphp
                            <span class="info-box-number">{{ number_format($percentage, 1) }}%</span>
                            <div style="margin-top: 10px; font-size: 12px;">
                                <div class="progress" style="height: 10px; margin-bottom: 5px;">
                                    <div class="progress-bar bg-{{ $statusColor }}" role="progressbar" 
                                         style="width: {{ min($percentage, 100) }}%;" aria-valuenow="{{ min($percentage, 100) }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    @if ($percentage > 100)
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> Over Capacity!</span>
                                    @elseif ($percentage >= 75)
                                        <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Hampir Penuh</span>
                                    @else
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Normal</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($gudang->stok > $gudang->kapasitas)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-triangle"></i> PERINGATAN! OVER CAPACITY</strong>
                    <br>
                    Stok saat ini ({{ number_format($gudang->stok) }} unit) <strong>MELEBIHI</strong> kapasitas gudang ({{ number_format($gudang->kapasitas) }} unit).
                    <br>
                    <small>Kelebihan: <strong>{{ number_format($gudang->stok - $gudang->kapasitas) }} unit</strong></small>
                    <br><br>
                    <strong>Solusi:</strong> Gunakan form di bawah untuk mengurangi stok.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif ($gudang->stok >= $gudang->kapasitas * 0.75)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Hampir Penuh</strong>
                    <br>
                    Stok sudah mencapai {{ number_format($percentage, 1) }}% dari kapasitas.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif



            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $gudang->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.gudang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<!-- Form Tambah & Kurangi Stok (SEPARATE dari form edit) -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card {{ $gudang->stok >= $gudang->kapasitas ? 'card-secondary' : 'card-success' }}">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-arrow-up"></i> Tambah Stok</h3>
            </div>
            
            @if ($gudang->stok > $gudang->kapasitas)
                <div class="card-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-ban"></i> <strong>TIDAK BISA MENAMBAH STOK!</strong>
                        <br>
                        Gudang OVER CAPACITY (melebihi kapasitas).
                        <br>
                        <small>Stok saat ini: {{ number_format($gudang->stok) }} unit</small>
                        <br>
                        <small>Kapasitas: {{ number_format($gudang->kapasitas) }} unit</small>
                        <br>
                        <small>Kelebihan: {{ number_format($gudang->stok - $gudang->kapasitas) }} unit</small>
                        <br><br>
                        <strong>Solusi:</strong> Gunakan form <strong>Kurangi Stok</strong> untuk mengurangi stok terlebih dahulu.
                    </div>
                </div>
            @elseif ($gudang->stok >= $gudang->kapasitas)
                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <strong>GUDANG PENUH!</strong>
                        <br>
                        <small>Stok saat ini: {{ number_format($gudang->stok) }} unit</small>
                        <br>
                        <small>Kapasitas: {{ number_format($gudang->kapasitas) }} unit</small>
                        <br><br>
                        <strong>Anda tidak bisa menambah stok lagi!</strong> Gunakan form <strong>Kurangi Stok</strong> untuk mengurangi stok.
                    </div>
                </div>
            @else
                <form action="{{ route('admin.gudang.add-stock', $gudang) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jumlah_masuk">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_masuk') is-invalid @enderror" 
                                   id="jumlah_masuk" name="jumlah_masuk" 
                                   placeholder="Contoh: 100" min="1" max="{{ $gudang->kapasitas - $gudang->stok }}" required>
                            <small class="form-text text-muted">Maks: {{ number_format($gudang->kapasitas - $gudang->stok) }} unit tersedia</small>
                            @error('jumlah_masuk')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan_masuk">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan_masuk" name="keterangan" 
                                   placeholder="Contoh: Pembelian dari supplier">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Tambah Stok
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="card {{ $gudang->stok <= 0 ? 'card-secondary' : 'card-danger' }}">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-arrow-down"></i> Kurangi Stok</h3>
            </div>
            
            @if ($gudang->stok <= 0)
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle"></i> <strong>STOK KOSONG!</strong>
                        <br>
                        Stok saat ini: {{ number_format($gudang->stok) }} unit
                        <br><br>
                        Tidak ada stok yang bisa dikurangi. Gunakan form <strong>Tambah Stok</strong> untuk menambah stok terlebih dahulu.
                    </div>
                </div>
            @else
                <form action="{{ route('admin.gudang.reduce-stock', $gudang) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jumlah_keluar">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_keluar') is-invalid @enderror" 
                                   id="jumlah_keluar" name="jumlah_keluar" 
                                   placeholder="Contoh: 50" min="1" max="{{ $gudang->stok }}" required>
                            <small class="form-text text-muted">Maks: {{ number_format($gudang->stok) }} unit</small>
                            @error('jumlah_keluar')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan_keluar">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan_keluar" name="keterangan" 
                                   placeholder="Contoh: Pengiriman ke area X">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-minus"></i> Kurangi Stok
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
/**
 * Hitung harga barang berdasarkan berat, tarif per kg, dan diskon
 */
function hitungHarga() {
    const beratBarang = parseFloat(document.getElementById('berat_barang').value) || 0;
    const tarifPerKg = parseFloat(document.getElementById('tarif_per_kg').value) || 0;
    const diskonPersen = parseFloat(document.getElementById('diskon_persen').value) || 0;

    // Jika berat 0, tampilkan semua hasil sebagai 0
    if (beratBarang === 0) {
        document.getElementById('hasil_harga_sebelum').textContent = 'Rp 0';
        document.getElementById('hasil_diskon').textContent = 'Rp 0';
        document.getElementById('hasil_harga_akhir').textContent = 'Rp 0';
        return;
    }

    // Hitung harga sebelum diskon
    const hargaSebelumDiskon = beratBarang * tarifPerKg;

    // Hitung nominal diskon
    const nominalDiskon = (hargaSebelumDiskon * diskonPersen) / 100;

    // Hitung harga akhir
    const hargaAkhir = hargaSebelumDiskon - nominalDiskon;

    // Format ke IDR dan tampilkan
    document.getElementById('hasil_harga_sebelum').textContent = 
        'Rp ' + hargaSebelumDiskon.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    
    document.getElementById('hasil_diskon').textContent = 
        'Rp ' + nominalDiskon.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    
    document.getElementById('hasil_harga_akhir').textContent = 
        'Rp ' + hargaAkhir.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
}

// Jalankan hitung harga saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    hitungHarga();
});
</script>

@endsection