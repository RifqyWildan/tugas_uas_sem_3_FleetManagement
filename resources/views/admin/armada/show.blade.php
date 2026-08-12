@extends('layouts.admin')

@section('title', 'Detail Armada')

@section('page-title', 'Detail Armada')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Armada - {{ $armada->nomor_polisi }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.armada.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.armada.edit', $armada) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $armada->foto_url }}" alt="Foto Armada" class="img-fluid img-thumbnail">
            </div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <tr>
                        <th>Nomor Polisi</th>
                        <td>{{ $armada->nomor_polisi }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kendaraan</th>
                        <td>{{ $armada->jenis_kendaraan }}</td>
                    </tr>
                    <tr>
                        <th>Merk</th>
                        <td>{{ $armada->merk }}</td>
                    </tr>
                    <tr>
                        <th>Kapasitas Muatan</th>
                        <td>{{ $armada->kapasitas_muatan }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Pembuatan</th>
                        <td>{{ $armada->tahun_pembuatan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ ucfirst(str_replace('_', ' ', $armada->status)) }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $armada->catatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Riwayat Pengiriman</th>
                        <td>{{ $armada->trackings->count() }} records</td>
                    </tr>
                    <tr>
                        <th>Riwayat Service</th>
                        <td>{{ $armada->services->count() }} records</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @php
            $hasRelations = $armada->trackings()->exists() || $armada->services()->exists();
        @endphp

        @if($hasRelations)
            <button class="btn btn-danger" disabled><i class="fas fa-trash"></i> Hapus</button>
            <small class="text-muted d-block mt-2">Armada tidak dapat dihapus karena memiliki riwayat pengiriman atau riwayat service.</small>
        @else
            <form action="{{ route('admin.armada.destroy', $armada) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus armada ini?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
            </form>
        @endif
    </div>
</div>
@endsection
