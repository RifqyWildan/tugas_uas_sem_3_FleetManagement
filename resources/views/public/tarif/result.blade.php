@extends('layouts.public')

@section('title', 'Hasil Perhitungan Ongkir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="text-center mb-4">
                    <i class="fas fa-calculator text-success"></i> Hasil Perhitungan Ongkir
                </h1>

                <div class="alert alert-success mt-4">
                    <h4 class="alert-heading">
                        <i class="fas fa-check-circle"></i> Hasil Perhitungan
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Layanan:</strong><br>{{ $tarif->nama_layanan }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rute:</strong><br>{{ $rute->nama_rute }} ({{ $rute->jarak_km }} Km)</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tarif Per Km:</strong><br>Rp {{ number_format($tarif->tarif_per_km, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Subtotal:</strong><br><span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    @if($diskon && $nominalDiskon > 0)
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Diskon:</strong><br>{{ $diskon->nama_diskon }}
                                @if($diskon->tipe_diskon === 'persen')
                                    <br><small class="text-muted">({{ $diskon->diskon_persen }}%)</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nominal Diskon:</strong><br><span class="text-warning">- Rp {{ number_format($nominalDiskon, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    <hr>
                    <h3 class="text-center mb-0 mt-3">
                        <strong>Total Ongkir (setelah diskon):</strong><br>
                        <span class="text-success" style="font-size: 24px;">Rp {{ number_format($totalAkhir, 0, ',', '.') }}</span>
                    </h3>
                    @else
                    <hr>
                    <h3 class="text-center mb-0 mt-3">
                        <strong>Total Ongkir:</strong><br>
                        <span class="text-success" style="font-size: 24px;">Rp {{ number_format($totalAkhir, 0, ',', '.') }}</span>
                    </h3>
                    @endif
                </div>

                <a href="{{ route('public.tarif.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </div>
        </div>
    </div>
</div>
@endsection