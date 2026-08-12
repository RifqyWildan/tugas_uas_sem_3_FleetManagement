@extends('layouts.admin')

@section('title', 'Detail Tarif')
@section('page-title', 'Detail Tarif')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Tarif - {{ $tarif->nama_layanan }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tarif.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.tarif.edit', $tarif) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr><th>Nama Layanan</th><td>{{ $tarif->nama_layanan }}</td></tr>
            <tr><th>Tarif / Km</th><td>{{ number_format($tarif->tarif_per_km, 2) }}</td></tr>
            <tr><th>Minimal Tarif</th><td>{{ number_format($tarif->minimal_tarif, 2) }}</td></tr>
            <tr><th>Catatan</th><td>{{ $tarif->catatan ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.tarif.destroy', $tarif) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tarif ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
