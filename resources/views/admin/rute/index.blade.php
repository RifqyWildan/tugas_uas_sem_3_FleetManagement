@extends('layouts.admin')

@section('title', 'Data Rute')
@section('page-title', 'Manajemen Rute Pengiriman')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Rute</h3>
        <div class="card-tools">
            <a href="{{ route('admin.rute.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Rute
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Rute</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Jarak (Km)</th>
                    <th>Estimasi (menit)</th>
                    <th>Tarif (Rp)</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rutes as $key => $rute)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $rute->nama_rute }}</td>
                    <td>{{ $rute->asal }}</td>
                    <td>{{ $rute->tujuan }}</td>
                    <td>{{ $rute->jarak_km }} Km</td>
                    <td>{{ $rute->estimasi_waktu }}</td>
                    <td>{{ number_format($rute->tarif, 2) }}</td>
                    <td>{{ Str::limit($rute->catatan, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.rute.show', $rute) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.rute.edit', $rute) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.rute.destroy', $rute) }}" method="POST" style="display:inline;" 
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
                    <td colspan="9" class="text-center">Belum ada data rute</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection