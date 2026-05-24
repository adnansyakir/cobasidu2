@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - SIDU')
@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Informasi daftar ulang Anda')

@section('sidebar-menu')
    @include('mahasiswa.sidebar')
@endsection

@section('content')
    <div class="welcome-banner">
        <span class="welcome-emoji">🎓</span>
        <h2>Halo, {{ $mahasiswa->nama_mahasiswa ?? $user->username }}!</h2>
        <p>NPM: <strong>{{ $mahasiswa->npm ?? '-' }}</strong> — Selamat datang di portal daftar ulang mahasiswa.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">🎓</div>
            </div>
            <div class="stat-value">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
            <div class="stat-label">Program Studi</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">📋</div>
            </div>
            <div class="stat-value">{{ $mahasiswa->status_akademik ?? '-' }}</div>
            <div class="stat-label">Status Akademik</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">💰</div>
            </div>
            <div class="stat-value">Rp {{ number_format($mahasiswa->nilai_ukt ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Nilai UKT</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">📄</div>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-label">Invoice Aktif</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>👤 Informasi Pribadi</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <tbody>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600); width: 200px;">Nama Lengkap</td>
                        <td>{{ $mahasiswa->nama_mahasiswa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">NPM</td>
                        <td>{{ $mahasiswa->npm ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Jenis Kelamin</td>
                        <td>{{ ($mahasiswa->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Program Studi</td>
                        <td>{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Status Akademik</td>
                        <td>
                            <span class="badge badge-success">{{ $mahasiswa->status_akademik ?? '-' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
