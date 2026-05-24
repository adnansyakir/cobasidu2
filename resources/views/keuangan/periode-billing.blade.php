@extends('layouts.app')

@section('title', 'Periode dan Billing - SIDU')
@section('page-title', 'Periode dan Billing')
@section('page-subtitle', 'Kelola periode pembayaran dan billing')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>📅 Daftar Periode Billing</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Akademik</th>
                        <th>Semester</th>
                        <th>Periode Mulai</th>
                        <th>Periode Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data periode billing akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
