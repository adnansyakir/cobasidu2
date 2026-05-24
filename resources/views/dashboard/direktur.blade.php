@extends('layouts.app')

@section('title', 'Dashboard Direktur - SIDU')
@section('page-title', 'Dashboard Direktur')
@section('page-subtitle', 'Ringkasan eksekutif sistem daftar ulang')

@section('sidebar-menu')
    @include('direktur.sidebar')
@endsection

@section('content')
    <div class="welcome-banner">
        <span class="welcome-emoji">🏛️</span>
        <h2>Selamat Datang, {{ $user->username }}!</h2>
        <p>Ringkasan eksekutif sistem daftar ulang. Pantau performa dari satu tempat.</p>
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
                <div class="stat-icon blue">💰</div>
                <span class="stat-badge up">+8%</span>
            </div>
            <div class="stat-value">Rp 2.4M</div>
            <div class="stat-label">Total Penerimaan</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">📊</div>
            </div>
            <div class="stat-value">75%</div>
            <div class="stat-label">Tingkat Pembayaran</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">📝</div>
                <span class="stat-badge down">5</span>
            </div>
            <div class="stat-value">14</div>
            <div class="stat-label">Banding Menunggu</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📈 Ringkasan Per Jurusan</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Jurusan</th>
                        <th>Mahasiswa</th>
                        <th>Sudah Bayar</th>
                        <th>Tingkat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Teknik Informatika</td>
                        <td>520</td>
                        <td>412</td>
                        <td><span class="badge badge-success">79%</span></td>
                    </tr>
                    <tr>
                        <td>Teknik Elektro</td>
                        <td>380</td>
                        <td>265</td>
                        <td><span class="badge badge-warning">70%</span></td>
                    </tr>
                    <tr>
                        <td>Manajemen</td>
                        <td>348</td>
                        <td>218</td>
                        <td><span class="badge badge-danger">63%</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
