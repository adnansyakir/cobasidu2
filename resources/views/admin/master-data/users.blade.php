@extends('layouts.app')
@section('title', 'Master Data Users - SIDU')
@section('page-title', 'Master Data — Users')
@section('page-subtitle', 'Kelola data pengguna sistem')
@section('sidebar-menu') @include('admin.sidebar') @endsection

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
    .form-control { width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    select.form-control { appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 14px center; padding-right:36px; }
    .form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:14px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .action-group { display:flex; gap:6px; }
    .user-cell { display:flex; align-items:center; gap:10px; }
    .user-cell .avatar-sm { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,var(--purple-400),var(--purple-500)); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#fff; flex-shrink:0; }
    .hint { font-size:11px; color:var(--text-muted); margin-top:4px; }
</style>
@endsection

@section('content')
<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>👥 Daftar Users</h3>
        <button class="btn-add" onclick="document.getElementById('addModal').classList.add('active')">➕ Tambah User</button>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead><tr><th>No</th><th>User</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="avatar-sm">{{ strtoupper(substr($item->username,0,2)) }}</div>
                            <div><strong>{{ $item->username }}</strong><br><span style="font-size:12px;color:var(--text-muted)">{{ $item->nama_lengkap ?? '-' }}</span></div>
                        </div>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($item->role->nama_role ?? '-') }}</span></td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-edit" onclick="openEdit({{ $item->id }},'{{ addslashes($item->username) }}','{{ addslashes($item->email) }}',{{ $item->role_id }})">✏️</button>
                            @if($item->id !== Auth::id())
                            <form action="{{ route('admin.master-data.users.destroy',$item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">@csrf @method('DELETE')<button type="submit" class="btn-action btn-delete">🗑️</button></form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="addModal"><div class="modal-box">
    <div class="modal-title">👥 Tambah User</div>
    <form action="{{ route('admin.master-data.users.store') }}" method="POST">@csrf
        <div class="form-row-2">
            <div class="form-group"><label>Username *</label><input type="text" name="username" class="form-control" required></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
        </div>
        <div class="form-row-2">
            <div class="form-group"><label>Password *</label><input type="password" name="password" class="form-control" required><p class="hint">Minimal 8 karakter</p></div>
            <div class="form-group"><label>Role *</label><select name="role_id" class="form-control" required><option value="">— Pilih Role —</option>@foreach($roles as $r)<option value="{{ $r->id }}">{{ ucfirst($r->nama_role) }}</option>@endforeach</select></div>
        </div>
        <div class="modal-actions"><button type="button" class="btn-cancel" onclick="document.getElementById('addModal').classList.remove('active')">Batal</button><button type="submit" class="btn-submit">💾 Simpan</button></div>
    </form>
</div></div>

<div class="modal-overlay" id="editModal"><div class="modal-box">
    <div class="modal-title">✏️ Edit User</div>
    <form id="editForm" method="POST">@csrf @method('PUT')
        <div class="form-row-2">
            <div class="form-group"><label>Username *</label><input type="text" name="username" id="e_username" class="form-control" required></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" id="e_email" class="form-control" required></div>
        </div>
        <div class="form-row-2">
            <div class="form-group"><label>Password Baru</label><input type="password" name="password" class="form-control"><p class="hint">Kosongkan jika tidak diubah</p></div>
            <div class="form-group"><label>Role *</label><select name="role_id" id="e_role" class="form-control" required>@foreach($roles as $r)<option value="{{ $r->id }}">{{ ucfirst($r->nama_role) }}</option>@endforeach</select></div>
        </div>
        <div class="modal-actions"><button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('active')">Batal</button><button type="submit" class="btn-submit">💾 Update</button></div>
    </form>
</div></div>
@endsection

@section('scripts')
<script>
function openEdit(id,username,email,roleId){
    document.getElementById('editForm').action='/admin/master-data/users/'+id;
    document.getElementById('e_username').value=username;
    document.getElementById('e_email').value=email;
    document.getElementById('e_role').value=roleId;
    document.getElementById('editModal').classList.add('active');
}
document.querySelectorAll('.modal-overlay').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('active')}));
</script>
@endsection
