@extends('layouts.public')

@section('title', 'Cek Ongkir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="text-center mb-4">
                    <i class="fas fa-calculator text-success"></i> Cek Ongkos Kirim
                </h1>
                <p class="text-center text-muted mb-4">Hitung estimasi biaya pengiriman Anda</p>
                
                <form method="POST" action="{{ route('public.tarif.calculate') }}">
                    @csrf
                    <div class="form-group">
                        <label for="id_tarif">Pilih Layanan <span class="text-danger">*</span></label>
                        <select name="id_tarif" id="id_tarif" class="form-control" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($tarifs as $tarif)
                            <option value="{{ $tarif->id_tarif }}" {{ request('id_tarif') == $tarif->id_tarif ? 'selected' : '' }}>
                                {{ $tarif->nama_layanan }} - Rp {{ number_format($tarif->tarif_per_km, 0, ',', '.') }}/km
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_rute">Pilih Rute <span class="text-danger">*</span></label>
                        <select name="id_rute" id="id_rute" class="form-control" required>
                            <option value="">-- Pilih Rute --</option>
                            @foreach($rutes as $rute)
                            <option value="{{ $rute->id_rute }}" {{ request('id_rute') == $rute->id_rute ? 'selected' : '' }}>
                                {{ $rute->nama_rute }} - {{ $rute->jarak_km }} Km
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_diskon">Diskon (Opsional)</label>
                        <select name="id_diskon" id="id_diskon" class="form-control">
                            <option value="">-- Tidak Ada Diskon --</option>
                            @forelse($diskons as $diskon)
                                @if($diskon->isActive())
                                    <option value="{{ $diskon->id_diskon }}" {{ request('id_diskon') == $diskon->id_diskon ? 'selected' : '' }}>
                                        {{ $diskon->nama_diskon }}
                                        @if($diskon->tipe_diskon === 'persen')
                                            ({{ $diskon->diskon_persen }}%)
                                        @else
                                            (Rp {{ number_format($diskon->diskon_nominal, 0, ',', '.') }})
                                        @endif
                                    </option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-calculator"></i> Hitung Ongkir
                    </button>
                </form>



            </div>
        </div>

        <!-- Daftar Tarif -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="fas fa-list text-primary"></i> Daftar Tarif Layanan</h5>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Harga per Km</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tarifs as $tarif)
                        <tr>
                            <td>{{ $tarif->nama_layanan }}</td>
                            <td>Rp {{ number_format($tarif->tarif_per_km, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection