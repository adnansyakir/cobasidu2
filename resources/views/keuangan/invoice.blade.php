@extends('layouts.app')

@section('title', 'Invoice Keuangan - SIDU')
@section('page-title', 'Invoice')
@section('page-subtitle', 'Kelola invoice pembayaran mahasiswa')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">💰</div>
            </div>
            <div class="stat-value">856</div>
            <div class="stat-label">Total Invoice</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">✅</div>
            </div>
            <div class="stat-value">642</div>
            <div class="stat-label">Lunas</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">⏳</div>
            </div>
            <div class="stat-value">214</div>
            <div class="stat-label">Belum Lunas</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>💰 Daftar Invoice</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Mahasiswa</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data invoice akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
