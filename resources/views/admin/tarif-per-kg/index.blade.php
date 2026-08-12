@extends('layouts.admin')

@section('title', 'Daftar Tarif Per Kg')
@section('page-title', 'Manajemen Tarif Per Kg Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Tarif Per Kg</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tarif-per-kg.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Tarif Per Kg
            </a>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Nama Tarif</th>
                    <th>Harga Per Kg</th>
                    <th>Tipe Barang</th>
                    <th>Status</th>
                    <th style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifPerKgs as $key => $tarif)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><strong>{{ $tarif->nama_tarif }}</strong></td>
                    <td>Rp {{ number_format($tarif->harga_per_kg, 0, ',', '.') }}</td>
                    <td>
                        @if($tarif->tipe_barang)
                            <span class="badge badge-info">{{ $tarif->tipe_barang }}</span>
                        @else
                            <span class="badge badge-secondary">-</span>
                        @endif
                    </td>
                    <td>
                        @if($tarif->status === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.tarif-per-kg.show', $tarif) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.tarif-per-kg.edit', $tarif) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.tarif-per-kg.destroy', $tarif) }}" method="POST" style="display:inline;" 
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data tarif per kg</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
