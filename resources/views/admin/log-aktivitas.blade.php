@extends('layouts.app')

@section('title', 'Log Aktivitas - SIDU')
@section('page-title', 'Log Aktivitas')
@section('page-subtitle', 'Riwayat aktivitas pengguna sistem')

@section('sidebar-menu')
    @include('admin.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>📋 Log Aktivitas Terbaru</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data log aktivitas akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
