@extends('layouts.app')

@section('title', 'Setting Banding - SIDU')
@section('page-title', 'Setting Banding')
@section('page-subtitle', 'Konfigurasi pengaturan banding UKT')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>⚙️ Pengaturan Banding UKT</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <tbody>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600); width: 250px;">Periode Banding Aktif</td>
                        <td><span class="badge badge-success">Aktif</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Tanggal Mulai</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Tanggal Selesai</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Maksimal Pengajuan Per Mahasiswa</td>
                        <td>1 kali per semester</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: var(--purple-600);">Dokumen Wajib</td>
                        <td>Surat Keterangan Tidak Mampu, Slip Gaji Orang Tua</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
