@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="hero-card">
            <h1>Selamat Datang di Fleet Management</h1>
            <p class="lead">Solusi Terpercaya untuk Transportasi dan Logistik Anda</p>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5">
    <h2 class="text-center mb-5">Layanan Kami</h2>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-circle mb-3"><i class="fas fa-bus text-primary"></i></div>
                    <h5 class="card-title fw-bold">Armada Lengkap</h5>
                    <p class="card-text text-muted">Berbagai pilihan armada berkualitas untuk kebutuhan Anda</p>
                    <a href="{{ url('/armada') }}" class="btn btn-custom mt-3">Lihat Armada</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-circle mb-3"><i class="fas fa-shipping-fast text-success"></i></div>
                    <h5 class="card-title fw-bold">Tracking Real-time</h5>
                    <p class="card-text text-muted">Pantau status pengiriman Anda secara langsung</p>
                    <a href="{{ url('/cek-resi') }}" class="btn btn-custom mt-3">Cek Resi</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-circle mb-3"><i class="fas fa-calculator text-warning"></i></div>
                    <h5 class="card-title fw-bold">Cek Ongkir</h5>
                    <p class="card-text text-muted">Hitung estimasi biaya pengiriman dengan mudah</p>
                    <a href="{{ url('/cek-ongkir') }}" class="btn btn-custom mt-3">Hitung Ongkir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-circle mb-3"><i class="fas fa-search-location text-info"></i></div>
                    <h5 class="card-title fw-bold">Cek Resi</h5>
                    <p class="card-text text-muted">Masukkan nomor resi untuk melihat status pengiriman</p>
                    <a href="{{ url('/cek-resi') }}" class="btn btn-custom mt-3">Cek Resi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <i class="fas fa-bus fa-3x text-primary mb-3"></i>
                <h3>{{ \App\Models\Armada::count() }}+</h3>
                <p class="text-muted">Armada</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-route fa-3x text-success mb-3"></i>
                <h3>{{ \App\Models\Rute::count() }}+</h3>
                <p class="text-muted">Rute</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-users fa-3x text-info mb-3"></i>
                <h3>{{ \App\Models\Driver::count() }}+</h3>
                <p class="text-muted">Driver</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fas fa-warehouse fa-3x text-warning mb-3"></i>
                <h3>{{ \App\Models\Gudang::count() }}+</h3>
                <p class="text-muted">Gudang</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="container my-5 text-center">
    <h2 class="mb-4">Siap Memulai Perjalanan Anda?</h2>
    <p class="lead mb-4">Hubungi kami untuk informasi lebih lanjut</p>
    <a href="https://wa.me/6281234567890" class="btn btn-success btn-lg" target="_blank">
        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
    </a>
</div>
@endsection