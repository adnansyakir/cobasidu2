{{-- Sidebar Admin --}}
<div class="nav-section-title">Menu Utama</div>

<a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
    <span class="nav-icon">📊</span> Dashboard
</a>

<a href="{{ route('admin.profile') }}" class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
    <span class="nav-icon">👤</span> Profile Admin
</a>

<a href="{{ route('admin.mahasiswa') }}" class="nav-item {{ request()->routeIs('admin.mahasiswa*') ? 'active' : '' }}">
    <span class="nav-icon">🎓</span> Mahasiswa
</a>

<div class="nav-dropdown {{ request()->routeIs('admin.master-data.*') ? 'open' : '' }}">
    <button class="nav-dropdown-toggle {{ request()->routeIs('admin.master-data.*') ? 'active' : '' }}">
        <span class="nav-icon">📂</span> Master Data
        <span class="nav-dropdown-arrow">▶</span>
    </button>
    <div class="nav-dropdown-menu">
        <a href="{{ route('admin.master-data.users') }}" class="nav-item {{ request()->routeIs('admin.master-data.users') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Users
        </a>
        <a href="{{ route('admin.master-data.role') }}" class="nav-item {{ request()->routeIs('admin.master-data.role') ? 'active' : '' }}">
            <span class="nav-icon">🔑</span> Role
        </a>
        <a href="{{ route('admin.master-data.tahun-akademik') }}" class="nav-item {{ request()->routeIs('admin.master-data.tahun-akademik') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Tahun Akademik
        </a>
        <a href="{{ route('admin.master-data.jurusan') }}" class="nav-item {{ request()->routeIs('admin.master-data.jurusan') ? 'active' : '' }}">
            <span class="nav-icon">🏛️</span> Jurusan
        </a>
        <a href="{{ route('admin.master-data.prodi') }}" class="nav-item {{ request()->routeIs('admin.master-data.prodi') ? 'active' : '' }}">
            <span class="nav-icon">📚</span> Prodi
        </a>
        <a href="{{ route('admin.master-data.status-pembayaran') }}" class="nav-item {{ request()->routeIs('admin.master-data.status-pembayaran') ? 'active' : '' }}">
            <span class="nav-icon">✅</span> Status Pembayaran
        </a>
        <a href="{{ route('admin.master-data.sumber-pembiayaan') }}" class="nav-item {{ request()->routeIs('admin.master-data.sumber-pembiayaan') ? 'active' : '' }}">
            <span class="nav-icon">🏦</span> Sumber Pembiayaan
        </a>
        <a href="{{ route('admin.master-data.level-ukt') }}" class="nav-item {{ request()->routeIs('admin.master-data.level-ukt') ? 'active' : '' }}">
            <span class="nav-icon">🎚️</span> Level UKT
        </a>
        <a href="{{ route('admin.master-data.tahun-masuk') }}" class="nav-item {{ request()->routeIs('admin.master-data.tahun-masuk') ? 'active' : '' }}">
            <span class="nav-icon">📆</span> Tahun Masuk
        </a>
    </div>
</div>

<div class="nav-section-title">Keuangan & Laporan</div>

<a href="{{ route('admin.invoice') }}" class="nav-item {{ request()->routeIs('admin.invoice*') ? 'active' : '' }}">
    <span class="nav-icon">💰</span> Invoice
</a>

<a href="{{ route('admin.statistik-prodi') }}" class="nav-item {{ request()->routeIs('admin.statistik-prodi') ? 'active' : '' }}">
    <span class="nav-icon">📈</span> Statistik Prodi
</a>

<a href="{{ route('admin.log-aktivitas') }}" class="nav-item {{ request()->routeIs('admin.log-aktivitas') ? 'active' : '' }}">
    <span class="nav-icon">📋</span> Log Aktivitas
</a>
