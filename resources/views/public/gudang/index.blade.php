@extends('layouts.public')

@section('title', 'Lokasi Gudang')

@section('content')
<div class="mb-4">
    <h1 class="text-center mb-4">Lokasi Gudang Kami</h1>
    <p class="text-center text-muted">Temukan gudang terdekat dari lokasi Anda</p>
</div>

<div class="row">
    @forelse($gudangs as $gudang)
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-warehouse text-primary"></i>
                    {{ $gudang->nama }}
                </h5>
                <hr>
                <div class="mb-3">
                    <p><strong><i class="fas fa-map-marker-alt text-danger"></i> Alamat:</strong></p>
                    <p class="ms-4">{{ $gudang->alamat }}</p>
                </div>
                <div class="mb-3">
                    <p><strong><i class="fas fa-box text-success"></i> Kapasitas:</strong></p>
                    <p class="ms-4">{{ number_format($gudang->kapasitas) }} unit</p>
                </div>
                
                <!-- Google Maps Embed (centered on alamat) -->
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.google.com/maps?q={{ urlencode($gudang->alamat) }}&output=embed"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div> 
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            Belum ada data gudang tersedia.
        </div>
    </div>
    @endforelse
</div>
@endsection