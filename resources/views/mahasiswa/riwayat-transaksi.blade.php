@extends('layouts.app')

@section('title', 'Riwayat Transaksi - SIDU')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Histori pembayaran Anda')

@section('sidebar-menu')
    @include('mahasiswa.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>💳 Riwayat Transaksi</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Belum ada riwayat transaksi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
