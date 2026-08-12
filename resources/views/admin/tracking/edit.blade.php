@extends('layouts.admin')

@section('title', 'Edit Tracking')
@section('page-title', 'Edit Tracking')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Tracking</h3>
    </div>
    <form action="{{ route('admin.tracking.update', $tracking) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="no_resi">Nomor Resi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_resi') is-invalid @enderror" 
                       id="no_resi" name="no_resi" value="{{ old('no_resi', $tracking->no_resi) }}" 
                       placeholder="Contoh: RESI123456789">
                @error('no_resi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_armada">Armada <span class="text-danger">*</span></label>
                    <select name="id_armada" id="id_armada" class="form-control @error('id_armada') is-invalid @enderror">
                        <option value="">Pilih Armada</option>
                        @foreach($armadas as $armada)
                            <option value="{{ $armada->id_armada }}" {{ old('id_armada', $tracking->id_armada) == $armada->id_armada ? 'selected' : '' }}>
                                {{ $armada->nomor_polisi }} - {{ $armada->jenis_kendaraan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_armada')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="id_driver">Driver <span class="text-danger">*</span></label>
                    <select name="id_driver" id="id_driver" class="form-control @error('id_driver') is-invalid @enderror">
                        <option value="">Pilih Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id_driver }}" {{ old('id_driver', $tracking->id_driver) == $driver->id_driver ? 'selected' : '' }}>
                                {{ $driver->nama }} - {{ $driver->no_sim }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_driver')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="id_rute">Rute <span class="text-danger">*</span></label>
                    <select name="id_rute" id="id_rute" class="form-control @error('id_rute') is-invalid @enderror">
                        <option value="">Pilih Rute</option>
                        @foreach($rutes as $rute)
                            <option value="{{ $rute->id_rute }}" {{ old('id_rute', $tracking->id_rute) == $rute->id_rute ? 'selected' : '' }}>
                                {{ $rute->nama_rute }} ({{ $rute->asal }} - {{ $rute->tujuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_rute')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="status_pengiriman">Status Pengiriman <span class="text-danger">*</span></label>
                    <select name="status_pengiriman" id="status_pengiriman" class="form-control @error('status_pengiriman') is-invalid @enderror">
                        <option value="">Pilih Status</option>
                        <option value="pending" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dikirim" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="dalam_perjalanan" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                        <option value="sampai" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'sampai' ? 'selected' : '' }}>Sampai</option>
                        <option value="selesai" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status_pengiriman', $tracking->status_pengiriman) == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status_pengiriman')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="tanggal_kirim">Tanggal Kirim <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_kirim" id="tanggal_kirim" class="form-control @error('tanggal_kirim') is-invalid @enderror" value="{{ old('tanggal_kirim', optional($tracking->tanggal_kirim)->format('Y-m-d')) }}">
                    @error('tanggal_kirim')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="tanggal_sampai">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control @error('tanggal_sampai') is-invalid @enderror" value="{{ old('tanggal_sampai', optional($tracking->tanggal_sampai)->format('Y-m-d')) }}">
                    @error('tanggal_sampai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="lokasi_terakhir">Lokasi Terakhir</label>
                <input type="text" name="lokasi_terakhir" id="lokasi_terakhir" class="form-control @error('lokasi_terakhir') is-invalid @enderror" value="{{ old('lokasi_terakhir', $tracking->lokasi_terakhir) }}" placeholder="Contoh: Bandung - Gudang">
                @error('lokasi_terakhir')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $tracking->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.tracking.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection