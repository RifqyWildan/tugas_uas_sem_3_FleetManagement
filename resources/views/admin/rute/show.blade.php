@extends('layouts.admin')

@section('title', 'Detail Rute')
@section('page-title', 'Detail Rute')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Rute - {{ $rute->nama_rute }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rute.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.rute.edit', $rute) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr><th>Nama Rute</th><td>{{ $rute->nama_rute }}</td></tr>
            <tr><th>Asal</th><td>{{ $rute->asal }}</td></tr>
            <tr><th>Tujuan</th><td>{{ $rute->tujuan }}</td></tr>
            <tr><th>Jarak</th><td>{{ $rute->jarak_km }} Km</td></tr>
            <tr><th>Estimasi Waktu</th><td>{{ $rute->estimasi_waktu }} menit</td></tr>
            <tr><th>Tarif</th><td>{{ number_format($rute->tarif, 2) }}</td></tr>
            <tr><th>Catatan</th><td>{{ $rute->catatan ?? '-' }}</td></tr>
            <tr><th>Riwayat Pengiriman</th><td>{{ $rute->trackings->count() }} records</td></tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.rute.destroy', $rute) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rute ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
