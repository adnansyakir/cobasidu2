@extends('layouts.app')

@section('title', 'Profile Mahasiswa - SIDU')
@section('page-title', 'Profile Mahasiswa')
@section('page-subtitle', 'Kelola informasi data diri Anda')

@section('sidebar-menu')
    @include('mahasiswa.sidebar')
@endsection

@section('styles')
<style>
    .profile-grid { display:grid; grid-template-columns:340px 1fr; gap:24px; align-items:start; }
    .profile-photo-card { background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:32px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.04); animation:fadeInUp 0.5s ease forwards; opacity:0; }
    .profile-avatar-wrapper { position:relative; width:130px; height:130px; margin:0 auto 20px; }
    .profile-avatar-lg { width:130px; height:130px; border-radius:50%; background:linear-gradient(135deg,var(--purple-500),var(--purple-400)); display:flex; align-items:center; justify-content:center; font-size:48px; font-weight:800; color:#fff; box-shadow:0 8px 32px rgba(139,92,246,0.3); overflow:hidden; border:4px solid #fff; }
    .profile-avatar-lg img { width:100%; height:100%; object-fit:cover; }
    .profile-avatar-wrapper .avatar-badge { position:absolute; bottom:4px; right:4px; width:32px; height:32px; border-radius:50%; background:var(--purple-500); color:#fff; border:3px solid #fff; display:flex; align-items:center; justify-content:center; font-size:14px; cursor:pointer; transition:all 0.2s; }
    .profile-photo-card h4 { font-size:18px; font-weight:700; margin-bottom:4px; }
    .role-label { display:inline-flex; padding:4px 14px; border-radius:20px; font-size:12px; font-weight:600; background:var(--purple-50); color:var(--purple-600); border:1px solid var(--purple-200); margin-bottom:16px; }
    .photo-actions { display:flex; flex-direction:column; gap:8px; margin-top:16px; }
    .btn-upload-photo { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 20px; border-radius:12px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,0.3); transition:all 0.2s; }
    .btn-delete-photo { display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:8px 16px; border-radius:10px; font-size:12px; font-weight:500; font-family:'Inter',sans-serif; cursor:pointer; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; transition:all 0.2s; }
    .photo-hint { font-size:11px; color:var(--text-muted); margin-top:8px; }
    .profile-form-card { background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:28px; box-shadow:0 1px 3px rgba(0,0,0,0.04); animation:fadeInUp 0.6s ease forwards; animation-delay:0.15s; opacity:0; }
    .form-section-title { font-size:16px; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:10px; padding-bottom:12px; border-bottom:1px solid var(--border-color); }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
    .form-row.single { grid-template-columns:1fr; }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group label { font-size:13px; font-weight:600; color:var(--text-secondary); }
    .form-group label .required { color:#dc2626; }
    .form-control { padding:10px 14px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; color:var(--text-primary); background:#fff; transition:all 0.2s; outline:none; }
    .form-control:focus { border-color:var(--purple-400); box-shadow:0 0 0 3px rgba(139,92,246,0.1); }
    .form-control.is-invalid { border-color:#dc2626; }
    textarea.form-control { min-height:80px; resize:vertical; }
    .invalid-feedback { font-size:12px; color:#dc2626; }
    .form-divider { height:1px; background:var(--border-color); margin:28px 0; }
    .btn-save { display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border-radius:12px; font-size:14px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; border:none; background:linear-gradient(135deg,var(--purple-500),var(--purple-600)); color:#fff; box-shadow:0 4px 16px rgba(139,92,246,0.3); transition:all 0.25s; }
    .btn-save:hover { transform:translateY(-2px); }
    .password-card { background:var(--bg-card); border:1px solid var(--border-color); border-radius:18px; padding:28px; margin-top:24px; box-shadow:0 1px 3px rgba(0,0,0,0.04); animation:fadeInUp 0.6s ease forwards; animation-delay:0.3s; opacity:0; }
    .info-banner { display:flex; align-items:flex-start; gap:12px; padding:14px 18px; background:linear-gradient(135deg,var(--purple-50),#f0ebff); border:1px solid var(--purple-200); border-radius:12px; margin-bottom:16px; }
    .info-banner p { font-size:13px; color:var(--purple-700); line-height:1.5; }
    @media (max-width:768px) { .profile-grid { grid-template-columns:1fr; } .form-row { grid-template-columns:1fr; } }
</style>
@endsection

@section('content')
<div class="profile-grid">
    <div class="profile-photo-card">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar-lg">
                @if($user->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil">
                @else
                    {{ strtoupper(substr($user->username, 0, 2)) }}
                @endif
            </div>
            <label for="foto_input" class="avatar-badge" title="Ganti Foto">📷</label>
        </div>
        <h4>{{ $user->nama_lengkap ?? $user->username }}</h4>
        <span class="role-label">🎓 Mahasiswa</span>
        <p class="photo-hint">{{ $user->email }}</p>
        <div class="photo-actions">
            <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                @csrf @method('PUT')
                <input type="hidden" name="username" value="{{ $user->username }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="file" name="foto_profil" id="foto_input" accept="image/*" style="display:none" onchange="document.getElementById('photoForm').submit()">
                <button type="button" class="btn-upload-photo" onclick="document.getElementById('foto_input').click()">📸 Upload Foto</button>
            </form>
            @if($user->foto_profil)
            <form action="{{ route('mahasiswa.profile.delete-photo') }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-photo" onclick="return confirm('Hapus foto?')">🗑️ Hapus Foto</button>
            </form>
            @endif
            <p class="photo-hint">JPG, PNG, GIF. Maks 2MB</p>
        </div>
    </div>

    <div>
        <div class="profile-form-card">
            <div class="form-section-title"><span>📝</span> Informasi Profil</div>
            <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label>Username <span class="required">*</span></label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="form-row single">
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" placeholder="Alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                </div>

                @if($user->mahasiswa)
                <div class="form-divider"></div>
                <div class="form-section-title"><span>🎓</span> Data Akademik</div>
                <div class="info-banner">
                    <span style="font-size:20px">ℹ️</span>
                    <p>Data akademik bersifat <strong>read-only</strong> dan hanya dapat diubah oleh bagian akademik.</p>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>NPM</label>
                        <input type="text" class="form-control" value="{{ $user->mahasiswa->npm ?? '-' }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" class="form-control" value="{{ $user->mahasiswa->prodi->nama_prodi ?? '-' }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input type="text" class="form-control" value="{{ ($user->mahasiswa->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Status Akademik</label>
                        <input type="text" class="form-control" value="{{ $user->mahasiswa->status_akademik ?? '-' }}" disabled>
                    </div>
                </div>
                @endif

                <div style="margin-top:20px;">
                    <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <div class="password-card">
            <div class="form-section-title"><span>🔒</span> Ubah Password</div>
            <form action="{{ route('mahasiswa.profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-row single">
                    <div class="form-group">
                        <label>Password Lama <span class="required">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Password Baru <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div style="margin-top:20px;">
                    <button type="submit" class="btn-save">🔐 Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
