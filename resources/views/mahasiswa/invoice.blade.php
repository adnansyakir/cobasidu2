@extends('layouts.app')

@section('title', 'Invoice Saya - SIDU')
@section('page-title', 'Invoice')
@section('page-subtitle', 'Daftar tagihan pembayaran Anda')

@section('sidebar-menu')
    @include('mahasiswa.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>💰 Invoice Saya</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Semester</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Belum ada invoice yang diterbitkan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
