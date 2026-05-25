@extends('layouts.app')
@section('title', 'Master Data Tahun Masuk - SIDU')
@section('page-title', 'Master Data — Tahun Masuk')
@section('page-subtitle', 'Kelola data tahun masuk mahasiswa')
@section('sidebar-menu') @include('admin.sidebar') @endsection

@section('styles')
<style>
    .crud-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .btn-add { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; cursor:pointer; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(139,92,246,0.4); }
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:18px; padding:28px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.15); animation:fadeInUp 0.3s ease; }
    .modal-title { font-size:18px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:20px; }
    .btn-cancel { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; }
    .btn-submit { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:13px; font-weight:600; color:var(--text-secondary); margin-bottom:6px; }
    .form-control { width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    select.form-control { appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 14px center; padding-right:36px; }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:14px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .action-group { display:flex; gap:6px; }
</style>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success" style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#166534;font-size:14px;">
    ✅ {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:16px;color:#991b1b;font-size:14px;">
    ❌ {{ session('error') }}
</div>
@endif

<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>📆 Daftar Tahun Masuk</h3>
        <button class="btn-add" onclick="document.getElementById('addModal').classList.add('active')">➕ Tambah</button>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Masuk</th>
                    <th>Tahun Akademik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600">{{ $item->tahun }}</td>
                    <td>{{ $item->tahunAkademik ? $item->tahunAkademik->tahun_akademik : '-' }}</td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-edit" onclick="openEdit({{ $item->id }},'{{ $item->tahun }}',{{ $item->tahun_akademik_id }})">✏️</button>
                            <form action="{{ route('admin.master-data.tahun-masuk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tahun masuk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data tahun masuk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-title">📆 Tambah Tahun Masuk</div>
        <form action="{{ route('admin.master-data.tahun-masuk.store') }}" method="POST">@csrf
            <div class="form-group">
                <label>Tahun Masuk *</label>
                <input type="text" name="tahun" class="form-control" placeholder="2025" maxlength="10" required>
            </div>
            <div class="form-group">
                <label>Tahun Akademik *</label>
                <select name="tahun_akademik_id" class="form-control" required>
                    <option value="">— Pilih Tahun Akademik —</option>
                    @foreach($tahunAkademikList as $ta)
                    <option value="{{ $ta->id }}">{{ $ta->tahun_akademik }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('addModal').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-title">✏️ Edit Tahun Masuk</div>
        <form id="editForm" method="POST">@csrf @method('PUT')
            <div class="form-group">
                <label>Tahun Masuk *</label>
                <input type="text" name="tahun" id="e_tahun" class="form-control" maxlength="10" required>
            </div>
            <div class="form-group">
                <label>Tahun Akademik *</label>
                <select name="tahun_akademik_id" id="e_tahun_akademik_id" class="form-control" required>
                    <option value="">— Pilih Tahun Akademik —</option>
                    @foreach($tahunAkademikList as $ta)
                    <option value="{{ $ta->id }}">{{ $ta->tahun_akademik }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit">💾 Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openEdit(id, tahun, tahunAkademikId) {
    document.getElementById('editForm').action = '/admin/master-data/tahun-masuk/' + id;
    document.getElementById('e_tahun').value = tahun;
    document.getElementById('e_tahun_akademik_id').value = tahunAkademikId;
    document.getElementById('editModal').classList.add('active');
}
document.querySelectorAll('.modal-overlay').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('active'); }));
</script>
@endsection
