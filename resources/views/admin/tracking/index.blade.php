@extends('layouts.admin')

@section('title', 'Tracking Pengiriman')
@section('page-title', 'Manajemen Tracking')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Tracking Pengiriman</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tracking.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Tracking
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Resi</th>
                    <th>Armada</th>
                    <th>Driver</th>
                    <th>Rute</th>
                    <th>Status</th>
                    <th>Tgl Kirim</th>
                    <th>Tgl Sampai</th>
                    <th>Lokasi Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trackings as $key => $tracking)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><strong>{{ $tracking->no_resi }}</strong></td>
                    <td>{{ $tracking->armada->nomor_polisi ?? '-' }}</td>
                    <td>{{ $tracking->driver->nama ?? '-' }}</td>
                    <td>{{ $tracking->rute->nama_rute ?? '-' }}</td>
                    <td>
                        @php $status = $tracking->status_pengiriman; @endphp
                        @if($status == 'sampai')
                            <span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        @elseif($status == 'dalam_perjalanan')
                            <span class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        @endif
                    </td>
                    <td>{{ optional($tracking->tanggal_kirim)->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ optional($tracking->tanggal_sampai)->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $tracking->lokasi_terakhir ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.tracking.show', $tracking) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.tracking.edit', $tracking) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracking.destroy', $tracking) }}" method="POST" style="display:inline;" 
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
                    <td colspan="10" class="text-center">Belum ada data tracking</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection