@extends('layouts.app')

@section('title', 'Statistik Prodi - SIDU')
@section('page-title', 'Statistik Prodi')
@section('page-subtitle', 'Ringkasan statistik per program studi')

@section('sidebar-menu')
    @include('direktur.sidebar')
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
                <span class="stat-badge up">+12%</span>
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
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon amber">💰</div>
            </div>
            <div class="stat-value">Rp 2.4M</div>
            <div class="stat-label">Total Penerimaan</div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h3>📈 Statistik Pembayaran Per Prodi</h3>
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
                        <td>Teknik Informatika</td>
                        <td>342</td>
                        <td>280</td>
                        <td>62</td>
                        <td><span class="badge badge-success">82%</span></td>
                    </tr>
                    <tr>
                        <td>Sistem Informasi</td>
                        <td>298</td>
                        <td>220</td>
                        <td>78</td>
                        <td><span class="badge badge-success">74%</span></td>
                    </tr>
                    <tr>
                        <td>Manajemen Informatika</td>
                        <td>156</td>
                        <td>95</td>
                        <td>61</td>
                        <td><span class="badge badge-warning">61%</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
