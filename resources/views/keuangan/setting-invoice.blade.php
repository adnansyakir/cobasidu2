@extends('layouts.app')

@section('title', 'Setting Tampil Invoice - SIDU')
@section('page-title', 'Setting Tampil Invoice')
@section('page-subtitle', 'Konfigurasi tampilan invoice mahasiswa')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>🔧 Pengaturan Tampilan Invoice</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <tbody>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600); width: 250px;">Tampilkan Detail UKT</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Tampilkan Rincian Komponen</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Tampilkan Virtual Account</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Tampilkan QR Code Pembayaran</td>
                        <td><span class="badge badge-warning">Non-Aktif</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Header Invoice Custom</td>
                        <td>Politeknik Negeri XYZ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
