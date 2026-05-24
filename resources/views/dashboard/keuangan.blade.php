@extends('layouts.app')

@section('title', 'Dashboard Keuangan - SIDU')
@section('page-title', 'Dashboard Keuangan')
@section('page-subtitle', 'Kelola keuangan & pembayaran')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="welcome-banner">
        <span class="welcome-emoji">💰</span>
        <h2>Selamat Datang, {{ $user->username }}!</h2>
        <p>Panel keuangan untuk mengelola invoice dan pembayaran mahasiswa.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">💰</div>
                <span class="stat-badge up">+5%</span>
            </div>
            <div class="stat-value">Rp 2.4M</div>
            <div class="stat-label">Total Pendapatan UKT</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">📄</div>
            </div>
            <div class="stat-value">856</div>
            <div class="stat-label">Invoice Diterbitkan</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">✅</div>
            </div>
            <div class="stat-value">642</div>
            <div class="stat-label">Sudah Lunas</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">⏳</div>
            </div>
            <div class="stat-value">214</div>
            <div class="stat-label">Belum Bayar</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>💳 Pembayaran Terbaru</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Mahasiswa</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>INV-2026-001</td>
                        <td>Ahmad Fauzi</td>
                        <td>Rp 3.500.000</td>
                        <td><span class="badge badge-success">Lunas</span></td>
                    </tr>
                    <tr>
                        <td>INV-2026-002</td>
                        <td>Siti Aisyah</td>
                        <td>Rp 4.200.000</td>
                        <td><span class="badge badge-warning">Menunggu</span></td>
                    </tr>
                    <tr>
                        <td>INV-2026-003</td>
                        <td>Budi Santoso</td>
                        <td>Rp 3.800.000</td>
                        <td><span class="badge badge-danger">Jatuh Tempo</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
