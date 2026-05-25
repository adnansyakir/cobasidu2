@extends('layouts.app')
@section('title', 'Periode dan Billing - SIDU')
@section('page-title', 'Periode dan Billing')
@section('page-subtitle', 'Kelola periode pembayaran dan billing')
@section('sidebar-menu') @include('keuangan.sidebar') @endsection

@section('styles')
<style>
    .crud-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .btn-add { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; cursor:pointer; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-2px); }
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:18px; padding:28px; width:100%; max-width:500px; box-shadow:0 20px 60px rgba(0,0,0,0.15); animation:fadeInUp 0.3s ease; }
    .modal-title { font-size:18px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:20px; }
    .btn-cancel { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; }
    .btn-submit { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:13px; font-weight:600; color:var(--text-secondary); margin-bottom:6px; }
    .form-control { width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; box-sizing:border-box; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    select.form-control { appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 14px center; padding-right:36px; }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:14px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .action-group { display:flex; gap:6px; align-items:center; }
    .toggle-wrap { display:inline-flex; align-items:center; gap:8px; }
    .toggle { position:relative; width:44px; height:24px; flex-shrink:0; }
    .toggle input { opacity:0; width:0; height:0; }
    .toggle-slider { position:absolute; inset:0; background:#d1d5db; border-radius:24px; cursor:pointer; transition:.25s; }
    .toggle-slider:before { content:''; position:absolute; width:18px; height:18px; left:3px; top:3px; background:#fff; border-radius:50%; transition:.25s; }
    .toggle input:checked + .toggle-slider { background:#22c55e; }
    .toggle input:checked + .toggle-slider:before { transform:translateX(20px); }
    .toggle-label { font-size:12px; font-weight:600; min-width:60px; }
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#166534;font-size:14px;">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#991b1b;font-size:14px;">❌ {{ session('error') }}</div>
@endif

<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>📅 Daftar Periode Billing</h3>
        <button class="btn-add" onclick="document.getElementById('addModal').classList.add('active')">➕ Tambah</button>
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
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600">{{ $item->tahunAkademik->tahun_akademik ?? '-' }}</td>
                    <td>{{ $item->tahunAkademik->semester ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->periode_mulai)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->periode_selesai)->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('keuangan.periode-billing.toggle', $item->id) }}" method="POST" style="display:inline">
                            @csrf @method('PATCH')
                            <div class="toggle-wrap">
                                <label class="toggle" title="Klik untuk ubah status">
                                    <input type="checkbox" {{ $item->status === 'Aktif' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="toggle-label" style="color:{{ $item->status === 'Aktif' ? '#16a34a' : '#dc2626' }}">
                                    {{ $item->status }}
                                </span>
                            </div>
                        </form>
                    </td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-edit"
                                onclick="openEdit({{ $item->id }},{{ $item->tahun_akademik_id }},'{{ $item->tahunAkademik->tahun_akademik ?? '' }}','{{ $item->tahunAkademik->semester ?? '' }}','{{ $item->periode_mulai }}','{{ $item->periode_selesai }}')">✏️</button>
                            <form action="{{ route('keuangan.periode-billing.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus periode ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data periode billing</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="addModal"><div class="modal-box">
    <div class="modal-title">📅 Tambah Periode Billing</div>
    <form action="{{ route('keuangan.periode-billing.store') }}" method="POST" onsubmit="return syncTaId('a_ta_id','a_tahun','a_semester')">@csrf
        <input type="hidden" name="tahun_akademik_id" id="a_ta_id">
        <div class="form-group">
            <label>Tahun Akademik *</label>
            <select id="a_tahun" class="form-control" onchange="syncTaId('a_ta_id','a_tahun','a_semester')" required>
                <option value="">— Pilih Tahun —</option>
                @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semester *</label>
            <select id="a_semester" class="form-control" onchange="syncTaId('a_ta_id','a_tahun','a_semester')" required>
                <option value="">— Pilih Semester —</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>
        <div class="form-group">
            <label>Periode Mulai *</label>
            <input type="date" name="periode_mulai" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Periode Selesai *</label>
            <input type="date" name="periode_selesai" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status *</label>
            <select name="status" class="form-control" required>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="document.getElementById('addModal').classList.remove('active')">Batal</button>
            <button type="submit" class="btn-submit">💾 Simpan</button>
        </div>
    </form>
</div></div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="editModal"><div class="modal-box">
    <div class="modal-title">✏️ Edit Periode Billing</div>
    <form id="editForm" method="POST" onsubmit="return syncTaId('e_ta_id','e_tahun','e_semester')">@csrf @method('PUT')
        <input type="hidden" name="tahun_akademik_id" id="e_ta_id">
        <div class="form-group">
            <label>Tahun Akademik *</label>
            <select id="e_tahun" class="form-control" onchange="syncTaId('e_ta_id','e_tahun','e_semester')" required>
                <option value="">— Pilih Tahun —</option>
                @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semester *</label>
            <select id="e_semester" class="form-control" onchange="syncTaId('e_ta_id','e_tahun','e_semester')" required>
                <option value="">— Pilih Semester —</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>
        <div class="form-group">
            <label>Periode Mulai *</label>
            <input type="date" name="periode_mulai" id="e_mulai" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Periode Selesai *</label>
            <input type="date" name="periode_selesai" id="e_selesai" class="form-control" required>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('active')">Batal</button>
            <button type="submit" class="btn-submit">💾 Update</button>
        </div>
    </form>
</div></div>
@endsection

@section('scripts')
<script>
const taList = @json($tahunAkademikList->map(fn($ta) => ['id' => $ta->id, 'tahun' => $ta->tahun_akademik, 'semester' => $ta->semester]));

function syncTaId(hiddenId, tahunId, semesterId) {
    const tahun   = document.getElementById(tahunId).value;
    const semester = document.getElementById(semesterId).value;
    const match = taList.find(t => t.tahun === tahun && t.semester === semester);
    document.getElementById(hiddenId).value = match ? match.id : '';
    return true;
}

function openEdit(id, taId, tahun, semester, mulai, selesai) {
    document.getElementById('editForm').action = '/keuangan/periode-billing/' + id;
    document.getElementById('e_ta_id').value = taId;
    document.getElementById('e_tahun').value = tahun;
    document.getElementById('e_semester').value = semester;
    document.getElementById('e_mulai').value = mulai;
    document.getElementById('e_selesai').value = selesai;
    document.getElementById('editModal').classList.add('active');
}

document.querySelectorAll('.modal-overlay').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('active'); }));
</script>
@endsection