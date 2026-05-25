keuanganmhs.txt
@extends('layouts.app')
@section('title', 'Data Mahasiswa - SIDU')
@section('page-title', 'Data Mahasiswa')
@section('page-subtitle', 'Lihat data mahasiswa terkait keuangan')
@section('sidebar-menu') @include('keuangan.sidebar') @endsection

@section('styles')
<style>
    .stats-row { display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap; }
    .mini-stat { display:flex; align-items:center; gap:10px; padding:12px 18px; background:var(--purple-50); border:1px solid var(--purple-100); border-radius:12px; flex:1; min-width:150px; }
    .mini-stat .mini-stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
    .mini-stat .mini-stat-icon.purple { background:var(--purple-100); }
    .mini-stat .mini-stat-icon.blue { background:#dbeafe; }
    .mini-stat .mini-stat-icon.green { background:#dcfce7; }
    .mini-stat .mini-stat-icon.amber { background:#fef3c7; }
    .mini-stat .mini-stat-info h4 { font-size:18px; font-weight:700; color:var(--text-primary); }
    .mini-stat .mini-stat-info span { font-size:11px; color:var(--text-muted); }
    .crud-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .search-box { display:flex; align-items:center; gap:8px; }
    .search-input { padding:9px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; outline:none; width:240px; transition:all 0.2s; }
    .search-input:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    .mhs-cell { display:flex; align-items:center; gap:10px; }
    .mhs-cell .avatar-sm { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--purple-400),var(--purple-500)); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0; }
</style>
@endsection

@section('content')

<div class="stats-row">
    <div class="mini-stat">
        <div class="mini-stat-icon purple">🎓</div>
        <div class="mini-stat-info">
            <h4>{{ $data->count() }}</h4>
            <span>Total Mahasiswa</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon green">✅</div>
        <div class="mini-stat-info">
            <h4>{{ $data->where('status_akademik', 'Aktif')->count() }}</h4>
            <span>Mahasiswa Aktif</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon blue">📚</div>
        <div class="mini-stat-info">
            <h4>{{ $data->pluck('prodi_id')->unique()->count() }}</h4>
            <span>Program Studi</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon amber">💰</div>
        <div class="mini-stat-info">
            <h4>Rp {{ number_format($data->sum('nilai_ukt'), 0, ',', '.') }}</h4>
            <span>Total Nilai UKT</span>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>🎓 Daftar Mahasiswa</h3>
        <div class="search-box">
            <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari nama / NPM...">
        </div>
    </div>
    <div class="table-container">
        <table class="data-table" id="mahasiswaTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>NPM</th>
                    <th>Prodi</th>
                    <th>Status Akademik</th>
                    <th>Nilai UKT</th>
                    <th>Status Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="mhs-cell">
                            <div class="avatar-sm">{{ strtoupper(substr($item->nama_mahasiswa, 0, 2)) }}</div>
                            <div>
                                <strong>{{ $item->nama_mahasiswa }}</strong>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-info">{{ $item->npm }}</span></td>
                    <td>
                        {{ $item->prodi?->nama_prodi ?? '-' }}<br>
                        <span style="font-size:11px;color:var(--text-muted)">{{ $item->prodi?->jurusan?->nama_jurusan ?? '' }}</span>
                    </td>
                    <td>
                        @if($item->status_akademik === 'Aktif')
                            <span class="badge badge-success">✅ Aktif</span>
                        @elseif($item->status_akademik === 'Cuti')
                            <span class="badge badge-warning">⏸️ Cuti</span>
                        @elseif($item->status_akademik === 'Lulus')
                            <span class="badge" style="background:#eff6ff;color:#2563eb;">🎓 Lulus</span>
                        @else
                            <span class="badge badge-danger">{{ $item->status_akademik }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($item->nilai_ukt, 0, ',', '.') }}</td>
                    <td><span class="badge" style="background:#fef3c7;color:#92400e;">⏳ IDLE</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">
                        Belum ada data mahasiswa
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#mahasiswaTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection