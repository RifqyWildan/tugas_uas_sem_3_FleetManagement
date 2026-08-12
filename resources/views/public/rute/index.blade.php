@extends('layouts.public')

@section('title', 'Cek Area Layanan')

@section('content')
<div class="mb-4">
    <h1 class="text-center mb-4">Cek Area Layanan Kami</h1>
    <p class="text-center text-muted">Jangkauan rute pengiriman kami</p>
</div>

<div class="row">
    @forelse($rutes as $rute)
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-map-marker-alt text-success"></i>
                    {{ $rute->asal }} 
                    <i class="fas fa-arrow-right text-primary mx-2"></i> 
                    {{ $rute->tujuan }}
                </h5>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-road text-info"></i>
                    <strong>Jarak:</strong> {{ $rute->jarak_km }} Km
                </div>
                @if($rute->deskripsi)
                <div>
                    <i class="fas fa-info-circle text-secondary"></i>
                    <strong>Info:</strong> {{ $rute->deskripsi }}
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            Belum ada data rute tersedia.
        </div>
    </div>
    @endforelse
</div>
@endsection