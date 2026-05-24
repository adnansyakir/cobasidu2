@extends('layouts.app')

@section('title', 'Rentang Besaran UKT - SIDU')
@section('page-title', 'Master Data — Rentang Besaran UKT')
@section('page-subtitle', 'Kelola rentang besaran UKT per prodi')

@section('sidebar-menu')
    @include('keuangan.sidebar')
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h3>💲 Rentang Besaran UKT</h3>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program Studi</th>
                        <th>Kelompok UKT</th>
                        <th>Besaran Minimum</th>
                        <th>Besaran Maksimum</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            Data rentang besaran UKT akan ditampilkan di sini
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
