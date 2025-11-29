<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pengelola Keuangan Sawit' }} - SawitKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* === SISTEM TEMA (DARK & LIGHT) === */
        :root {
            --bg-body: #F7F9F7;       
            --bg-card: #FFFFFF;       
            --text-main: #1A1A1A;     
            --text-muted: #5B5B5B;    
            --border-color: #EDEDED;
            --input-bg: #ffffff;
            --accent-green: #2E7D32;
            --shadow-color: rgba(0, 0, 0, 0.08);
        }

        [data-theme="dark"] {
            --bg-body: #121212;       
            --bg-card: #1E1E1E;       
            --text-main: #E0E0E0;     
            --text-muted: #A0A0A0;    
            --border-color: #333333;
            --input-bg: #2C2C2C;
            --accent-green: #4CAF50;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Be Vietnam Pro', sans-serif;
            transition: background-color 0.3s, color 0.3s;
            display: flex; flex-direction: column; min-height: 100vh;
        }

        .card, .content-card { background-color: var(--bg-card) !important; color: var(--text-main); border-color: var(--border-color) !important; box-shadow: 0 4px 12px var(--shadow-color) !important; }

        .glass-card {
            background: rgba(255, 255, 255, 0.95) !important; 
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            color: var(--text-main);
        }
        [data-theme="dark"] .glass-card { background: rgba(30, 30, 30, 0.95) !important; border-color: rgba(255, 255, 255, 0.1); }
        
        .text-dark { color: var(--text-main) !important; }
        .text-secondary, .text-muted { color: var(--text-muted) !important; }
        [data-theme="dark"] .bg-white { background-color: var(--bg-card) !important; color: var(--text-main) !important; }

        .navbar { background-color: var(--bg-card); border-bottom: 1px solid var(--border-color); transition: background-color 0.3s; }
        .nav-link { color: var(--text-muted) !important; font-weight: 600; }
        .nav-link:hover, .nav-link.active { color: var(--accent-green) !important; }
        .dropdown-menu { background-color: var(--bg-card); border-color: var(--border-color); }
        .dropdown-item { color: var(--text-main); }
        .dropdown-item:hover { background-color: var(--border-color); }

        .theme-toggle-btn { border: none; background: none; cursor: pointer; font-size: 1.3rem; color: var(--text-main); transition: transform 0.3s; padding: 5px; }
        .theme-toggle-btn:hover { transform: rotate(20deg); }

        .whatsapp-float { position: fixed; width: 60px; height: 60px; bottom: 90px; right: 30px; background-color: #25D366; color: #FFF; border-radius: 50px; text-align: center; font-size: 30px; box-shadow: 2px 2px 3px #999; z-index: 100; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s; }
        .whatsapp-float:hover { color: white; transform: scale(1.1); box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4); }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: var(--accent-green); border-radius: 10px; border: 2px solid var(--bg-body); }
        ::-webkit-scrollbar-thumb:hover { background: #1B5E20; }

        .btn { transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1); font-weight: 600; }
        .btn:active { transform: scale(0.98); }

        @media (max-width: 991px) {
            body { padding-bottom: 80px; } 
            .whatsapp-float { bottom: 100px !important; right: 20px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3 shadow-sm z-3">
        <div class="container">
            
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" 
               href="{{ Auth::check() && Auth::user()->role == 'admin' ? route('admin.dashboard') : (Auth::check() ? route('guest.dashboard') : route('home')) }}">
                <i class="fas fa-seedling fa-lg text-success"></i> SawitKu
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(var(--invert-filter));"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <button class="theme-toggle-btn" id="themeToggle" title="Ganti Mode">
                            <i class="fas fa-sun" id="themeIcon"></i>
                        </button>
                    </li>

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                            <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('guest.dashboard') }}" class="nav-link {{ request()->routeIs('guest.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                            <li class="nav-item"><a href="{{ route('catatan-keuangan.index') }}" class="nav-link {{ request()->routeIs('catatan-keuangan.*') ? 'active' : '' }}">Keuangan</a></li>
                            <li class="nav-item"><a href="{{ route('catatan-keuangan.laporan') }}" class="nav-link {{ request()->routeIs('catatan-keuangan.laporan') ? 'active' : '' }}">Laporan</a></li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-success" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold rounded-3 px-3 py-2">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Masuk</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-success rounded-pill px-4">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
    <nav class="navbar fixed-bottom navbar-light bg-white border-top d-block d-lg-none p-0 shadow-lg z-3" style="padding-bottom: env(safe-area-inset-bottom); background-color: var(--bg-card) !important; border-color: var(--border-color) !important;">
        <div class="container-fluid d-flex justify-content-around py-2">
            
            <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('guest.dashboard') }}" 
               class="text-decoration-none text-center {{ request()->routeIs('*.dashboard') ? 'text-success' : 'text-secondary' }}">
                <i class="fas fa-home fs-4 mb-1"></i>
                <span class="d-block small" style="font-size: 10px;">Home</span>
            </a>

            @if(Auth::user()->role == 'petani')
                <a href="{{ route('catatan-keuangan.index') }}" class="text-decoration-none text-center {{ request()->routeIs('catatan-keuangan.index') ? 'text-success' : 'text-secondary' }}">
                    <i class="fas fa-list-alt fs-4 mb-1"></i>
                    <span class="d-block small" style="font-size: 10px;">Riwayat</span>
                </a>
                <div class="position-relative" style="top: -25px;">
                    <a href="{{ route('catatan-keuangan.create') }}" class="btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center" 
                       style="width: 55px; height: 55px; border: 4px solid var(--bg-body); background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%);">
                        <i class="fas fa-plus text-white fs-4"></i>
                    </a>
                </div>
                <a href="{{ route('catatan-keuangan.laporan') }}" class="text-decoration-none text-center {{ request()->routeIs('catatan-keuangan.laporan') ? 'text-success' : 'text-secondary' }}">
                    <i class="fas fa-chart-pie fs-4 mb-1"></i>
                    <span class="d-block small" style="font-size: 10px;">Laporan</span>
                </a>
            @elseif(Auth::user()->role == 'admin')
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-center {{ request()->routeIs('admin.users.*') ? 'text-success' : 'text-secondary' }}">
                    <i class="fas fa-users fs-4 mb-1"></i>
                    <span class="d-block small" style="font-size: 10px;">Users</span>
                </a>
            @endif

            <a href="#" class="text-decoration-none text-center text-secondary" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                <i class="fas fa-sign-out-alt fs-4 mb-1"></i>
                <span class="d-block small" style="font-size: 10px;">Keluar</span>
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>
    @endauth

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="text-center py-3 border-top bg-white position-relative z-3 mt-auto">
        <small class="text-secondary fw-medium" style="font-size: 13px;">
            &copy; {{ date('Y') }} SawitKu. All rights reserved.
        </small>
    </footer>

    <a href="https://wa.me/6281234567890" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // LOGIKA TEMA
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;
        const navbarToggler = document.querySelector('.navbar-toggler-icon');

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        function applyTheme(theme) {
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-moon';
                htmlElement.style.setProperty('--invert-filter', '1');
            } else {
                themeIcon.className = 'fas fa-sun';
                htmlElement.style.setProperty('--invert-filter', '0');
            }
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
            if(typeof Chart !== 'undefined') location.reload(); 
        });

        // SWEETALERT
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#2E7D32', timer: 3000, timerProgressBar: true });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Oops...', text: "{{ session('error') }}", confirmButtonColor: '#d33' });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin hapus?', text: "Data tidak bisa dikembalikan!", icon: 'warning',
                        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
                    }).then((result) => { if (result.isConfirmed) { form.submit(); } });
                });
            });
        });
    </script>
</body>
</html>