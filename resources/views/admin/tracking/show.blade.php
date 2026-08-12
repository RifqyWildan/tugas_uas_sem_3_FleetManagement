@extends('layouts.admin')

@section('title', 'Detail Tracking')
@section('page-title', 'Detail Tracking')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Tracking</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">No. Resi</dt>
            <dd class="col-sm-9">{{ $tracking->no_resi }}</dd>

            <dt class="col-sm-3">Armada</dt>
            <dd class="col-sm-9">{{ $tracking->armada->nomor_polisi ?? '-' }} - {{ $tracking->armada->jenis_kendaraan ?? '' }}</dd>

            <dt class="col-sm-3">Driver</dt>
            <dd class="col-sm-9">{{ $tracking->driver->nama ?? '-' }} ({{ $tracking->driver->no_sim ?? '' }})</dd>

            <dt class="col-sm-3">Rute</dt>
            <dd class="col-sm-9">{{ $tracking->rute->nama_rute ?? '-' }} ({{ $tracking->rute->asal ?? '' }} - {{ $tracking->rute->tujuan ?? '' }})</dd>

            <dt class="col-sm-3">Status Pengiriman</dt>
            <dd class="col-sm-9">{{ ucfirst(str_replace('_', ' ', $tracking->status_pengiriman)) }}</dd>

            <dt class="col-sm-3">Tanggal Kirim</dt>
            <dd class="col-sm-9">{{ optional($tracking->tanggal_kirim)->format('d/m/Y') ?? '-' }}</dd>

            <dt class="col-sm-3">Tanggal Sampai</dt>
            <dd class="col-sm-9">{{ optional($tracking->tanggal_sampai)->format('d/m/Y') ?? '-' }}</dd>

            <dt class="col-sm-3">Lokasi Terakhir</dt>
            <dd class="col-sm-9">{{ $tracking->lokasi_terakhir ?? '-' }}</dd>

            <dt class="col-sm-3">Catatan</dt>
            <dd class="col-sm-9">{{ $tracking->catatan ?? '-' }}</dd>

            <dt class="col-sm-3">Dibuat</dt>
            <dd class="col-sm-9">{{ $tracking->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Terakhir Diupdate</dt>
            <dd class="col-sm-9">{{ $tracking->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.tracking.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.tracking.edit', $tracking) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    </div>
</div>
@endsection