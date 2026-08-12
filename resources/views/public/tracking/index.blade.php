@extends('layouts.public')

@section('title', 'Cek Resi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="text-center mb-4">
                    <i class="fas fa-search-location text-primary"></i> Cek Resi Pengiriman
                </h1>
                <p class="text-center text-muted mb-4">Masukkan nomor resi untuk melacak paket Anda</p>
                
                <form method="GET" action="{{ url('/cek-resi') }}">
                    <div class="input-group mb-3">
                        <input type="text" 
                               name="resi" 
                               class="form-control form-control-lg" 
                               placeholder="Masukkan No. Resi" 
                               value="{{ request('resi') }}"
                               required>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i> Cek Resi
                        </button>
                    </div>
                </form>

                @if(request('resi'))
                    @if($tracking)
                    <div class="alert alert-success mt-4">
                        <h4 class="alert-heading">
                            <i class="fas fa-check-circle"></i> Paket Ditemukan!
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>No. Resi:</strong><br>{{ $tracking->no_resi }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong><br>
                                    @php $st = $tracking->status_pengiriman; @endphp
                                    @if($st == 'sampai')
                                        <span class="badge bg-success p-2">{{ ucfirst(str_replace('_', ' ', $st)) }}</span>
                                    @elseif($st == 'dalam_perjalanan')
                                        <span class="badge bg-warning p-2">{{ ucfirst(str_replace('_', ' ', $st)) }}</span>
                                    @else
                                        <span class="badge bg-info p-2">{{ ucfirst(str_replace('_', ' ', $st)) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($tracking->lokasi_terakhir)
                        <p class="mb-0">
                            <strong><i class="fas fa-map-marker-alt text-danger"></i> Lokasi Terakhir:</strong><br>
                            {{ $tracking->lokasi_terakhir }}
                        </p>
                        @endif
                        <hr>
                        <p class="mb-0 text-muted">
                            <small>Terakhir diupdate: {{ $tracking->updated_at->format('d F Y, H:i') }} WIB</small>
                        </p>
                    </div>
                    @else
                    <div class="alert alert-danger mt-4">
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-triangle"></i> Resi Tidak Ditemukan
                        </h5>
                        <p class="mb-0">Nomor resi <strong>{{ request('resi') }}</strong> tidak ditemukan dalam sistem kami. Pastikan nomor resi yang Anda masukkan benar.</p>
                    </div>
                    @endif
                @endif

            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="fas fa-info-circle text-info"></i> Informasi Status</h5>
                <ul class="mb-0">
                    <li><strong>Dikirim:</strong> Paket telah dikirim dari gudang</li>
                    <li><strong>Dalam Perjalanan:</strong> Paket sedang dalam perjalanan menuju tujuan</li>
                    <li><strong>Sampai:</strong> Paket telah sampai di tujuan</li>
                </ul>
            </div>
        </div>

        <!-- Daftar Resi Aktif -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Daftar Resi Pengiriman Aktif
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%;">No. Resi</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 20%;">Lokasi</th>
                            <th style="width: 12%;">Tgl Kirim</th>
                            <th style="width: 15%;">Driver</th>
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allTrackings as $item)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $item->no_resi }}</strong>
                            </td>
                            <td>
                                @php $st = $item->status_pengiriman; @endphp
                                @if($st == 'sampai')
                                    <span class="badge bg-success">Sampai</span>
                                @elseif($st == 'dalam_perjalanan')
                                    <span class="badge bg-warning text-dark">Dalam Perjalanan</span>
                                @else
                                    <span class="badge bg-info">Dikirim</span>
                                @endif
                            </td>
                            <td>{{ $item->lokasi_terakhir ?? '-' }}</td>
                            <td>{{ optional($item->tanggal_kirim)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $item->driver->nama ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ url('/cek-resi?resi=' . $item->no_resi) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">
                                <i class="fas fa-inbox"></i> Tidak ada resi pengiriman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection