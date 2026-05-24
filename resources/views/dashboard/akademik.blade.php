@extends('layouts.app')

@section('title', 'Dashboard Akademik - SIDU')
@section('page-title', 'Dashboard Akademik')
@section('page-subtitle', 'Kelola data akademik mahasiswa')

@section('sidebar-menu')
    @include('akademik.sidebar')
@endsection

@section('content')
    <div class="welcome-banner">
        <span class="welcome-emoji">📚</span>
        <h2>Selamat Datang, {{ $user->username }}!</h2>
        <p>Panel akademik untuk mengelola data mahasiswa dan program studi.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">🎓</div>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-label">Total Mahasiswa Aktif</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">📚</div>
            </div>
            <div class="stat-value">12</div>
            <div class="stat-label">Program Studi</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">🏛️</div>
            </div>
            <div class="stat-value">4</div>
            <div class="stat-label">Jurusan</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">📝</div>
            </div>
            <div class="stat-value">320</div>
            <div class="stat-label">Mahasiswa Baru</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>🎓 Mahasiswa Per Prodi</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        <th>Jenjang</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Teknik Informatika</td>
                        <td>S1</td>
                        <td>342</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td>Sistem Informasi</td>
                        <td>S1</td>
                        <td>298</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td>Manajemen Informatika</td>
                        <td>D3</td>
                        <td>156</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
