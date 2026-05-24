@extends('layouts.app')

@section('title', 'Data Mahasiswa - SIDU')
@section('page-title', 'Data Mahasiswa')
@section('page-subtitle', 'Lihat data mahasiswa terkait keuangan')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>🎓 Daftar Mahasiswa</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        <th>Nilai UKT</th>
                        <th>Status Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data mahasiswa akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
