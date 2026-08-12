<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home') - Fleet Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @yield('css')
    
    <style>
        /* Custom Styles */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background-color: #fff;
        }
        
        main {
            flex: 1;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.35rem 0.6rem;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: #fff !important;
            background-color: rgba(255,255,255,0.18);
            border-radius: 20px;
            padding: 0.4rem 0.9rem;
            box-shadow: inset 0 -2px 0 rgba(0,0,0,0.05);
        }
        
        footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-top: auto;
        }

        /* Hero */
        .hero-section {
            padding: 60px 0 30px;
        }
        .hero-card {
            max-width: 1100px;
            margin: 0 auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 70px 40px;
            border-radius: 6px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            text-align: center;
        }
        .hero-card h1 {
            font-size: 72px;
            line-height: 1.05;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .hero-card p.lead {
            font-size: 18px;
            opacity: 0.95;
        }
        
        /* Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        .card .icon-circle {
            width: 70px;
            height: 70px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            margin-bottom: 18px;
        }
        .card .icon-circle i { font-size: 30px; }

        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #fff;
            transition: all 0.25s ease;
            border-radius: 6px;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            color: #fff;
        }

        /* Stats */
        .bg-light { background: #f8f9fb !important; }
        .stats h3 { font-size: 28px; margin-bottom: 6px; font-weight: 700; }
        .stats h3::after { content: '+'; margin-left: 6px; color: #333; font-weight: 700; }

        /* Footer tweaks */
        footer .social-links a { color: rgba(255,255,255,0.95); }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .hero-card { padding: 40px 20px; }
            .hero-card h1 { font-size: 36px; }
            .card .icon-circle { width: 60px; height: 60px; }
            .card .icon-circle i { font-size: 22px; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-bus"></i> Fleet Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    
                    <!-- Dropdown Layanan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('armada') || request()->is('cek-area-layanan') || request()->is('profil-tim') ? 'active' : '' }}" 
                           href="#" id="layananDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-concierge-bell"></i> Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/armada') }}">
                                    <i class="fas fa-bus text-primary"></i> Info Armada
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/cek-area-layanan') }}">
                                    <i class="fas fa-route text-success"></i> Area Layanan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/profil-tim') }}">
                                    <i class="fas fa-users text-info"></i> Profil Tim
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/lokasi-gudang') }}">
                                    <i class="fas fa-warehouse text-warning"></i> Lokasi Gudang
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Dropdown Tracking -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('cek-resi') || request()->is('cek-ongkir') ? 'active' : '' }}" 
                           href="#" id="trackingDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-search-location"></i> Tracking
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/cek-resi') }}">
                                    <i class="fas fa-shipping-fast text-primary"></i> Cek Resi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/cek-ongkir') }}">
                                    <i class="fas fa-calculator text-success"></i> Cek Ongkir
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('info-perawatan') ? 'active' : '' }}" href="{{ url('/info-perawatan') }}">
                            <i class="fas fa-tools"></i> Info Perawatan
                        </a>
                    </li>
                    
                    @auth
                        @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h5><i class="fas fa-ban"></i> Terdapat kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-white py-5" style="background: linear-gradient(to right, #6a82fb, #fc5c7d);">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h5 class="fw-bold"><i class="fas fa-bus-alt me-2"></i> Fleet Management</h5>
                <p>Solusi terpercaya untuk kebutuhan transportasi dan logistik Anda.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-md-4 mb-4 ms-auto text-end">
                <h5 class="fw-bold">Kontak Kami</h5>
                <ul class="list-unstyled">
                    <li>Jl. Moch. Toha No. 123, Bandung <i class="fas fa-map-marker-alt ms-2"></i></li>
                    <li>+62 812-3456-7890 <i class="fas fa-phone ms-2"></i></li>
                    <li>info@fleetmanagement.com <i class="fas fa-envelope ms-2"></i></li>
                    <li>Senin - Sabtu: 08:00 - 17:00 <i class="fas fa-clock ms-2"></i></li>
                </ul>
            </div>
        </div>

        <hr class="bg-white">

        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0">© 2026 Fleet Management System. All rights reserved.</p>
                <small>Made with by Team 5</small>
            </div>
        </div>
    </div>
</footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('js')

    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>