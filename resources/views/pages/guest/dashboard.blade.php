@extends('layouts.guest.app')

@section('title', 'Dashboard Petani')

@section('content')

{{-- 1. LOGIKA WAKTU --}}
@php
    date_default_timezone_set('Asia/Jakarta'); 
    $hour = date('H');
    
    if ($hour >= 5 && $hour < 11) { 
        $greeting = 'Selamat Pagi'; $iconGreet = 'fa-cloud-sun';
    } elseif ($hour >= 11 && $hour < 15) { 
        $greeting = 'Selamat Siang'; $iconGreet = 'fa-sun';
    } elseif ($hour >= 15 && $hour < 18) { 
        $greeting = 'Selamat Sore'; $iconGreet = 'fa-cloud-meatball';
    } else { 
        $greeting = 'Selamat Malam'; $iconGreet = 'fa-moon';
    }

    $theme = $_COOKIE['theme'] ?? 'light';
    $chartTextColor = ($theme === 'dark') ? '#FFFFFF' : '#333333';
@endphp

{{-- WRAPPER DASHBOARD --}}
<div class="dashboard-wrapper position-relative overflow-hidden bg-adaptive-body" style="min-height: 100vh;">
    
    <div class="falling-leaves-container">
        @for ($i = 0; $i < 35; $i++) {{-- Jumlah daun ditambah biar ramai --}}
            @php
                // Warna daun disesuaikan dengan gambar referensi (Kuning, Oranye, Hijau Muda)
                $colors = ['#FFC107', '#FF9800', '#8BC34A', '#CDDC39', '#4CAF50']; 
                $randomColor = $colors[array_rand($colors)];
                $leftPos = rand(0, 100); 
                $duration = rand(10, 25); 
                $delay = rand(0, 20);
                $size = rand(20, 45);
            @endphp
            <div class="leaf" style="
                color: {{ $randomColor }}; 
                left: {{ $leftPos }}%; 
                animation-duration: {{ $duration }}s; 
                animation-delay: -{{ $delay }}s; 
                font-size: {{ $size }}px;
                opacity: 0.7; /* Opacity dinaikkan biar jelas */
                text-shadow: 0 2px 5px rgba(0,0,0,0.1);
            ">
                <i class="fas fa-leaf"></i>
            </div>
        @endfor
    </div>

    <div class="container position-relative z-2 py-4">
        
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center mb-5 animate-fade-down glass-card p-4 rounded-5 hover-lift position-relative overflow-hidden shadow-sm">
            <div class="position-absolute top-0 end-0 p-3 opacity-10 pe-none">
                <i class="fas {{ $iconGreet }}" style="font-size: 8rem; color: var(--accent-green); transform: translate(20px, -20px) rotate(10deg);"></i>
            </div>

            <div class="text-center text-lg-start mb-4 mb-lg-0 position-relative z-2">
                <div class="d-inline-flex align-items-center badge bg-success bg-opacity-10 text-success mb-3 rounded-pill px-4 py-2 fw-bold ls-1 shadow-sm border border-success border-opacity-25">
                    <i class="far fa-calendar-alt me-2"></i> {{ date('d F Y') }} • {{ date('H:i') }} WIB
                </div>
                <h1 class="fw-bold text-adaptive-primary mb-2 d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-2 display-6">
                    <span>{{ $greeting }},</span>
                    <span class="text-success position-relative px-2">{{ Str::limit(Auth::user()->name, 15) }}!</span>
                </h1>
                <p class="text-adaptive-secondary mb-0 fs-6 fw-medium">Semoga hasil panen sawit hari ini melimpah ruah.</p>
            </div>
            
            <div class="d-flex gap-2 position-relative z-2">
                <a href="{{ route('catatan-keuangan.create') }}" class="btn btn-lg btn-gradient-success rounded-pill px-5 py-3 shadow-lg fw-bold hover-scale d-flex align-items-center gap-3">
                    <span class="bg-white bg-opacity-25 rounded-circle p-2 d-flex"><i class="fas fa-plus text-white"></i></span>
                    <span>Catat Transaksi</span>
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-8 animate-fade-up" style="animation-delay: 0.1s;">
                <div class="row g-4 h-100">
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-5 overflow-hidden h-100 bg-adaptive-card position-relative hover-lift-sm card-stat">
                            <div class="card-body p-4 position-relative z-2 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="icon-box-md bg-success bg-opacity-10 text-success rounded-4 shadow-sm">
                                        <i class="fas fa-arrow-trend-up fa-lg" style="color: #198754 !important;"></i>
                                    </div>
                                    <h6 class="text-uppercase fw-bold text-secondary ls-1 mb-0">Pemasukan</h6>
                                </div>
                                <h2 class="fw-bolder text-adaptive-primary mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
                            </div>
                            <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 6px;"></div>
                            <i class="fas fa-coins position-absolute top-0 end-0 opacity-10 p-4" style="font-size: 5rem; transform: rotate(-20deg); color: #198754 !important;"></i>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-5 overflow-hidden h-100 bg-adaptive-card position-relative hover-lift-sm card-stat">
                            <div class="card-body p-4 position-relative z-2 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="icon-box-md bg-warning bg-opacity-10 text-warning rounded-4 shadow-sm">
                                        <i class="fas fa-arrow-trend-down fa-lg" style="color: #ffc107 !important;"></i>
                                    </div>
                                    <h6 class="text-uppercase fw-bold text-secondary ls-1 mb-0">Pengeluaran</h6>
                                </div>
                                <h2 class="fw-bolder text-adaptive-primary mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
                            </div>
                            <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 6px;"></div>
                            <i class="fas fa-receipt position-absolute top-0 end-0 opacity-10 p-4" style="font-size: 5rem; transform: rotate(-20deg); color: #ffc107 !important;"></i>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-gradient-dark text-white position-relative p-5 card-balance">
                            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.2) 1px, transparent 0); background-size: 20px 20px;"></div>
                            <div class="position-absolute top-0 end-0 opacity-25 p-4 pe-none">
                                <i class="fas fa-wallet fa-6x" style="transform: rotate(-15deg);"></i>
                            </div>
                            <div class="position-relative z-2">
                                <p class="mb-2 text-white text-opacity-75 text-uppercase ls-2 fw-bold small">Sisa Saldo Saat Ini</p>
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end">
                                    <h1 class="fw-bolder mb-3 mb-md-0 display-4">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h1>
                                     <div class="badge badge-aman-adaptive rounded-pill px-4 py-2 fw-bold d-flex align-items-center shadow-sm">
                                        <i class="fas fa-shield-alt me-2"></i> Keuangan Aman
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 animate-fade-up" style="animation-delay: 0.3s;">
                <div class="card border-0 shadow-sm rounded-5 h-100 glass-card">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold text-adaptive-primary mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Analisis Keuangan</h5>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center position-relative pb-5">
                        @if($totalPemasukan > 0 || $totalPengeluaran > 0)
                            <div class="chart-container position-relative" style="height: 250px; width: 100%;">
                                <canvas id="financialChart"></canvas>
                                <div class="position-absolute top-50 start-50 translate-middle text-center pe-none">
                                     <small class="text-secondary fw-bold d-block">Total Transaksi</small>
                                     <span class="fw-bolder text-adaptive-primary fs-5">{{ $riwayatTerakhir->count() }} Data</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center opacity-50 py-5 animate-bounce-slow">
                                <i class="fas fa-chart-pie fa-5x mb-3 text-secondary"></i>
                                <p class="fw-medium text-adaptive-primary">Belum ada data.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8 animate-fade-up" style="animation-delay: 0.4s;">
                <div class="card border-0 shadow-sm rounded-5 glass-card overflow-hidden mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-adaptive-primary mb-0">
                            <i class="fas fa-history text-success me-2"></i> Aktivitas Terakhir
                        </h5>
                        <a href="{{ route('catatan-keuangan.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-success hover-scale shadow-sm border-0">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline ps-2">
                            @forelse($riwayatTerakhir as $item)
                                <div class="timeline-item pb-4 position-relative z-1">
                                    <div class="timeline-line position-absolute h-100 bg-secondary bg-opacity-25 rounded-pill" style="width: 3px; left: 24px; top: 20px; z-index: -1;"></div>
                                    <div class="d-flex align-items-start">
                                        <div class="timeline-icon flex-shrink-0 me-4 bg-adaptive-card rounded-circle p-1 shadow-sm" style="z-index: 2;">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-inner" 
                                                 style="width: 45px; height: 45px; background: {{ $item->jenis == 'pemasukan' ? '#E8F5E9' : '#FFEBEE' }}; color: {{ $item->jenis == 'pemasukan' ? '#2E7D32' : '#D32F2F' }}">
                                                <i class="fas {{ $item->jenis == 'pemasukan' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 p-3 rounded-4 bg-adaptive-card shadow-sm hover-lift-sm transition-all border border-light card-stat">
                                            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                                                <h6 class="fw-bold text-adaptive-primary mb-0 text-break">{{ $item->deskripsi }}</h6>
                                                <span class="badge rounded-pill px-3 py-2 fw-bold {{ $item->jenis == 'pemasukan' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                                    {{ $item->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-secondary fw-medium">
                                                    <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted animate-bounce-slow">
                                    <i class="fas fa-clipboard-list fa-4x mb-3 opacity-50"></i>
                                    <p class="fw-medium text-adaptive-primary">Belum ada aktivitas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('financialChart');
        if(ctx) {
            const textColor = '{{ $chartTextColor }}';
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        data: [{{ $totalPemasukan }}, {{ $totalPengeluaran }}],
                        backgroundColor: ['#198754', '#ffc107'],
                        borderWidth: 4,
                        borderColor: textColor === '#FFFFFF' ? '#1E1E1E' : '#FFFFFF',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, layout: { padding: 20 },
                    plugins: {
                        legend: { position: 'bottom', labels: { color: textColor, usePointStyle: true, padding: 25, font: { family: "'Be Vietnam Pro', sans-serif", size: 13, weight: '600' } } },
                        tooltip: { displayColors: false }
                    },
                    cutout: '75%',
                    animation: { animateScale: true, animateRotate: true }
                }
            });
        }
    });
