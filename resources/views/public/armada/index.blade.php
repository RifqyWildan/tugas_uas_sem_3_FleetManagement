@extends('layouts.public')

@section('title', 'Info Armada')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center" style="padding: 60px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 50px;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-bus"></i> Armada Kami
        </h1>
        <p class="lead">Berbagai pilihan armada berkualitas untuk perjalanan Anda</p>
    </div>
</div>



<!-- Armada Grid -->
<div class="container">
    <div class="row">
        @forelse($armadas as $armada)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm armada-card">
                    <img src="{{ $armada->foto_url }}" 
                         class="card-img-top" 
                         alt="{{ $armada->merk }} {{ $armada->nomor_polisi }}"
                         style="height: 250px; object-fit: cover;">
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $armada->merk }} <small class="text-muted">({{ $armada->nomor_polisi }})</small></h5>
                        <span class="badge bg-primary">{{ $armada->jenis_kendaraan }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <p class="card-text">
                            {{ Str::limit($armada->catatan ?? '-', 100) }}
                        </p>
                    </div>
                    
                    <div class="armada-details">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-id-card text-primary"></i> Nomor Polisi:</span>
                            <strong>{{ $armada->nomor_polisi }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-tag text-success"></i> Jenis:</span>
                            <strong>{{ $armada->jenis_kendaraan }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-check-circle text-success"></i> Status:</span>
                            @if($armada->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($armada->status == 'tidak_aktif')
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @else
                                <span class="badge bg-warning">Maintenance</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-top-0">
                    <button type="button" class="btn btn-outline-primary w-100" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailModal{{ $armada->id_armada }}">
                        <i class="fas fa-info-circle"></i> Detail Lengkap
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal{{ $armada->id_armada }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-bus"></i> {{ $armada->merk }} <small class="text-muted">({{ $armada->nomor_polisi }})</small>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                    <img src="{{ $armada->foto_url }}" class="img-fluid rounded mb-3" alt="{{ $armada->merk }} {{ $armada->nomor_polisi }}">
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Spesifikasi</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><i class="fas fa-bus text-primary"></i> Merk:</td>
                                        <td><strong>{{ $armada->merk }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-tag text-success"></i> Jenis:</td>
                                        <td><strong>{{ $armada->jenis_kendaraan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-id-card text-info"></i> Nomor Polisi:</td>
                                        <td><strong>{{ $armada->nomor_polisi }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-calendar-alt text-secondary"></i> Tahun:</td>
                                        <td><strong>{{ $armada->tahun_pembuatan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-weight-hanging text-secondary"></i> Kapasitas:</td>
                                        <td><strong>{{ $armada->kapasitas_muatan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-check-circle text-success"></i> Status:</td>
                                        <td>
                                            @if($armada->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($armada->status == 'tidak_aktif')
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @else
                                                <span class="badge bg-warning">Maintenance</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                
                                @if($armada->catatan)
                                <div class="mt-3">
                                    <h5>Catatan:</h5>
                                    <p>{{ $armada->catatan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan armada {{ $armada->merk }} ({{ $armada->nomor_polisi }})" 
                           class="btn btn-success" target="_blank">
                            <i class="fab fa-whatsapp"></i> Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Belum Ada Data Armada</h4>
                <p class="mb-0">Armada akan segera tersedia. Silakan cek kembali nanti.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($armadas->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $armadas->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<!-- Features Section -->
<div class="bg-light py-5 mt-5">
    <div class="container">
        <h3 class="text-center mb-4">Keunggulan Armada Kami</h3>
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5>Terawat</h5>
                <p class="text-muted">Service rutin & berkala</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>Aman</h5>
                <p class="text-muted">Standar keselamatan tinggi</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-couch fa-3x text-info mb-3"></i>
                <h5>Nyaman</h5>
                <p class="text-muted">Interior modern & bersih</p>
            </div>
            <div class="col-md-3 mb-3">
                <i class="fas fa-user-tie fa-3x text-warning mb-3"></i>
                <h5>Driver Profesional</h5>
                <p class="text-muted">Berpengalaman & ramah</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.armada-card {
    transition: all 0.3s ease;
    border: none;
}

.armada-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
}

.armada-details {
    font-size: 0.9rem;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.armada-card:hover .card-img-top {
    transform: scale(1.05);
}

.badge {
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
}
</style>
@endsection