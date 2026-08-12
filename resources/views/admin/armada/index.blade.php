@extends('layouts.admin')

@section('title', 'Data Armada')

@section('page-title', 'Manajemen Armada')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Armada</h3>
        <div class="card-tools">
            <a href="{{ route('admin.armada.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Armada
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nomor Polisi</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>Kapasitas</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($armadas as $key => $armada)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <img src="{{ $armada->foto_url }}" alt="Foto" width="80">
                    </td>
                    <td>{{ $armada->nomor_polisi }}</td>
                    <td>{{ $armada->jenis_kendaraan }}</td>
                    <td>{{ $armada->merk }}</td>
                    <td>{{ $armada->kapasitas_muatan }}</td>
                    <td>{{ $armada->tahun_pembuatan }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $armada->status)) }}</td>
                    <td>
                        <a href="{{ route('admin.armada.show', $armada) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.armada.edit', $armada) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if($armada->trackings_count || $armada->services_count)
                            <button class="btn btn-danger btn-sm" disabled title="Tidak dapat dihapus: ada data terkait (pengiriman/service)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        @else
                            <form action="{{ route('admin.armada.destroy', $armada) }}" method="POST" style="display:inline;" 
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data armada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection