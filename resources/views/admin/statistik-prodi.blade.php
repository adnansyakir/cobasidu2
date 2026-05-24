@extends('layouts.app')

@section('title', 'Statistik Prodi - SIDU')
@section('page-title', 'Statistik Prodi')
@section('page-subtitle', 'Statistik pembayaran per program studi')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">📚</div>
            </div>
            <div class="stat-value">12</div>
            <div class="stat-label">Total Prodi</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">🎓</div>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">📊</div>
            </div>
            <div class="stat-value">75%</div>
            <div class="stat-label">Rata-rata Pembayaran</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📈 Statistik Per Prodi</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Sudah Bayar</th>
                        <th>Belum Bayar</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data statistik akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
