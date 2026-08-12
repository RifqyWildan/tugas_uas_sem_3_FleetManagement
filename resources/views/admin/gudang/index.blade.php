@extends('layouts.admin')

@section('title', 'Manajemen Gudang')
@section('page-title', 'Manajemen Gudang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Gudang</h3>
        <div class="card-tools">
            <a href="{{ route('admin.gudang.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Gudang
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Gudang</th>
                    <th>Alamat</th>
                    <th>Kapasitas</th>
                    <th>Stok Dipakai</th>
                    <th>Stok Tersedia</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gudangs as $key => $gudang)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $gudang->nama_gudang }}</td>
                    <td>{{ $gudang->alamat }}</td>
                    <td>{{ number_format($gudang->kapasitas) }} unit</td>
                    <td>
                        @php
                            $percentage = $gudang->kapasitas > 0 ? ($gudang->stok / $gudang->kapasitas) * 100 : 0;
                            
                            $color = 'bg-info'; // Default < 25%
                            if ($percentage >= 100) {
                                $color = 'bg-danger';
                            } elseif ($percentage >= 75) {
                                $color = 'bg-warning';
                            } elseif ($percentage >= 25) {
                                $color = 'bg-success';
                            }
                        @endphp
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-weight-bold">{{ number_format($gudang->stok) }}</span>
                            <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info" style="font-size: 12px; padding: 5px 8px;">
                            {{ number_format(max(0, $gudang->kapasitas - $gudang->stok)) }} unit
                        </span>
                    </td>
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
                    <td>
                        <a href="{{ route('admin.gudang.show', $gudang) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.gudang.edit', $gudang) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.gudang.destroy', $gudang) }}" method="POST" style="display:inline;" 
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
                    <td colspan="8" class="text-center">Belum ada data gudang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection