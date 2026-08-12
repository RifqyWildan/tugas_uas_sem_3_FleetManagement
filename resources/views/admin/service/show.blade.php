@extends('layouts.admin')

@section('title', 'Detail Service')
@section('page-title', 'Detail Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Service - {{ $service->armada->merk ?? '#' }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.service.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.service.edit', $service) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr><th>Armada</th><td>{{ $service->armada->merk ?? '-' }} ({{ $service->armada->nomor_polisi ?? '-' }})</td></tr>
            <tr><th>Tanggal Service</th><td>{{ $service->tanggal_service->format('Y-m-d') }}</td></tr>
            <tr><th>Jenis Service</th><td>{{ $service->jenis_service }}</td></tr>
            <tr><th>Biaya</th><td>{{ number_format($service->biaya, 2) }}</td></tr>
            <tr><th>Catatan</th><td>{{ $service->catatan ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.service.destroy', $service) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus service ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
