@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('css')
<style>
    /* Minor tweaks for AdminLTE components */
    .chart-card { min-height: 260px; }
    .small-box .icon { top: 10px; }
    .users-table td, .users-table th { vertical-align: middle; }
</style>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Armada::count() }}</h3>
                    <p>Armada</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bus"></i>
                </div>
                <a href="{{ route('admin.armada.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Rute::count() }}</h3>
                    <p>Rute</p>
                </div>
                <div class="icon"><i class="fas fa-route"></i></div>
                <a href="{{ route('admin.rute.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Driver::count() }}</h3>
                    <p>Driver</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('admin.driver.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Gudang::count() }}</h3>
                    <p>Gudang</p>
                </div>
                <div class="icon"><i class="fas fa-warehouse"></i></div>
                <a href="{{ route('admin.gudang.index') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <section class="col-lg-7 connectedSortable">
            <!-- Ringkasan Pengiriman removed -->

            <!-- Latest orders / recent activities -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aktivitas Terbaru</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach(\App\Models\Tracking::latest()->limit(6)->get() as $track)
                        <li class="item">
                            <div class="product-img">
                                <i class="fas fa-shipping-fast fa-2x text-primary"></i>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('admin.tracking.show', $track) }}" class="product-title">Resi: {{ $track->no_resi ?? '-' }}
                                    <span class="float-right text-muted">{{ $track->status_pengiriman ?? 'Update' }}</span></a>
                                <span class="product-description">{{ Str::limit($track->catatan ?? '', 80) }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.tracking.index') }}">Lihat Semua Pengiriman</a>
                </div>
            </div>
        </section>

        <section class="col-lg-5 connectedSortable">
            <!-- Info boxes -->
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-bus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Armada</span>
                    <span class="info-box-number">{{ \App\Models\Armada::count() }}</span>
                </div>
            </div>

            <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fas fa-route"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Rute</span>
                    <span class="info-box-number">{{ \App\Models\Rute::count() }}</span>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengguna Terbaru</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover users-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::latest()->limit(5)->get() as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.user.index') }}">Lihat Semua Pengguna</a>
                </div>
            </div>

        </section>
    </div>



@endsection