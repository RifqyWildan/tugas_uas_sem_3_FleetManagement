@extends('layouts.public')

@section('title', 'Profil Tim')

@section('content')
<div class="mb-4">
    <h1 class="text-center mb-4">Profil Tim Kami</h1>
    <p class="text-center text-muted">Tim profesional dan berpengalaman siap melayani Anda</p>
</div>

<div class="row">
    @forelse($drivers as $driver)
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card h-100 shadow-sm text-center">
            <div class="card-body">
                    <img src="{{ $driver->foto_url }}" 
                         alt="{{ $driver->nama }}" 
                         class="rounded-circle mb-3" 
                         width="120" 
                         height="120"
                         style="object-fit: cover; border: 4px solid #007bff;">
                
                <h5 class="card-title mb-1">{{ $driver->nama }}</h5>
                <p class="text-muted mb-2">
                    <small>
                        <i class="fas fa-id-badge text-primary"></i>
                        {{ $driver->jabatan }}
                    </small>
                </p>
                
                @if($driver->bio)
                <p class="card-text small">{{ Str::limit($driver->bio, 80) }}</p>
                @endif
                
                <hr>
                @php
                    $phone = preg_replace('/\D+/', '', $driver->telepon ?? '');
                    $whText = urlencode('Halo ' . $driver->nama . ', saya ingin informasi lebih lanjut.');
                    $whLink = $phone ? ('https://wa.me/' . $phone . '?text=' . $whText) : '#';
                @endphp
                <div class="d-flex justify-content-center gap-2">
                    @if($phone)
                        <a href="{{ $whLink }}" target="_blank" class="btn btn-success btn-sm" title="Chat WhatsApp {{ $driver->nama }}">
                            <i class="fab fa-whatsapp"></i> WA
                        </a>
                    @else
                        <span class="text-muted">Kontak tidak tersedia</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            Belum ada data tim tersedia.
        </div>
    </div>
    @endforelse
</div>
@endsection