</script>

<style>
    /* --- DAUN JATUH (POSITION FIXED & Z-INDEX 0) --- */
    .falling-leaves-container {
        position: fixed; 
        top: 0; left: 0; 
        width: 100%; height: 100%; 
        z-index: 0; /* Di belakang konten (konten z-index 2) */
        pointer-events: none; 
        overflow: hidden;
    }
    
    .leaf {
        position: absolute;
        top: -10%;
        animation: fall linear infinite;
    }

    /* Animasi Daun Jatuh */
    @keyframes fall {
        0% { transform: translateY(-10vh) rotate(0deg); opacity: 0; }
        10% { opacity: 0.8; }
        90% { opacity: 0.8; }
        100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
    }

    /* --- WARNA & TEMA --- */
    :root {
        /* Mode Terang */
        --bg-body: #F7F9F7;
        --card-bg: #FFFFFF;
        --text-primary: #333333; 
        --text-secondary: #6c757d;
        --border-color: #f0f0f0;
        --badge-aman-bg: rgba(25, 135, 84, 0.15);
        --badge-aman-text: #198754;
        --badge-aman-border: rgba(25, 135, 84, 0.3);
    }

    [data-theme="dark"] {
        /* Mode Gelap */
        --bg-body: #121212;
        --card-bg: #1E1E1E;
        --text-primary: #FFFFFF;
        --text-secondary: #B0B3B8;
        --border-color: #2d2d2d;
        --badge-aman-bg: rgba(255, 255, 255, 0.2);
        --badge-aman-text: #FFFFFF;
        --badge-aman-border: rgba(255, 255, 255, 0.25);
    }

    .bg-adaptive-body { background-color: var(--bg-body); transition: background-color 0.3s; }
    .bg-adaptive-card { background-color: var(--card-bg) !important; transition: background-color 0.3s; }
    .text-adaptive-primary { color: var(--text-primary) !important; transition: color 0.3s; }
    .text-adaptive-secondary { color: var(--text-secondary) !important; transition: color 0.3s; }

    .glass-card {
        background: var(--card-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
    }

    .badge-aman-adaptive { background-color: var(--badge-aman-bg); color: var(--badge-aman-text); border: 1px solid var(--badge-aman-border); backdrop-filter: blur(5px); }
    .badge-aman-adaptive i { color: currentColor !important; }

    /* Utils */
    .bg-gradient-dark { background: linear-gradient(135deg, #212121 0%, #424242 100%); }
    .bg-gradient-orange { background: linear-gradient(135deg, #FF6F00 0%, #FF8F00 100%); }
    .btn-gradient-success { background: linear-gradient(90deg, #2E7D32 0%, #66BB6A 100%); border: none; }
    .icon-box-md { width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; }
    .backdrop-blur { backdrop-filter: blur(10px); }
    .hover-lift-sm:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; transition: 0.3s; }
    .hover-scale-sm:hover { transform: scale(1.03); transition: 0.3s; }
    .timeline-item:last-child .timeline-line { display: none; }
    .animate-bounce-slow { animation: bounce-slow 3s infinite ease-in-out; }
    @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
</style>
@endsection