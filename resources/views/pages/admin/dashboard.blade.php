@extends('layouts.guest.app')

@section('title', 'Admin Command Center')

@section('content')

@php
    date_default_timezone_set('Asia/Jakarta'); 
    $hour = date('H');
    if ($hour >= 5 && $hour < 11) { $greeting = 'Selamat Pagi'; }
    elseif ($hour >= 11 && $hour < 15) { $greeting = 'Selamat Siang'; }
    elseif ($hour >= 15 && $hour < 18) { $greeting = 'Selamat Sore'; }
    else { $greeting = 'Selamat Malam'; }
@endphp

<div class="admin-container container-fluid px-4 py-5" style="min-height: 100vh; background-color: #0f172a;">
    
    <div class="d-flex justify-content-between align-items-end mb-5 animate-fade-down">
        <div>
            <div class="badge bg-gold mb-2 text-dark fw-bold px-3 py-2 rounded-pill"><i class="fas fa-crown me-2"></i> ADMINISTRATOR</div>
            <h1 class="text-white fw-bold display-6">{{ $greeting }}, <span class="text-gold">{{ Auth::user()->name }}</span></h1>
            <p class="text-muted mb-0">Ringkasan ekosistem SawitKu secara real-time.</p>
        </div>
        <div class="text-end text-white">
            <h2 class="fw-bold mb-0">{{ date('H:i') }} <small class="fs-6 fw-normal">WIB</small></h2>
            <small class="text-success"><i class="fas fa-circle fa-xs me-1 blink"></i> System Online</small>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-green-soft text-green rounded-circle me-3"><i class="fas fa-users"></i></div>
                    <div><h6 class="text-muted text-uppercase small fw-bold mb-1">Total Petani</h6><h3 class="text-white fw-bold mb-0">{{ $totalPetani }}</h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-up" style="animation-delay: 0.2s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-blue-soft text-blue rounded-circle me-3"><i class="fas fa-handshake"></i></div>
                    <div><h6 class="text-muted text-uppercase small fw-bold mb-1">Total Mitra</h6><h3 class="text-white fw-bold mb-0">{{ $totalMitra }}</h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-up" style="animation-delay: 0.3s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-purple-soft text-purple rounded-circle me-3"><i class="fas fa-calendar-alt"></i></div>
                    <div><h6 class="text-muted text-uppercase small fw-bold mb-1">Total Event</h6><h3 class="text-white fw-bold mb-0">{{ $totalEvent }}</h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 animate-fade-up" style="animation-delay: 0.4s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-orange-soft text-orange rounded-circle me-3"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div><h6 class="text-muted text-uppercase small fw-bold mb-1">Total Transaksi</h6><h3 class="text-white fw-bold mb-0">{{ $totalCatatan }}</h3></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 animate-fade-up" style="animation-delay: 0.5s;">
            <div class="card bg-dark-glass border-0 p-4 position-relative overflow-hidden">
                <div class="position-relative z-2">
                    <p class="text-muted text-uppercase small fw-bold mb-2">Total Pemasukan (All Petani)</p>
                    <h2 class="text-success fw-bolder display-5 mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
                </div>
                <i class="fas fa-chart-line position-absolute bottom-0 end-0 text-success opacity-10 display-1 me-4 mb-2"></i>
            </div>
        </div>
        <div class="col-md-6 animate-fade-up" style="animation-delay: 0.6s;">
            <div class="card bg-dark-glass border-0 p-4 position-relative overflow-hidden">
                <div class="position-relative z-2">
                    <p class="text-muted text-uppercase small fw-bold mb-2">Total Pengeluaran (All Petani)</p>
                    <h2 class="text-danger fw-bolder display-5 mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
                </div>
                <i class="fas fa-hand-holding-usd position-absolute bottom-0 end-0 text-danger opacity-10 display-1 me-4 mb-2"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7 animate-fade-up" style="animation-delay: 0.7s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-header bg-transparent border-bottom border-secondary py-3"><h5 class="text-white fw-bold mb-0"><i class="fas fa-exchange-alt me-2 text-gold"></i> Transaksi Petani Terbaru</h5></div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle" style="background: transparent;">
                        <thead class="text-muted small text-uppercase"><tr><th class="ps-4">Petani</th><th>Keterangan</th><th>Jenis</th><th class="text-end pe-4">Nominal</th></tr></thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $item)
                                <tr>
                                    <td class="ps-4"><span class="d-block fw-bold text-white small">{{ $item->user->name }}</span></td>
                                    <td class="text-light small">{{ Str::limit($item->deskripsi, 20) }}</td>
                                    <td><span class="badge rounded-pill {{ $item->jenis == 'pemasukan' ? 'bg-success bg-opacity-25 text-success' : 'bg-danger bg-opacity-25 text-danger' }}">{{ ucfirst($item->jenis) }}</span></td>
                                    <td class="text-end pe-4 fw-bold {{ $item->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5 animate-fade-up" style="animation-delay: 0.8s;">
            <div class="card bg-dark-glass border-0 h-100">
                <div class="card-header bg-transparent border-bottom border-secondary py-3"><h5 class="text-white fw-bold mb-0"><i class="fas fa-calendar-check me-2 text-blue"></i> Event Mitra Terbaru</h5></div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($eventTerbaru as $event)
                            <div class="list-group-item bg-transparent border-bottom border-secondary text-white py-3 px-4">
                                <h6 class="mb-0 fw-bold text-gold">{{ $event->nama_event }}</h6>
                                <div class="d-flex justify-content-between align-items-center mt-2"><small class="text-muted"><i class="fas fa-user me-1"></i> {{ $event->user->name }}</small><span class="badge bg-info bg-opacity-25 text-info rounded-pill">{{ $event->status }}</span></div>
                            </div>
                        @empty <div class="text-center py-5 text-muted"><p>Belum ada event.</p></div> @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dark-glass { background-color: #1e293b; border: 1px solid #334155 !important; border-radius: 16px; }
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .bg-green-soft { background: rgba(16, 185, 129, 0.2); } .text-green { color: #34d399; }
    .bg-blue-soft { background: rgba(59, 130, 246, 0.2); } .text-blue { color: #60a5fa; }
    .bg-purple-soft { background: rgba(139, 92, 246, 0.2); } .text-purple { color: #a78bfa; }
    .bg-orange-soft { background: rgba(249, 115, 22, 0.2); } .text-orange { color: #fb923c; }
    .bg-gold { background: #f59e0b; } .text-gold { color: #fbbf24; }
    .table-dark { --bs-table-bg: transparent; --bs-table-hover-bg: rgba(255,255,255,0.05); border-color: #334155; }
    .blink { animation: blink 1s infinite; } @keyframes blink { 50% { opacity: 0; } }
    .animate-fade-down { animation: fadeInDown 0.8s forwards; } .animate-fade-up { animation: fadeInUp 0.8s forwards; opacity: 0; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection