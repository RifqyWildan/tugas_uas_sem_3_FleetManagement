@extends('layouts.admin')

@section('title', 'Detail Driver')
@section('page-title', 'Detail Driver')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Driver - {{ $driver->nama }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.driver.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.driver.edit', $driver) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $driver->foto_url }}" alt="Foto" class="img-fluid img-thumbnail rounded-circle">
            </div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <tr><th>Nama</th><td>{{ $driver->nama }}</td></tr>
                    <tr><th>No. KTP</th><td>{{ $driver->no_ktp }}</td></tr>
                    <tr><th>No. SIM</th><td>{{ $driver->no_sim }}</td></tr>
                    <tr><th>Tipe SIM</th><td>{{ $driver->tipe_sim }}</td></tr>
                    <tr><th>Telepon</th><td>{{ $driver->telepon }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $driver->alamat }}</td></tr>
                    <tr><th>Tanggal Bergabung</th><td>{{ optional($driver->tanggal_gabung)->format('Y-m-d') }}</td></tr>
                    <tr><th>Status</th><td>{{ ucfirst(str_replace('_', ' ', $driver->status_aktif)) }}</td></tr>
                    <tr><th>Riwayat Pengiriman</th><td>{{ $driver->trackings->count() }} records</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <form action="{{ route('admin.driver.destroy', $driver) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus driver ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
