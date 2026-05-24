@extends('layouts.app')
@section('title', 'Data Mahasiswa - SIDU')
@section('page-title', 'Data Mahasiswa')
@section('page-subtitle', 'Kelola data seluruh mahasiswa')
@section('sidebar-menu') @include('admin.sidebar') @endsection

@section('styles')
<style>
    .crud-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .btn-add { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; cursor:pointer; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(139,92,246,0.4); }
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.active { display:flex; }
    .modal-box { background:#fff; border-radius:18px; padding:28px; width:100%; max-width:620px; box-shadow:0 20px 60px rgba(0,0,0,0.15); animation:fadeInUp 0.3s ease; max-height:90vh; overflow-y:auto; }
    .modal-title { font-size:18px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:20px; }
    .btn-cancel { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:1px solid var(--border-color); background:#fff; color:var(--text-secondary); cursor:pointer; transition:all 0.2s; }
    .btn-cancel:hover { background:var(--purple-50); }
    .btn-submit { padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(139,92,246,0.3); }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:13px; font-weight:600; color:var(--text-secondary); margin-bottom:6px; }
    .form-control { width:100%; padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; outline:none; transition:all 0.2s; box-sizing:border-box; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    select.form-control { appearance:none; background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 14px center; padding-right:36px; }
    .form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
    .btn-action { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; font-size:14px; transition:all 0.2s; }
    .btn-edit { background:#eff6ff; color:#2563eb; } .btn-edit:hover { background:#dbeafe; }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#fee2e2; }
    .btn-detail { background:#f0fdf4; color:#16a34a; } .btn-detail:hover { background:#dcfce7; }
    .action-group { display:flex; gap:6px; }
    .mhs-cell { display:flex; align-items:center; gap:10px; }
    .mhs-cell .avatar-sm { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--purple-400),var(--purple-500)); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0; }
    .mhs-cell .avatar-sm.male { background:linear-gradient(135deg,#3b82f6,#2563eb); }
    .mhs-cell .avatar-sm.female { background:linear-gradient(135deg,#ec4899,#db2777); }
    .hint { font-size:11px; color:var(--text-muted); margin-top:4px; }
    .form-section-title { font-size:14px; font-weight:700; color:var(--text-primary); margin:18px 0 12px; padding-bottom:8px; border-bottom:1px solid var(--border-color); display:flex; align-items:center; gap:8px; }
    .form-section-title:first-of-type { margin-top:0; }
    .stats-row { display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap; }
    .mini-stat { display:flex; align-items:center; gap:10px; padding:12px 18px; background:var(--purple-50); border:1px solid var(--purple-100); border-radius:12px; flex:1; min-width:150px; }
    .mini-stat .mini-stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
    .mini-stat .mini-stat-icon.purple { background:var(--purple-100); }
    .mini-stat .mini-stat-icon.blue { background:#dbeafe; }
    .mini-stat .mini-stat-icon.green { background:#dcfce7; }
    .mini-stat .mini-stat-icon.amber { background:#fef3c7; }
    .mini-stat .mini-stat-info h4 { font-size:18px; font-weight:700; color:var(--text-primary); }
    .mini-stat .mini-stat-info span { font-size:11px; color:var(--text-muted); }
    .search-box { display:flex; align-items:center; gap:8px; }
    .search-input { padding:9px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; outline:none; width:240px; transition:all 0.2s; }
    .search-input:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    /* Detail modal */
    .detail-grid { display:grid; grid-template-columns:140px 1fr; gap:8px 16px; font-size:14px; }
    .detail-label { font-weight:600; color:var(--text-muted); }
    .detail-value { color:var(--text-primary); }
    /* Alert messages */
    .alert { padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:13px; font-weight:500; display:flex; align-items:center; gap:8px; }
    .alert-success { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
    .alert-error { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
</style>
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

{{-- Stats Row --}}
<div class="stats-row">
    <div class="mini-stat">
        <div class="mini-stat-icon purple">🎓</div>
        <div class="mini-stat-info">
            <h4>{{ $data->count() }}</h4>
            <span>Total Mahasiswa</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon blue">👦</div>
        <div class="mini-stat-info">
            <h4>{{ $data->where('jenis_kelamin', 'L')->count() }}</h4>
            <span>Laki-laki</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon green">👩</div>
        <div class="mini-stat-info">
            <h4>{{ $data->where('jenis_kelamin', 'P')->count() }}</h4>
            <span>Perempuan</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon amber">📚</div>
        <div class="mini-stat-info">
            <h4>{{ $data->pluck('prodi_id')->unique()->count() }}</h4>
            <span>Program Studi</span>
        </div>
    </div>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-error">
        ❌ <div>
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    </div>
@endif

{{-- Main Table --}}
<div class="content-card">
    <div class="content-card-header crud-toolbar">
        <h3>🎓 Daftar Mahasiswa</h3>
        <div style="display:flex;gap:10px;align-items:center;">
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari mahasiswa..." onkeyup="filterTable()">
            </div>
            <button class="btn-add" onclick="document.getElementById('addModal').classList.add('active')">➕ Tambah Mahasiswa</button>
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
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>Nilai UKT</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div class="mhs-cell">
                            <div class="avatar-sm {{ $item->jenis_kelamin === 'L' ? 'male' : 'female' }}">{{ strtoupper(substr($item->nama_mahasiswa,0,2)) }}</div>
                            <div>
                                <strong>{{ $item->nama_mahasiswa }}</strong><br>
                                <span style="font-size:12px;color:var(--text-muted)">{{ $item->user->email ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-info">{{ $item->npm }}</span></td>
                    <td>
                        {{ $item->prodi?->nama_prodi ?? '-' }}
                        <br><span style="font-size:11px;color:var(--text-muted)">{{ $item->prodi?->jurusan?->nama_jurusan ?? '' }}</span>
                    </td>
                    <td>
                        @if($item->jenis_kelamin === 'L')
                            <span class="badge badge-info">👦 Laki-laki</span>
                        @else
                            <span class="badge" style="background:#fdf2f8;color:#db2777;">👩 Perempuan</span>
                        @endif
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
                    <td style="font-weight:600">Rp {{ number_format($item->nilai_ukt, 0, ',', '.') }}</td>
                    <td>
                        <div class="action-group">
                            <button class="btn-action btn-detail" onclick="openDetail({{ $item->id }})" title="Detail">👁️</button>
                            <button class="btn-action btn-edit" onclick="openEdit({{ $item->id }})" title="Edit">✏️</button>
                            <form action="{{ route('admin.mahasiswa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data mahasiswa ini? Akun user terkait juga akan dihapus.')">@csrf @method('DELETE')<button type="submit" class="btn-action btn-delete" title="Hapus">🗑️</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data mahasiswa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal-overlay" id="addModal"><div class="modal-box">
    <div class="modal-title">🎓 Tambah Mahasiswa</div>
    <form action="{{ route('admin.mahasiswa.store') }}" method="POST">@csrf
        <div class="form-section-title">📋 Data Pribadi</div>
        <div class="form-group"><label>Nama Mahasiswa *</label><input type="text" name="nama_mahasiswa" class="form-control" placeholder="Nama lengkap mahasiswa" value="{{ old('nama_mahasiswa') }}" required></div>
        <div class="form-row-3">
            <div class="form-group"><label>NPM *</label><input type="text" name="npm" class="form-control" placeholder="2312XXXXX" value="{{ old('npm') }}" required></div>
            <div class="form-group"><label>Jenis Kelamin *</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">— Pilih —</option>
                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}"></div>
        </div>

        <div class="form-section-title">🏫 Data Akademik</div>
        <div class="form-row-2">
            <div class="form-group"><label>Program Studi *</label>
                <select name="prodi_id" class="form-control" required>
                    <option value="">— Pilih Prodi —</option>
                    @foreach($prodiList as $p)
                        <option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->kode_prodi }} — {{ $p->nama_prodi }} ({{ $p->jurusan?->nama_jurusan ?? '' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Status Akademik *</label>
                <select name="status_akademik" class="form-control" required>
                    <option value="">— Pilih —</option>
                    <option value="Aktif" {{ old('status_akademik') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ old('status_akademik') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Lulus" {{ old('status_akademik') === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="Drop Out" {{ old('status_akademik') === 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
                    <option value="Mengundurkan Diri" {{ old('status_akademik') === 'Mengundurkan Diri' ? 'selected' : '' }}>Mengundurkan Diri</option>
                </select>
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group"><label>Jalur Masuk</label><input type="text" name="jalur_masuk" class="form-control" placeholder="SNMPTN, SBMPTN, dll" value="{{ old('jalur_masuk') }}"></div>
            <div class="form-group"><label>Pendaftaran</label><input type="text" name="pendaftaran" class="form-control" placeholder="Reguler, dll" value="{{ old('pendaftaran') }}"></div>
            <div class="form-group"><label>Nilai UKT (Rp)</label><input type="number" name="nilai_ukt" class="form-control" value="{{ old('nilai_ukt', 0) }}" min="0" step="1000"></div>
        </div>

        <div class="modal-actions"><button type="button" class="btn-cancel" onclick="document.getElementById('addModal').classList.remove('active')">Batal</button><button type="submit" class="btn-submit">💾 Simpan</button></div>
    </form>
</div></div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal"><div class="modal-box">
    <div class="modal-title">✏️ Edit Mahasiswa</div>
    <form id="editForm" method="POST">@csrf @method('PUT')
        <div class="form-section-title">📋 Data Pribadi</div>
        <div class="form-group"><label>Nama Mahasiswa *</label><input type="text" name="nama_mahasiswa" id="e_nama" class="form-control" required></div>
        <div class="form-row-3">
            <div class="form-group"><label>NPM *</label><input type="text" name="npm" id="e_npm" class="form-control" required></div>
            <div class="form-group"><label>Jenis Kelamin *</label>
                <select name="jenis_kelamin" id="e_jk" class="form-control" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir" id="e_tgl" class="form-control"></div>
        </div>

        <div class="form-section-title">🏫 Data Akademik</div>
        <div class="form-row-2">
            <div class="form-group"><label>Program Studi *</label>
                <select name="prodi_id" id="e_prodi" class="form-control" required>
                    @foreach($prodiList as $p)
                        <option value="{{ $p->id }}">{{ $p->kode_prodi }} — {{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Status Akademik *</label>
                <select name="status_akademik" id="e_status" class="form-control" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Drop Out">Drop Out</option>
                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                </select>
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group"><label>Jalur Masuk</label><input type="text" name="jalur_masuk" id="e_jalur" class="form-control"></div>
            <div class="form-group"><label>Pendaftaran</label><input type="text" name="pendaftaran" id="e_daftar" class="form-control"></div>
            <div class="form-group"><label>Nilai UKT (Rp)</label><input type="number" name="nilai_ukt" id="e_ukt" class="form-control" min="0" step="1000"></div>
        </div>

        <div class="modal-actions"><button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('active')">Batal</button><button type="submit" class="btn-submit">💾 Update</button></div>
    </form>
</div></div>

{{-- DETAIL MODAL --}}
<div class="modal-overlay" id="detailModal"><div class="modal-box">
    <div class="modal-title">📄 Detail Mahasiswa</div>
    <div id="detailContent" class="detail-grid"></div>
    <div class="modal-actions"><button type="button" class="btn-cancel" onclick="document.getElementById('detailModal').classList.remove('active')">Tutup</button></div>
</div></div>
@endsection

@section('scripts')
<script>
// Store mahasiswa data for detail view (built safely via PHP)
const mahasiswaData = {};
@foreach($data as $m)
mahasiswaData[{{ $m->id }}] = {
    nama: @json($m->nama_mahasiswa),
    npm: @json($m->npm),
    jk_raw: @json($m->jenis_kelamin),
    jk: @json($m->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
    tgl_lahir_raw: @json($m->tgl_lahir ? $m->tgl_lahir->format('Y-m-d') : ''),
    tgl_lahir: @json($m->tgl_lahir ? $m->tgl_lahir->format('d M Y') : '-'),
    jalur_masuk: @json($m->jalur_masuk ?? ''),
    pendaftaran: @json($m->pendaftaran ?? ''),
    prodi_id: {{ $m->prodi_id }},
    prodi: @json($m->prodi?->nama_prodi ?? '-'),
    jurusan: @json($m->prodi?->jurusan?->nama_jurusan ?? '-'),
    status: @json($m->status_akademik),
    ukt: {{ $m->nilai_ukt ?? 0 }},
    email: @json($m->user?->email ?? '-')
};
@endforeach

function formatRupiah(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
}

function openEdit(id) {
    const m = mahasiswaData[id];
    if (!m) return;
    document.getElementById('editForm').action = '/admin/mahasiswa/' + id;
    document.getElementById('e_nama').value = m.nama;
    document.getElementById('e_npm').value = m.npm;
    document.getElementById('e_jk').value = m.jk_raw;
    document.getElementById('e_tgl').value = m.tgl_lahir_raw;
    document.getElementById('e_jalur').value = m.jalur_masuk;
    document.getElementById('e_daftar').value = m.pendaftaran;
    document.getElementById('e_prodi').value = m.prodi_id;
    document.getElementById('e_status').value = m.status;
    document.getElementById('e_ukt').value = m.ukt;
    document.getElementById('editModal').classList.add('active');
}

function openDetail(id) {
    const m = mahasiswaData[id];
    if (!m) return;
    const html = `
        <span class="detail-label">Nama</span><span class="detail-value"><strong>${m.nama}</strong></span>
        <span class="detail-label">NPM</span><span class="detail-value">${m.npm}</span>
        <span class="detail-label">Email</span><span class="detail-value">${m.email}</span>
        <span class="detail-label">Jenis Kelamin</span><span class="detail-value">${m.jk}</span>
        <span class="detail-label">Tanggal Lahir</span><span class="detail-value">${m.tgl_lahir}</span>
        <span class="detail-label">Program Studi</span><span class="detail-value">${m.prodi}</span>
        <span class="detail-label">Jurusan</span><span class="detail-value">${m.jurusan}</span>
        <span class="detail-label">Status</span><span class="detail-value">${m.status}</span>
        <span class="detail-label">Jalur Masuk</span><span class="detail-value">${m.jalur_masuk}</span>
        <span class="detail-label">Pendaftaran</span><span class="detail-value">${m.pendaftaran}</span>
        <span class="detail-label">Nilai UKT</span><span class="detail-value"><strong>${formatRupiah(m.ukt)}</strong></span>
    `;
    document.getElementById('detailContent').innerHTML = html;
    document.getElementById('detailModal').classList.add('active');
}

// Search / filter table
function filterTable() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#mahasiswaTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
}

// Close modals on overlay click
document.querySelectorAll('.modal-overlay').forEach(m => m.addEventListener('click', e => { if (e.target === m) m.classList.remove('active') }));
</script>
@endsection
