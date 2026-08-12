@extends('layouts.admin')

@section('title', 'Jadwal Service')
@section('page-title', 'Jadwal Service Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Jadwal Service</h3>
        <div class="card-tools">
            <a href="{{ route('admin.service.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Armada</th>
                    <th>Tanggal Service</th>
                    <th>Jenis</th>
                    <th>Biaya (Rp)</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $key => $service)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><strong>{{ $service->armada->merk ?? '—' }} ({{ $service->armada->nomor_polisi ?? '—' }})</strong></td>
                    <td>{{ $service->tanggal_service->format('d F Y') }}</td>
                    <td>{{ $service->jenis_service }}</td>
                    <td>{{ number_format($service->biaya, 2) }}</td>
                    <td>{{ Str::limit($service->catatan, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.service.show', $service) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.service.edit', $service) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.service.destroy', $service) }}" method="POST" style="display:inline;" 
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
                    <td colspan="7" class="text-center">Belum ada jadwal service</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection