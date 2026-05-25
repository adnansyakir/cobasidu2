@extends('layouts.app')
@section('title', 'Tambah Rentang Besaran UKT - SIDU')
@section('page-title', 'Master Data — Rentang Besaran UKT')
@section('page-subtitle', 'Tambah rentang besaran UKT')
@section('sidebar-menu') @include('keuangan.sidebar') @endsection

@section('styles')
<style>
    .btn-cancel-sm { padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
    .btn-submit-sm { padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; }

    .add-panel { background:#fff; border:1px solid var(--border-color); border-radius:16px; padding:24px; margin-bottom:20px; }
    .panel-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
    .panel-header h4 { font-size:16px; font-weight:700; margin:0; }
    .header-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px; }
    .tm-row { display:flex; align-items:center; gap:10px; }
    .tm-row .form-control { flex:1; }
    .tm-row #ta_info { display:none; margin:0; }
    .form-group label { display:block; font-size:12px; font-weight:600; color:var(--text-secondary); margin-bottom:5px; }
    .form-control { width:100%; padding:9px 13px; border:1px solid var(--border-color); border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; box-sizing:border-box; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    select.form-control { appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 12px center; padding-right:32px; }

    .config-table { width:100%; border-collapse:collapse; font-size:13px; margin-bottom:16px; }
    .config-table thead th { background:#f5f3ff; color:#6d28d9; font-weight:700; padding:10px 12px; text-align:left; border:1px solid #e9d5ff; }
    .config-table thead th.right { text-align:right; }
    .config-table tbody td { padding:7px 10px; border:1px solid #f3f4f6; vertical-align:middle; }
    .config-table tbody tr:nth-child(even) { background:#fafafa; }
    .config-table .level-badge { display:inline-block; background:#ede9fe; color:#6d28d9; font-weight:700; padding:2px 10px; border-radius:6px; font-size:12px; min-width:44px; text-align:center; }
    .config-table input.form-control { padding:6px 10px; font-size:13px; }
    .ta-badge { display:inline-block; background:#dcfce7; color:#166534; font-size:12px; font-weight:600; padding:2px 8px; border-radius:6px; }
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#166534;font-size:14px;">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#991b1b;font-size:14px;">❌ {{ session('error') }}</div>
@endif

<div class="add-panel" id="addPanel">
    <div class="panel-header">
        <h4>💲 Konfigurasi Pembiayaan UKT</h4>
    </div>

    <form action="{{ route('keuangan.master-data.rentang-ukt.store') }}" method="POST">@csrf
        <div class="header-grid">
            <div class="form-group">
                <label>Program Studi *</label>
                <select name="prodi_id" id="sel_prodi" class="form-control" required onchange="updateTmOptions()">
                    <option value="">— Pilih Prodi —</option>
                    @foreach($prodiList as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tahun Masuk *</label>
                <div class="tm-row">
                    <select name="tahun_masuk_id" id="sel_tm" class="form-control" required onchange="updateTaInfo()">
                        <option value="">— Pilih Tahun Masuk —</option>
                        @foreach($tahunMasukList as $tm)
                        <option value="{{ $tm->id }}" data-ta="{{ $tm->tahunAkademik->tahun_akademik ?? '-' }}">
                            {{ $tm->tahun }}
                        </option>
                        @endforeach
                    </select>
                    <div id="ta_info">
                        <span style="font-size:12px;color:var(--text-secondary);font-weight:600;">Tahun Akademik:</span>
                        <span class="ta-badge" id="ta_badge">-</span>
                    </div>
                </div>
            </div>
        </div>

        <table class="config-table">
            <thead>
                <tr>
                    <th style="width:40px">No</th>
                    <th style="width:140px">Tahun Anggaran /<br>Angkatan</th>
                    <th style="width:90px">Level</th>
                    <th class="right">Nilai (Rp)</th>
                    <th>Akun Rekening</th>
                </tr>
            </thead>
            <tbody>
                @foreach($levelUktList as $i => $level)
                <tr>
                    <td style="text-align:center;color:var(--text-muted)">{{ $i + 1 }}</td>
                    <td style="text-align:center;" id="td_tahun_{{ $loop->index }}">
                        <span style="color:var(--text-muted);font-size:12px">—</span>
                    </td>
                    <td><span class="level-badge">{{ $level->nama_level }}</span></td>
                    <td>
                        <input type="number" name="nilai[{{ $level->id }}]" class="form-control" min="0" value="0" style="text-align:right;">
                    </td>
                    <td>
                        <input type="text" name="akun_rekening[{{ $level->id }}]" class="form-control" placeholder="mis. Pembayaran UKT">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display:flex;justify-content:flex-end;gap:10px;">
            <a class="btn-cancel-sm" href="{{ route('keuangan.master-data.rentang-ukt') }}">Batal</a>
            <button type="submit" class="btn-submit-sm">💾 Simpan Konfigurasi</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function updateTaInfo() {
    const sel = document.getElementById('sel_tm');
    const opt = sel.options[sel.selectedIndex];
    const ta  = opt ? opt.dataset.ta : '';
    const tahun = opt ? opt.text.trim() : '—';

    document.querySelectorAll('[id^="td_tahun_"]').forEach(td => {
        td.innerHTML = sel.value ? `<strong>${tahun}</strong>` : '<span style="color:var(--text-muted);font-size:12px">—</span>';
    });

    const info = document.getElementById('ta_info');
    if (sel.value && ta) {
        document.getElementById('ta_badge').textContent = ta;
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function updateTmOptions() {
    document.getElementById('sel_tm').value = '';
    document.getElementById('ta_info').style.display = 'none';
    document.querySelectorAll('[id^="td_tahun_"]').forEach(td => {
        td.innerHTML = '<span style="color:var(--text-muted);font-size:12px">—</span>';
    });
}
</script>
@endsection
