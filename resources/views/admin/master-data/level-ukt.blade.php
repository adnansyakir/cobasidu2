@extends('layouts.app')
@section('title', 'Level UKT - SIDU')
@section('page-title', 'Master Data — Level UKT')
@section('page-subtitle', 'Kelola level UKT untuk pengelompokan biaya')
@section('sidebar-menu') @include('admin.sidebar') @endsection

@section('styles')
<style>
    .crud-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .btn-add { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; cursor:pointer; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-2px); }
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:18px; padding:28px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.15); animation:fadeInUp 0.3s ease; }
    .modal-title { font-size:18px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:20px; }
    .btn-cancel { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; }
    .btn-submit { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:13px; font-weight:600; color:var(--text-secondary); margin-bottom:6px; }
    .form-control { width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; box-sizing:border-box; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:14px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .action-group { display:flex; gap:6px; }
    textarea.form-control { resize:vertical; min-height:80px; }
</style>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>🎚️ Daftar Level UKT</h3>
        <button class="btn-add" onclick="document.getElementById('addModal').classList.add('active')">➕ Tambah Level</button>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead><tr><th>No</th><th>Nama Level</th><th>Keterangan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600">{{ $item->nama_level }}</td>
                    <td style="color:var(--text-secondary)">{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-edit" onclick="openEdit({{ $item->id }},'{{ addslashes($item->nama_level) }}','{{ addslashes($item->keterangan) }}')">✏️</button>
                            <form action="{{ route('admin.master-data.level-ukt.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus level UKT ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data level UKT</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal-overlay" id="addModal"><div class="modal-box">
    <div class="modal-title">🎚️ Tambah Level UKT</div>
    <form action="{{ route('admin.master-data.level-ukt.store') }}" method="POST">@csrf
        <div class="form-group"><label>Nama Level *</label><input type="text" name="nama_level" class="form-control" placeholder="Level 1" required></div>
        <div class="form-group"><label>Keterangan</label><textarea name="keterangan" class="form-control" placeholder="Deskripsi level UKT..."></textarea></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="document.getElementById('addModal').classList.remove('active')">Batal</button>
            <button type="submit" class="btn-submit">💾 Simpan</button>
        </div>
    </form>
</div></div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal"><div class="modal-box">
    <div class="modal-title">✏️ Edit Level UKT</div>
    <form id="editForm" method="POST">@csrf @method('PUT')
        <div class="form-group"><label>Nama Level *</label><input type="text" name="nama_level" id="e_nama_level" class="form-control" required></div>
        <div class="form-group"><label>Keterangan</label><textarea name="keterangan" id="e_keterangan" class="form-control"></textarea></div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('active')">Batal</button>
            <button type="submit" class="btn-submit">💾 Update</button>
        </div>
    </form>
</div></div>
@endsection

@section('scripts')
<script>
function openEdit(id, nama, ket) {
    document.getElementById('editForm').action = '/admin/master-data/level-ukt/' + id;
    document.getElementById('e_nama_level').value = nama;
    document.getElementById('e_keterangan').value = ket;
    document.getElementById('editModal').classList.add('active');
}
document.querySelectorAll('.modal-overlay').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('active'); }));
</script>
@endsection
