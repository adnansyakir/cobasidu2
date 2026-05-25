@extends('layouts.app')
@section('title', 'Rentang Besaran UKT - SIDU')
@section('page-title', 'Master Data — Rentang Besaran UKT')
@section('page-subtitle', 'Kelola rentang besaran UKT per prodi')
@section('sidebar-menu') @include('keuangan.sidebar') @endsection

@section('styles')
<style>
    .btn-add { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; cursor:pointer; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-2px); }
    .btn-cancel-sm { padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; }
    .btn-submit-sm { padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; }

    /* form tambah */
    .add-panel { background:#fff; border:1px solid var(--border-color); border-radius:16px; padding:24px; margin-bottom:20px; display:none; }
    .add-panel.open { display:block; }
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

    /* tabel konfigurasi di form */
    .config-table { width:100%; border-collapse:collapse; font-size:13px; margin-bottom:16px; }
    .config-table thead th { background:#f5f3ff; color:#6d28d9; font-weight:700; padding:10px 12px; text-align:left; border:1px solid #e9d5ff; }
    .config-table thead th.right { text-align:right; }
    .config-table tbody td { padding:7px 10px; border:1px solid #f3f4f6; vertical-align:middle; }
    .config-table tbody tr:nth-child(even) { background:#fafafa; }
    .config-table .level-badge { display:inline-block; background:#ede9fe; color:#6d28d9; font-weight:700; padding:2px 10px; border-radius:6px; font-size:12px; min-width:44px; text-align:center; }
    .config-table input.form-control { padding:6px 10px; font-size:13px; }
    .info-row { background:#f0fdf4 !important; }
    .ta-badge { display:inline-block; background:#dcfce7; color:#166534; font-size:12px; font-weight:600; padding:2px 8px; border-radius:6px; }

    /* tabel data utama */
    .group-card { margin-bottom:16px; border:1px solid var(--border-color); border-radius:14px; overflow:hidden; }
    .group-header { background:linear-gradient(135deg,#f5f3ff,#ede9fe); padding:12px 18px; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .group-title { font-size:14px; font-weight:700; color:#5b21b6; }
    .group-meta { font-size:12px; color:#7c3aed; }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; font-size:13px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .btn-view { background:#f0fdf4; color:#16a34a; } .btn-view:hover { background:#dcfce7; }
    .action-group { display:flex; gap:5px; }

    /* modal edit baris */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:18px; padding:28px; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,0.15); }
    .modal-title { font-size:17px; font-weight:700; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:18px; }
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#166534;font-size:14px;">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#991b1b;font-size:14px;">❌ {{ session('error') }}</div>
@endif

{{-- Tombol tambah --}}
<div style="display:flex;justify-content:flex-end;margin-bottom:16px;">
    <a class="btn-add" id="btnTambah" href="{{ route('keuangan.master-data.rentang-ukt.create') }}">➕ Tambah Rentang UKT</a>
</div>

{{-- Panel form tambah --}}
<div class="add-panel" id="addPanel">
    <div class="panel-header">
        <h4>💲 Konfigurasi Pembiayaan UKT</h4>
        <button type="button" class="btn-cancel-sm" onclick="togglePanel()">✕ Tutup</button>
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

        {{-- Tabel level UKT --}}
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
            <button type="button" class="btn-cancel-sm" onclick="togglePanel()">Batal</button>
            <button type="submit" class="btn-submit-sm">💾 Simpan Konfigurasi</button>
        </div>
    </form>
</div>

{{-- Data yang sudah ada --}}
<div class="content-card" id="dataSection">
    <div class="content-card-header">
        <h3>💲 Daftar Rentang Besaran UKT</h3>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Program Studi</th>
                    <th>Jurusan</th>
                    <th>Tahun Masuk</th>
                    <th>Tahun Akademik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $groupKey => $rows)
                @php
                    $first  = $rows->first();
                    $no     = $loop->iteration;
                    $detail = $rows->map(fn($r) => [
                        'level_id' => $r->level_ukt_id,
                        'level'    => $r->levelUkt->nama_level ?? '-',
                        'nilai'    => $r->nilai,
                        'akun'     => $r->akun_rekening ?? '-',
                    ])->values()->toJson();
                @endphp
                <tr>
                    <td>{{ $no }}</td>
                    <td style="font-weight:600">{{ $first->prodi->nama_prodi ?? '-' }}</td>
                    <td>{{ $first->prodi->jurusan->nama_jurusan ?? '-' }}</td>
                    <td style="font-weight:600">{{ $first->tahunMasuk->tahun ?? '-' }}</td>
                    <td>{{ $first->tahunMasuk->tahunAkademik->tahun_akademik ?? '-' }}</td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-view"
                                onclick="openView('{{ addslashes($first->prodi->nama_prodi ?? '') }}','{{ addslashes($first->prodi->jurusan->nama_jurusan ?? '') }}','{{ $first->tahunMasuk->tahun ?? '' }}','{{ $first->tahunMasuk->tahunAkademik->tahun_akademik ?? '' }}',{{ $detail }})">👁️</button>
                            <button class="btn-action btn-edit"
                                onclick="openEditPanel({{ $first->prodi_id }},{{ $first->tahun_masuk_id }},{{ $detail }})">✏️</button>
                            <form action="{{ route('keuangan.master-data.rentang-ukt.destroy-group', [$first->prodi_id, $first->tahun_masuk_id]) }}" method="POST" onsubmit="return confirm('Yakin hapus semua konfigurasi UKT untuk prodi dan tahun masuk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data rentang UKT</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal View Detail --}}
<div class="modal-overlay" id="viewModal">
    <div class="modal-box" style="max-width:640px;">
        <div class="modal-title">👁️ Detail Konfigurasi UKT</div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:16px;background:#f5f3ff;border-radius:10px;padding:14px;">
            <div>
                <div style="font-size:11px;font-weight:600;color:#7c3aed;margin-bottom:2px;">PROGRAM STUDI</div>
                <div id="v_prodi" style="font-weight:700;font-size:14px;"></div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#7c3aed;margin-bottom:2px;">JURUSAN</div>
                <div id="v_jurusan" style="font-size:14px;"></div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#7c3aed;margin-bottom:2px;">TAHUN MASUK</div>
                <div id="v_tahun" style="font-weight:700;font-size:14px;"></div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#7c3aed;margin-bottom:2px;">TAHUN AKADEMIK</div>
                <div id="v_ta" style="font-size:14px;"></div>
            </div>
        </div>

        <table class="config-table">
            <thead>
                <tr>
                    <th style="width:40px">No</th>
                    <th style="width:90px">Level</th>
                    <th class="right">Nilai (Rp)</th>
                    <th>Akun Rekening</th>
                </tr>
            </thead>
            <tbody id="v_tbody"></tbody>
        </table>

        <div class="modal-actions">
            <button type="button" class="btn-cancel-sm" onclick="document.getElementById('viewModal').classList.remove('active')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let isEditMode = false;

function togglePanel() {
    const panel = document.getElementById('addPanel');
    const wasOpen = panel.classList.contains('open');
    panel.classList.toggle('open');
    const isOpen = panel.classList.contains('open');
    const btnTambah = document.getElementById('btnTambah');
    btnTambah.textContent = '➕ Tambah Rentang UKT';
    btnTambah.style.display = isOpen ? 'none' : 'inline-flex';
    if (isOpen) {
        document.querySelector('#addPanel h4').textContent = '💲 Konfigurasi Pembiayaan UKT';
    }
    if (wasOpen && !isOpen && isEditMode) {
        const dataSection = document.getElementById('dataSection');
        if (dataSection) dataSection.style.display = '';
        isEditMode = false;
    }
}

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
    // reset tahun masuk info when prodi changes
    document.getElementById('sel_tm').value = '';
    document.getElementById('ta_info').style.display = 'none';
    document.querySelectorAll('[id^="td_tahun_"]').forEach(td => {
        td.innerHTML = '<span style="color:var(--text-muted);font-size:12px">—</span>';
    });
}

function openEditPanel(prodiId, tahunMasukId, rows) {
    isEditMode = true;
    const dataSection = document.getElementById('dataSection');
    if (dataSection) dataSection.style.display = 'none';

    // Set prodi & tahun masuk
    document.getElementById('sel_prodi').value = prodiId;
    document.getElementById('sel_tm').value    = tahunMasukId;

    // Trigger info update
    updateTaInfo();

    // Pre-fill nilai & akun_rekening per level
    rows.forEach(r => {
        const nilaiInput = document.querySelector(`input[name="nilai[${r.level_id}]"]`);
        const akunInput  = document.querySelector(`input[name="akun_rekening[${r.level_id}]"]`);
        if (nilaiInput) nilaiInput.value = r.nilai;
        if (akunInput)  akunInput.value  = (r.akun === '-' ? '' : r.akun);
    });

    // Update panel title to edit mode
    document.querySelector('#addPanel h4').textContent = '✏️ Edit Konfigurasi Pembiayaan UKT';

    // Open panel
    const panel = document.getElementById('addPanel');
    panel.classList.add('open');
    const btnTambah = document.getElementById('btnTambah');
    btnTambah.textContent = '➕ Tambah Rentang UKT';
    btnTambah.style.display = 'none';
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function openView(prodi, jurusan, tahun, ta, rows) {
    document.getElementById('v_prodi').textContent   = prodi;
    document.getElementById('v_jurusan').textContent = jurusan;
    document.getElementById('v_tahun').textContent   = tahun;
    document.getElementById('v_ta').textContent      = ta;

    const tbody = document.getElementById('v_tbody');
    tbody.innerHTML = rows.map((r, i) => `
        <tr>
            <td style="text-align:center;color:#9ca3af">${i + 1}</td>
            <td><span class="level-badge">${r.level}</span></td>
            <td style="text-align:right;font-variant-numeric:tabular-nums;">Rp ${Number(r.nilai).toLocaleString('id-ID')}</td>
            <td style="color:#6b7280">${r.akun}</td>
        </tr>
    `).join('');

    document.getElementById('viewModal').classList.add('active');
}

document.querySelectorAll('.modal-overlay').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('active'); }));
</script>
@endsection