@extends('layouts.admin')

@section('title', 'Detail Gudang')
@section('page-title', 'Detail Gudang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Gudang - {{ $gudang->nama_gudang }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.gudang.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.gudang.edit', $gudang) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check-circle"></i> <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-times-circle"></i> <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <table class="table table-striped">
            <tr><th>Nama Gudang</th><td>{{ $gudang->nama_gudang }}</td></tr>
            <tr><th>Alamat</th><td>{{ $gudang->alamat }}</td></tr>
            <tr><th>Kapasitas</th><td>{{ number_format($gudang->kapasitas) }} unit</td></tr>
            <tr><th>Stok Dipakai</th><td>{{ number_format($gudang->stok) }} unit</td></tr>
            <tr><th>Stok Tersedia</th><td>{{ number_format(max(0, $gudang->kapasitas - $gudang->stok)) }} unit</td></tr>
            <tr><th>Status</th>
                <td>
                    @php
                        $statusClass = [
                            'aktif' => 'badge-success',
                            'tidak_aktif' => 'badge-secondary',
                            'penuh' => 'badge-danger',
                            'maintenance' => 'badge-warning',
                            'over_capacity' => 'badge-dark',
                        ];
                    @endphp
                    <span class="badge {{ $statusClass[$gudang->status] ?? 'badge-secondary' }}">
                        {{ ucfirst(str_replace('_', ' ', $gudang->status)) }}
                    </span>
                </td>
            </tr>
            <tr><th>Catatan</th><td>{{ $gudang->catatan ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.gudang.destroy', $gudang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gudang ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection