@extends('layouts.app')

@section('title', 'Banding UKT - SIDU')
@section('page-title', 'Banding UKT')
@section('page-subtitle', 'Kelola pengajuan banding UKT mahasiswa')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">📝</div>
            </div>
            <div class="stat-value">14</div>
            <div class="stat-label">Menunggu Review</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">✅</div>
            </div>
            <div class="stat-value">28</div>
            <div class="stat-label">Disetujui</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">❌</div>
            </div>
            <div class="stat-value">5</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📝 Daftar Pengajuan Banding UKT</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>UKT Saat Ini</th>
                        <th>UKT Diajukan</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data banding UKT akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
