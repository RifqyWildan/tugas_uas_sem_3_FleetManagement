@extends('layouts.admin')

@section('title', 'Daftar Tarif')
@section('page-title', 'Daftar Tarif & Layanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Tarif Layanan</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tarif.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Tarif
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Harga per Km</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifs as $key => $tarif)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tarif->nama_layanan }}</td>
                    <td>Rp {{ number_format($tarif->tarif_per_km, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.tarif.edit', $tarif) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tarif.destroy', $tarif) }}" method="POST" style="display:inline;" 
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data tarif</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection