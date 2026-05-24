{{-- Sidebar Akademik --}}
<div class="nav-section-title">Menu Utama</div>

<a href="{{ route('dashboard.akademik') }}" class="nav-item {{ request()->routeIs('dashboard.akademik') ? 'active' : '' }}">
    <span class="nav-icon">📊</span> Dashboard
</a>

<a href="{{ route('akademik.profile') }}" class="nav-item {{ request()->routeIs('akademik.profile') ? 'active' : '' }}">
    <span class="nav-icon">👤</span> Profile
</a>

<a href="{{ route('akademik.mahasiswa') }}" class="nav-item {{ request()->routeIs('akademik.mahasiswa*') ? 'active' : '' }}">
    <span class="nav-icon">🎓</span> Data Mahasiswa
</a>

<div class="nav-dropdown {{ request()->routeIs('akademik.master-data.*') ? 'open' : '' }}">
    <button class="nav-dropdown-toggle {{ request()->routeIs('akademik.master-data.*') ? 'active' : '' }}">
        <span class="nav-icon">📂</span> Master Data
        <span class="nav-dropdown-arrow">▶</span>
    </button>
    <div class="nav-dropdown-menu">
        <a href="{{ route('akademik.master-data.tahun-akademik') }}" class="nav-item {{ request()->routeIs('akademik.master-data.tahun-akademik') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Tahun Akademik
        </a>
        <a href="{{ route('akademik.master-data.jurusan') }}" class="nav-item {{ request()->routeIs('akademik.master-data.jurusan') ? 'active' : '' }}">
            <span class="nav-icon">🏛️</span> Jurusan
        </a>
        <a href="{{ route('akademik.master-data.prodi') }}" class="nav-item {{ request()->routeIs('akademik.master-data.prodi') ? 'active' : '' }}">
            <span class="nav-icon">📚</span> Prodi
        </a>
    </div>
</div>
