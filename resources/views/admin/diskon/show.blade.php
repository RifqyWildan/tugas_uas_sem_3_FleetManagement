@extends('layouts.admin')

@section('title', 'Detail Diskon')
@section('page-title', 'Detail Diskon')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Diskon - {{ $diskon->nama_diskon }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.diskon.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.diskon.edit', $diskon) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th style="width: 200px">Nama Diskon</th>
                <td><strong>{{ $diskon->nama_diskon }}</strong></td>
            </tr>
            <tr>
                <th>Tipe Diskon</th>
                <td>
                    @if($diskon->tipe_diskon === 'persen')
                        <span class="badge badge-primary">Persen (%)</span>
                    @elseif($diskon->tipe_diskon === 'nominal')
                        <span class="badge badge-info">Nominal (Rp)</span>
                    @else
                        <span class="badge badge-secondary">Otomatis</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nilai Diskon</th>
                <td>
                    @if($diskon->tipe_diskon === 'persen' || $diskon->tipe_diskon === 'otomatis')
                        <strong>{{ number_format($diskon->diskon_persen, 2) }}%</strong>
                    @else
                        <strong>Rp {{ number_format($diskon->diskon_nominal, 0, ',', '.') }}</strong>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ $diskon->tanggal_mulai ? $diskon->tanggal_mulai->format('d M Y') : 'Tidak ada' }}</td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ $diskon->tanggal_selesai ? $diskon->tanggal_selesai->format('d M Y') : 'Tidak ada' }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $diskon->keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($diskon->isActive())
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $diskon->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Diperbarui</th>
                <td>{{ $diskon->updated_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <form action="{{ route('admin.diskon.destroy', $diskon) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus diskon ini?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
@endsection
