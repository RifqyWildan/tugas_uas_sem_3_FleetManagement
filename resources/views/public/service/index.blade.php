@extends('layouts.public')

@section('title', 'Info Perawatan')

@section('content')
<div class="mb-4">
    <h1 class="text-center mb-4">Info Perawatan Kendaraan</h1>
    <p class="text-center text-muted">Jadwal perawatan rutin armada kami untuk keamanan Anda</p>
</div>

<div class="row">
    @forelse($services as $service)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-tools text-warning"></i>
                    {{ $service->armada->nomor_polisi ?? 'Armada' }}
                </h5>
                <hr>
                <div class="mb-3">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    <strong>Tanggal Service:</strong><br>
                    {{ $service->tanggal_service->format('d F Y') }}
                </div>
                <div class="mb-3">
                    <i class="fas fa-cogs text-secondary"></i>
                    <strong>Jenis Service:</strong><br>
                    {{ $service->jenis_service }}
                </div>
                @if($service->deskripsi)
                <div class="mb-3">
                    <i class="fas fa-clipboard-list text-info"></i>
                    <strong>Deskripsi:</strong><br>
                    <p class="mt-2">{{ $service->deskripsi }}</p>
                </div>
                @endif
                @if($service->catatan)
                <div class="mb-3">
                    <i class="fas fa-sticky-note text-warning"></i>
                    <strong>Catatan:</strong><br>
                    <p class="mt-2">{{ $service->catatan }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            Belum ada jadwal service tersedia.
        </div>
    </div>
    @endforelse
</div>
@endsection