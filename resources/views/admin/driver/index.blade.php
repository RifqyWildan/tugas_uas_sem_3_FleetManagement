@extends('layouts.admin')

@section('title', 'Data Driver')
@section('page-title', 'Manajemen Driver & Kru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Driver & Kru</h3>
        <div class="card-tools">
            <a href="{{ route('admin.driver.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Driver
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>No. SIM</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $key => $driver)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                            <img src="{{ $driver->foto_url }}" alt="Foto" width="60" class="rounded-circle">
                    </td>
                    <td>{{ $driver->nama }}</td>
                    <td>{{ $driver->no_sim }}</td>
                    <td>{{ $driver->telepon }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $driver->status_aktif)) }}</td>
                    <td>
                        <a href="{{ route('admin.driver.show', $driver) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.driver.edit', $driver) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.driver.destroy', $driver) }}" method="POST" style="display:inline;" 
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
                    <td colspan="7" class="text-center">Belum ada data driver</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection