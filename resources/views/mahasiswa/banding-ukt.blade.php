@extends('layouts.app')

@section('title', 'Banding UKT - SIDU')
@section('page-title', 'Banding UKT')
@section('page-subtitle', 'Ajukan banding UKT Anda')

@section('sidebar-menu')
    @include('mahasiswa.sidebar')
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">💰</div>
            </div>
            <div class="stat-value">Rp {{ number_format(Auth::user()->mahasiswa->nilai_ukt ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">UKT Saat Ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">📝</div>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-label">Pengajuan Aktif</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📝 Riwayat Pengajuan Banding</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>UKT Saat Ini</th>
                        <th>UKT Diajukan</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Belum ada pengajuan banding UKT
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
