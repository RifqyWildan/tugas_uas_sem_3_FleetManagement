@extends('layouts.admin')

@section('title', 'Detail Tarif Per Kg')
@section('page-title', 'Detail Tarif Per Kg')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Tarif Per Kg - {{ $tarifPerKg->nama_tarif }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tarif-per-kg.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.tarif-per-kg.edit', $tarifPerKg) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 200px">Nama Tarif</th>
                <td><strong>{{ $tarifPerKg->nama_tarif }}</strong></td>
            </tr>
            <tr>
                <th>Harga Per Kg</th>
                <td><strong>Rp {{ number_format($tarifPerKg->harga_per_kg, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <th>Tipe Barang</th>
                <td>{{ $tarifPerKg->tipe_barang ?? '-' }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $tarifPerKg->deskripsi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($tarifPerKg->status === 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $tarifPerKg->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Diperbarui</th>
                <td>{{ $tarifPerKg->updated_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.tarif-per-kg.destroy', $tarifPerKg) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tarif ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
