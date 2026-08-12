<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - Fleet Management</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                @php
                    $unread = Auth::user()->unreadNotifications;
                    $count = $unread->count();
                @endphp
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if($count)
                        <span class="badge badge-warning navbar-badge">{{ $count }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ $count }} Notifikasi</span>

                    @forelse($unread->take(5) as $note)
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.notifications.show', $note->id) }}" class="dropdown-item">
                            <i class="fas fa-bell mr-2"></i> {{ \Illuminate\Support\Str::limit($note->data['message'] ?? 'Notifikasi', 60) }}
                            <span class="float-right text-muted text-sm">{{ $note->created_at->diffForHumans() }}</span>
                        </a>
                    @empty
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-item">Tidak ada notifikasi baru</span>
                    @endforelse

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.notifications.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
                </div>
            </li>
            
            <!-- User Account -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <span class="d-none d-md-inline ml-1">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <i class="fas fa-bus brand-image"></i>
            <span class="brand-text font-weight-light">Fleet Management</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white"></i>
                </div>
                <div class="info">
                    <span class="d-block text-white">{{ Auth::user()->name }}</span>
                    <small class="text-muted">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Header -->
                    <li class="nav-header">MANAJEMEN DATA</li>

                    <!-- Manajemen Armada -->
                    <li class="nav-item">
                        <a href="{{ route('admin.armada.index') }}" class="nav-link {{ request()->routeIs('admin.armada.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bus"></i>
                            <p>Manajemen Armada</p>
                        </a>
                    </li>

                    <!-- Manajemen Rute -->
                    <li class="nav-item">
                        <a href="{{ route('admin.rute.index') }}" class="nav-link {{ request()->routeIs('admin.rute.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-route"></i>
                            <p>Manajemen Rute</p>
                        </a>
                    </li>

                    <!-- Manajemen Driver -->
                    <li class="nav-item">
                        <a href="{{ route('admin.driver.index') }}" class="nav-link {{ request()->routeIs('admin.driver.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen Driver</p>
                        </a>
                    </li>

                    <!-- Header -->
                    <li class="nav-header">OPERASIONAL</li>

                    <!-- Tracking Pengiriman -->
                    <li class="nav-item">
                        <a href="{{ route('admin.tracking.index') }}" class="nav-link {{ request()->routeIs('admin.tracking.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shipping-fast"></i>
                            <p>Tracking Pengiriman</p>
                        </a>
                    </li>

                    <!-- Manajemen Gudang -->
                    <li class="nav-item">
                        <a href="{{ route('admin.gudang.index') }}" class="nav-link {{ request()->routeIs('admin.gudang.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Manajemen Gudang</p>
                        </a>
                    </li>

                    <!-- Jadwal Service -->
                    <li class="nav-item">
                        <a href="{{ route('admin.service.index') }}" class="nav-link {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Jadwal Service</p>
                        </a>
                    </li>

                    <!-- Header -->
                    <li class="nav-header">KEUANGAN</li>

                    <!-- Daftar Tarif (Dropdown) -->
                    <li class="nav-item {{ request()->routeIs('admin.tarif.*', 'admin.tarif-per-kg.*', 'admin.diskon.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.tarif.*', 'admin.tarif-per-kg.*', 'admin.diskon.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Manajemen Tarif
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.tarif.index') }}" class="nav-link {{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}">
                                    <i class="fas fa-layer-group nav-icon"></i>
                                    <p>Tarif Layanan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.tarif-per-kg.index') }}" class="nav-link {{ request()->routeIs('admin.tarif-per-kg.*') ? 'active' : '' }}">
                                    <i class="fas fa-weight nav-icon"></i>
                                    <p>Tarif Per Kg</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.diskon.index') }}" class="nav-link {{ request()->routeIs('admin.diskon.*') ? 'active' : '' }}">
                                    <i class="fas fa-tag nav-icon"></i>
                                    <p>Manajemen Diskon</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Header -->
                    <li class="nav-header">LAINNYA</li>

                    @role('Super Admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Manajemen Pengguna</p>
                        </a>
                    </li>
                    @endrole

                    <!-- Lihat Website -->
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>
                                Lihat Website
                                <i class="fas fa-external-link-alt ml-2"></i>
                            </p>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <a href="#" class="nav-link logout-trigger" data-form-id="logout-form-sidebar">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h5><i class="icon fas fa-ban"></i> Terdapat kesalahan!</h5>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
                
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">Fleet Management System</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@yield('js')
@stack('scripts')

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">Apakah Anda yakin ingin keluar dari akun Anda?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirm-logout">Yes</button>
      </div>
    </div>
  </div>
</div>

<script>
    (function(){
        var targetFormId = null;
        $('.logout-trigger').on('click', function(e){
            e.preventDefault();
            targetFormId = $(this).data('form-id');
            $('#logoutModal').modal('show');
        });
        $('#confirm-logout').on('click', function(){
            if (targetFormId) {
                $('#' + targetFormId).submit();
            }
        });
    })();

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
</body>
</html>