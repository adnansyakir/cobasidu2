@extends('layouts.app')

@section('title', 'Dashboard Admin - SIDU')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Kelola sistem daftar ulang')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('content')
    <div class="welcome-banner">
        <span class="welcome-emoji">👋</span>
        <h2>Selamat Datang, {{ $user->username }}!</h2>
        <p>Anda masuk sebagai <strong>Administrator</strong>. Kelola seluruh sistem daftar ulang dari sini.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">🎓</div>
                <span class="stat-badge up">+12%</span>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">📄</div>
                <span class="stat-badge up">+8%</span>
            </div>
            <div class="stat-value">856</div>
            <div class="stat-label">Invoice Terbit</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">✅</div>
                <span class="stat-badge up">+15%</span>
            </div>
            <div class="stat-value">642</div>
            <div class="stat-label">Sudah Bayar</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">📝</div>
                <span class="stat-badge down">3</span>
            </div>
            <div class="stat-value">14</div>
            <div class="stat-label">Pengajuan Banding</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📋 Aktivitas Terbaru</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aktivitas</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hari ini, 09:15</td>
                        <td>Login ke sistem</td>
                        <td>{{ $user->username }}</td>
                        <td><span class="badge badge-success">Berhasil</span></td>
                    </tr>
                    <tr>
                        <td>Kemarin, 14:30</td>
                        <td>Import data mahasiswa</td>
                        <td>admin</td>
                        <td><span class="badge badge-success">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>Kemarin, 10:00</td>
                        <td>Generate invoice semester</td>
                        <td>keuangan</td>
                        <td><span class="badge badge-info">Diproses</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
