@extends('layouts.guest.app')

@section('title', 'Manajemen User - Admin')

@section('content')
<div class="admin-wrapper" style="min-height: 100vh; background-color: #0f172a;">
    
    <div class="container-fluid px-4 py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-down">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none small mb-2 d-block">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h2 class="text-white fw-bold mb-0">Manajemen Pengguna</h2>
                <p class="text-gray-400 mb-0">Kelola data Petani, Mitra, dan Administrator.</p>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-gold-gradient rounded-pill px-4 fw-bold shadow-gold">
                    <i class="fas fa-plus me-2"></i> Tambah User Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-25 text-success border-0 rounded-4 mb-4 animate-fade-up">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card bg-dark-glass border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle" style="background: transparent;">
                    <thead class="text-gray-400 text-uppercase small fw-bold" style="background: rgba(255,255,255,0.05);">
                        <tr>
                            <th class="py-4 ps-4">Pengguna</th>
                            <th class="py-4">Role (Peran)</th>
                            <th class="py-4">Status</th>
                            <th class="py-4">Bergabung</th>
                            <th class="py-4 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 fw-bold text-dark" 
                                         style="background: {{ $user->role == 'admin' ? 'linear-gradient(135deg, #FFD700, #FF8C00)' : ($user->role == 'mitra' ? 'linear-gradient(135deg, #4FC3F7, #0288D1)' : 'linear-gradient(135deg, #66BB6A, #2E7D32)') }}">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-white">{{ $user->name }}</span>
                                        <small class="text-gray-400">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-warning text-dark border border-warning border-opacity-50 rounded-pill px-3">
                                        <i class="fas fa-crown me-1"></i> Administrator
                                    </span>
                                @elseif($user->role == 'mitra')
                                    <span class="badge bg-info bg-opacity-20 text-info border border-info border-opacity-25 rounded-pill px-3">
                                        <i class="fas fa-handshake me-1"></i> Mitra Sawit
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-25 rounded-pill px-3">
                                        <i class="fas fa-seedling me-1"></i> Petani
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'aktif')
                                    <span class="text-success small fw-bold"><i class="fas fa-circle fa-xs me-1"></i> Aktif</span>
                                @else
                                    <span class="text-danger small fw-bold"><i class="fas fa-circle fa-xs me-1"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-gray-400 small">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-light rounded-circle" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle delete-confirm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- ADMIN TABLE STYLES --- */
    .bg-dark-glass {
        background-color: #1e293b;
        border: 1px solid #334155;
    }
    .table-dark {
        --bs-table-bg: transparent;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
        border-color: #334155;
    }
    
    /* Avatar warna-warni sesuai role */
    .avatar-circle {
        width: 40px; height: 40px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }

    .text-gray-400 { color: #94a3b8 !important; }
    
    /* Tombol Emas */
    .btn-gold-gradient {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none; color: #fff;
        transition: all 0.3s;
    }
    .btn-gold-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* Animasi Masuk */
    .animate-fade-down { animation: fadeDown 0.8s forwards; }
    .animate-fade-up { animation: fadeUp 0.8s forwards; opacity: 0; }
    @keyframes fadeDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection