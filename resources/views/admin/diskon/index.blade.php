@extends('layouts.admin')

@section('title', 'Daftar Diskon')
@section('page-title', 'Manajemen Diskon')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Diskon</h3>
        <div class="card-tools">
            <a href="{{ route('admin.diskon.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Diskon
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
                    <th>Nama Diskon</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Tanggal Berlaku</th>
                    <th>Status</th>
                    <th style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diskons as $key => $diskon)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><strong>{{ $diskon->nama_diskon }}</strong></td>
                    <td>
                        @if($diskon->tipe_diskon === 'persen')
                            <span class="badge badge-primary">Persen</span>
                        @elseif($diskon->tipe_diskon === 'nominal')
                            <span class="badge badge-info">Nominal</span>
                        @else
                            <span class="badge badge-secondary">Otomatis</span>
                        @endif
                    </td>
                    <td>
                        @if($diskon->tipe_diskon === 'persen' || $diskon->tipe_diskon === 'otomatis')
                            {{ number_format($diskon->diskon_persen, 2) }}%
                        @else
                            Rp {{ number_format($diskon->diskon_nominal, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if($diskon->tanggal_mulai && $diskon->tanggal_selesai)
                            {{ $diskon->tanggal_mulai->format('d M Y') }} - {{ $diskon->tanggal_selesai->format('d M Y') }}
                        @elseif($diskon->tanggal_mulai)
                            Mulai {{ $diskon->tanggal_mulai->format('d M Y') }}
                        @elseif($diskon->tanggal_selesai)
                            Sampai {{ $diskon->tanggal_selesai->format('d M Y') }}
                        @else
                            <span class="text-muted">Tidak terbatas</span>
                        @endif
                    </td>
                    <td>
                        @if($diskon->isActive())
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.diskon.show', $diskon) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.diskon.edit', $diskon) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.diskon.destroy', $diskon) }}" method="POST" style="display:inline;" 
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
                    <td colspan="7" class="text-center text-muted">Belum ada data diskon</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
